<?php
// src/Application/CoreBundle/Security/Authentication/Provider/AuthenticationProvider.php
namespace Application\CoreBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Application\CoreBundle\Security\ModuleProvider;

class AuthenticationProvider implements AuthenticationProviderInterface {
    private $userProvider;
    private $cacheDir;
    private $container;
    private $providerKey;
    private $hideUserNotFoundExceptions;
    private $userChecker;
    private $encoderFactory;

    protected $entityManager;

    /**
     * Constructor.
     *
     * @param UserCheckerInterface $userChecker                An UserCheckerInterface interface
     * @param string               $providerKey                A provider key
     * @param Boolean              $hideUserNotFoundExceptions Whether to hide user not found exception or not
     *
     * @throws InvalidArgumentException
     */
    public function __construct(UserProviderInterface $userProvider, $cacheDir, Container $container, $providerKey, UserCheckerInterface $userChecker, EncoderFactoryInterface $encoderFactory, $hideUserNotFoundExceptions = true)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;
        $this->container    = $container;
        $this->providerKey  = $providerKey;
        $this->hideUserNotFoundExceptions = $hideUserNotFoundExceptions;
        $this->userChecker  = $userChecker;
        $this->encoderFactory = $encoderFactory;
        $this->entityManager  = $this->container->get('doctrine.orm.entity_manager');
    }

    public function authenticate(TokenInterface $token) {
        $request = $this->container->get('request');

        if (!$this->supports($token)) {
            return null;
        }

        if($request->get('_moduleSelection') != '3' && $request->get('_moduleSelection') != '4' && $request->get('_moduleSelection') != '6') {
            $username = $token->getUsername();
        } else {
            $username = $this->getSignedUsername();
        }

        if (empty($username)) {
            $username = 'NONE_PROVIDED';
        }

        try {
            $user = $this->retrieveUser($username, $token);
        } catch (UsernameNotFoundException $notFound) {
            if ($this->hideUserNotFoundExceptions) {
                throw new BadCredentialsException('Bad credentials', 0, $notFound);
            }
            $notFound->setUsername($username);

            throw $notFound;
        }

        if (!$user instanceof UserInterface) {
            throw new AuthenticationServiceException('retrieveUser() must return a UserInterface.');
        }

        try {
            $this->userChecker->checkPreAuth($user);

            if($request->get('_moduleSelection') != '3' && $request->get('_moduleSelection') != '4' && $request->get('_moduleSelection') != '6') {
                $this->checkAuthentication($user, $token);
            }
            $this->userChecker->checkPostAuth($user);
        } catch (BadCredentialsException $e) {
            if ($this->hideUserNotFoundExceptions) {
                throw new BadCredentialsException('Bad credentials', 0, $e);
            }

            throw $e;
        }

        $moduleProvider = new ModuleProvider($user, $request->get('_moduleSelection'), $this->container->get('database_connection'));
        if(!$moduleProvider->validateModule()) {
            throw new AuthenticationServiceException("No se poseen los privilegios necesarios para acceder a este m&oacute;dulo");
        }

        $authenticatedToken = new UsernamePasswordToken($user, $token->getCredentials(), $this->providerKey, $user->getRoles());
        $authenticatedToken->setAttributes($token->getAttributes());

        return $authenticatedToken;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkAuthentication(UserInterface $user, UsernamePasswordToken $token)
    {
        $currentUser = $token->getUser();
        if ($currentUser instanceof UserInterface) {
            if ($currentUser->getPassword() !== $user->getPassword()) {
                throw new BadCredentialsException('The credentials were changed from another session.');
            }
        } else {
            if ("" === ($presentedPassword = $token->getCredentials())) {
                throw new BadCredentialsException('The presented password cannot be empty.');
            }

            if (!$this->encoderFactory->getEncoder($user)->isPasswordValid($user->getPassword(), $presentedPassword, $user->getSalt())) {
                throw new BadCredentialsException('The presented password is invalid.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function retrieveUser($username, UsernamePasswordToken $token)
    {
        $user = $token->getUser();
        if ($user instanceof UserInterface) {
            return $user;
        }

        try {
            $user = $this->userProvider->loadUserByUsername($username);

            if (!$user instanceof UserInterface) {
                throw new AuthenticationServiceException('The user provider must return a UserInterface object.');
            }

            return $user;
        } catch (UsernameNotFoundException $notFound) {
            $notFound->setUsername($username);
            throw $notFound;
        } catch (\Exception $repositoryProblem) {
            $ex = new AuthenticationServiceException($repositoryProblem->getMessage(), 0, $repositoryProblem);
            $ex->setToken($token);
            throw $ex;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken && $this->providerKey === $token->getProviderKey();
    }

    /**
     * {@inheritdoc}
     */
    private function getSignedUsername() {
        $request = $this->container->get('request');
        $files   = $request->files;
        $error            = array();
        $uploadDir        = substr($this->container->get('kernel')->getRootDir(), 0, -4);

        if (null === $files->get('_digitalSignature')) {
            throw new BadCredentialsException('La firma digital no ha sido seleccionada');
        }

        if ($request->get('_password') == null) {
            throw new BadCredentialsException('La contraseña no ha sido ingresada');
        }

        /*if($files->get('_digitalSignature')->isValid()) {
            $error[] = "Error al cargar la firma digital<br /><center><b>Descripcion del Error</center></b><br />".$files->get('_digitalSignature')->getError();
        }*/

        if($files->get('_digitalSignature')->getClientMimeType() !== 'application/x-pkcs12') {
            $error[] = "El archivo seleccionado no es una llave de firma digital válida";
        }

        if(count($error) > 0) {
            $erroMessage = implode('<br />', $error);
            throw new BadCredentialsException($erroMessage);
        } else {
            
            try {
                $extension = $files->get('_digitalSignature')->guessExtension();
                if (!$extension) {
                    $extension = 'bin';
                }

                $passError = false;
                $p12cert = array();
                $fileName = rand(1, 99999);
                $filePath = $uploadDir.'/upload/firmaDigital/'.$fileName.'.'.$extension;
                $newFile = $files->get('_digitalSignature')->move($uploadDir.'/upload/firmaDigital', $fileName.'.'.$extension);
                $fileDSO = fopen($filePath, "r");
                $fileDSBuffer = fread($fileDSO, filesize($filePath));
                fclose($fileDSO);
                unlink($filePath);

                if(openssl_pkcs12_read($fileDSBuffer, $p12cert, $request->get('_password'))) {
                    $pkey_data = print_r($p12cert['pkey'],true);
                    $cert_data = print_r($p12cert['cert'],true);
                } else {
                    $passError = true;
                }

                if($passError) {
                    throw new BadCredentialsException('La contraseña es incorrecta');
                } else {
                    $cert = openssl_x509_read($cert_data);
                    $cert_data2 = openssl_x509_parse($cert);
                    $hash = $cert_data2["hash"];

                    $dql = "SELECT t01.id
                            FROM MinsalSiapsBundle:MntEmpleado t01
                            WHERE t01.firmaDigital = :firmaDigital";

                    $query = $this->entityManager->createQuery($dql);
                    $query->setParameter(':firmaDigital', $hash);
                    $idEmpleado = $query->getResult()[0]['id'];

                    if($idEmpleado == null) {
                        throw new BadCredentialsException("No se ha encontrado ningun empleado con la firma digital proporcionada");
                    } else {
                        $em = $this->entityManager;
                        $conn = $em->getConnection();
                            
                        $sql = "SELECT t01.username
                                FROM fos_user_user t01
                                WHERE t01.id_empleado = $idEmpleado
                                    AND t01.enabled = true";

                        $query = $conn->query($sql);
                        
                        if(!$query) {
                            throw new UsernameNotFoundException(sprintf('El empleado no posee usuario o no se encuentra activo.', $name));
                        } else {
                            return $query->fetchAll()[0]['username'];
                        }
                    }
                }
            } catch (\Exception $repositoryProblem) {
                $ex = new AuthenticationServiceException('Error al procesar la firma digital<br /><br /><center><b>Descripci&oacute;n del Error</b></center><br />'.$repositoryProblem->getMessage(), 0, $repositoryProblem);
                throw $ex;
                /*return ;*/
            }
        }
    }
}

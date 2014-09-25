Sistema Integral de Atención al Paciente - SIAP
====================================================
Sistema enfocado a la Atención del Paciente; que contiene todo el historial 
clínico de un paciente dentro del primer nivel de atención. Lo que permite
darle seguimiento en todas las áreas del establecimiento y así cualquier
personal autorizado pueda analizar la información clínica de un determinado 
paciente.

La intalación se divide en las siguientes etapas:

1. Instalación y configuración del entorno Web.
2. Instalación y configuración de la base de datos.
3. Instalación y configuración de JasperReports Server.
4. Instalación y configuración del SIAP.

A continuación se describen las etapas de configuración para que el SIAP pueda
funcionar en un establecimiento.

1. Instalación y configuración del entorno Web
----------------------------------------------
* Para preparar el entorno Web en Debian 7.0 "Wheezy"  es necesario instalar 
los siguientes paquetes, lo cual implica tener configurado apropiadamente el 
archivo /etc/apt/sources.list

Puede encontrar información adicional en
http://wiki.salud.gob.sv/wiki/Actualizaciones_y_sources.list

* Primero se deberán actualizar los repositorios del sistema operativo. 
Como **usuario root** escribir en una terminal:

        aptitude update && aptitude full-upgrade

* Siempre como **usuario root** ejecutar la siguiente instrucción:

        aptitude install apache2-mpm-prefork php5 php5-gd php-apc libgd2-xpm acl \
        php5-mcrypt curl git libapache2-mod-php5 php5-intl php-pear php5-cli \
        php5-pgsql postgresql openjdk-7-jdk openjdk-7-jre 
        

* Editar el archivo /etc/php5/apache2/php.ini como **usuario root**; con cualquier
editor de texto, puede ser nano o vi; ir a la sección *Module Settings* y 
modificar o agregar la línea *;date.timezone =* con lo siguiente:

        date.timezone = America/El_Salvador

* Reiniciar el servicio de Apache para que la configuración surta efecto:

	/etc/init.d/apache2 restart

2. Instalación y configuración de la base de datos
-----------------------------------------
###Configuración de PostgreSQL
* Configurar PostgreSQL para conectarse con un usuario en particular.
Editar el archivo */etc/postgresql/9.1/main/pg_hba.conf* como
**usuario root**, con cualquier editor de texto, puede ser nano o vi:

* Ir al final del archivo e identificar las siguientes líneas:

        # "local" is for Unix domain socket connections only
        local   all         all                               peer
* Cambiar el valor *peer* por *md5*. Es posible que en lugar de peer
aparezca otro valor como ident, lo importante, es que se debe cambiar a
md5. La línea debería quedar como se muestra a continuación:

        # "local" is for Unix domain socket connections only
        local   all         all                               md5
* Reiniciar el servicio de postgres con la siguiente instrucción:

        /etc/init.d/postgresql restart

###Creación del usuario
* Como **usuario postgres** ejecutar la siguiente sentencia desde consola:

        createuser -DRSP siap

###Creación de la base de datos
* Siempre como **usuario postgres** ejecutar la siguiente sentencia desde
consola:

        createdb siap -O siap

###Carga del script
* Clonar el siguiente repositorio de git como usuario normal:
	git clone http://git.salud.gob.sv/SIAPS/db_siap.git
* Entrar al directorio y realizar la carga con el archivo denominado 
**siap-prod.sql** ejecutando la siguiente sentencia como 
**usuario postgres**:

        psql -U siap -d siap -f siap-prod.sql
 
3. Instalación y configuración de JasperReports Server
-------------------------------------------------------
###Instalación
* Para poder instalar JasperReports en el proceso de instalación es necesario
la creación de ciertas bases de datos; para ello el instalador solicita la 
contraseña del usuario postgres. De manera predeterminada PostgreSQL no tiene 
asignada ninguna contraseña. Por tanto, se debe asignar una momentáneamente,
solo para este proceso. Como **usuario postgres** ejecutar:

        psql

* Aparecerá en el prompt de la consola lo siguiente:

        psql (9.1.9)
        Digite <<help>> para obtener ayuda.
        
        postgres=#

* Para cambiar la contraseña del usuario, ejecutar lo siguiente:

        ALTER USER postgres WITH PASSWORD 'postgres';

* Al presionar ENTER aparecerá abajo de la línea digitada anteriormente lo 
siguiente:

        ALTER ROLE

* Salir de la consola de PostgreSQL presionando CTRL+D o escribiendo exit.

* Se debe copiar el instalador de 64 bits del JasperReports Server 
proporcionado en el **home** del usuario **root**; y como **usuario root** se procede a 
dar permisos de ejecución al archivo con la siguiente sentencia:

        chmod u+x jasperreports-server-cp-5.x.x-linux-x64-installer.run

* Siempre como usuario root se procederá a la instalación con la siguiente 
sentencia:

        ./jasperreports-server-cp-5.x.x-linux-x64-installer.run

* Lo primero que se pide es leer la licencia de acuerdo de JasperReports
Server. Presionar ENTER hasta terminar toda la licencia; luego se procede a 
aceptar los términos de la licencia tecleando **y** y presionar ENTER.
* Preguntará la opción de instalación que se desea,  presionar el número **2** 
para seleccionar la opción **Custom Install (Instalación Personalizada)**. 
* Se procede a seleccionar la ruta de instalación del JasperReports; de manera
predeterminada el instalador propone **/opt**, para seleccionar esta 
opción solo presionar ENTER.
* El siguiente paso es relacionado al servidor **Apache Tomcat**, el instalador 
propone instalar este servicio junto con su servidor. Presionar el número **1** 
para seleccionar la opción **I want to use the bundled Tomcat (Deseo utilizar 
el paquete Tomcat)**.
* El instalador pregunta si se desea instalar el **SGDB Postgresql** o utilizar 
uno ya instalado. Para esta opción presionar el número **2** que indica la
opción **I want to use an existing PostgreSQL database**.
* Luego el instalador indica que se desea instalar nuevas bases de datos,
pregunta si se desean sobrescribir si en caso existieran. Presionamos la tecla 
**y**.
* Se procede a la configuración de los servicios, tanto los nuevos a instalar 
como los instalados anteriormente. Primero preguntará el puerto por el que
escuchará **Apache Tomcat**, se dejará el predeterminado **8080**, sólo presionar 
ENTER.
* La siguiente configuración es la del puerto por el cual se apagará **Apache
Tomcat**, se dejará el predeterminado **8005** presionar ENTER.
* Luego se debe de especificar el directorio en donde se encuentran los 
archivos binarios de PostgreSQL. Los archivos binarios que necesita son: *psql,
pg_restore, vacuumdb*. Estos archivos se encuentran ubicados en la ruta 
**/usr/bin/** por lo tanto se debe digitar esta ruta en el prompt y presionar 
ENTER.
* Se procede a configurar los parámetros específicos de la base de datos. La
primera pregunta es escribir la IP o el Host de PostgreSQL, el instalador
sugiere la IP 127.0.0.1 cambiar por la palabra **localhost**.
* La segunda opción es el puerto del gestor, el predeterminado es **5432** 
basta con presionar ENTER.
* Como última opción para la configuración de PostgreSQL se pide la contraseña 
asignada al usuario postgres, para este paso se debe de escribir la contraseña 
cambiada en el primer paso; es decir escribir **postgres**. La contraseña se 
deberá escribir dos veces para confirmar que la contraseña es correcta.
* Ahora el instalador pregunta si se desea instalar las bases de datos de
ejemplo; en este caso no son necesarias, presionar **n** y luego 
ENTER.
* Los pasos anteriores son para la preparación de la 
instalación, en este último paso vamos a confirmar el inicio de la instalación 
para realizar esta acción presionar **y** y luego ENTER.
* Con este paso se procede a la instalación. Aparecerá una barra de progreso 
de la instalación. Este paso puede tardar algunos minutos, por favor no 
presionar ninguna tecla ni cancelar la instalación. Esperar hasta que el 
instalador realice la siguiente pregunta:

        For more information please visit: www.jaspersoft.com/heartbeat
* Presionar el tecla **n** y luego ENTER para finalizar la instalación.
* Ahora se procede a iniciar el servicio de JasperReports, para estar seguros
que la instalación se ha realizado correctamente. Como **usuario root**
ubicarse en el directorio de instalación de JaspeReports Server que es 
**/opt/jasperreports-server-cp-5.x.x/** con la siguiente sentencia:

        cd /opt/jasperreports-server-cp-5.x.x

* Ejecutar la siguiente sentencia para iniciar el servicio:

        ./ctlscript.sh start

* Abrir el navegador de su preferencia e ir a la siguiente URL
http://localhost:8080/jasperserver/login.html deberá aparecer la pantalla 
de inicio de sesión. Para iniciar sesión como el usuario administrador en el 
área de inicio de sesión escribir la siguiente información: *usuario->
jasperadmin ; contraseña -> jasperadmin*.

###Carga de los reportes
* Para importar los reportes necesarios para la instalación de los módulos del 
SIAP como **usuario root** ubicarse en la carpeta de instalación de 
**JasperReports Server** y entrar al directorio *buildomatic*  con la siguiente 
sentencia:

        cd /opt/jasperreports-server-cp-5.x.x/buildomatic

* Copiar en este directorio el archivo ZIP proporcionado con todos los reportes
utilizados y ejecutar:

        ./js-import.sh --input-zip NOMBRE_DEL_ARCHIVO.zip --update

* Esperar a que termina de importar los reportes y al terminar quitarle la 
contraseña al usuario postgresql siempre como **usuario postgres**

        psql
        psql (9.1.9)
        Digite <<help>> para obtener ayuda.
        
        postgres=#ALTER USER postgres WITH PASSWORD '';
        ALTER ROLE
        postgres=#\q

###Crear script para iniciar JasperReports con el sistema
* Para que al reiniciar el sistema JasperReports pueda iniciar automáticamente 
se debe de crear un script para que realice esta acción. Para ello como 
**usuario root** ubicarse en el directorio **/etc/init.d/** en donde se 
creara un archivo denominado **jasperreports** con el siguiente contenido:

        #!/bin/sh

        ### BEGIN INIT INFO
        # Provides:          jasperreports
        # Required-Start:    $all
        # Required-Stop:     $local_fs $syslog
        # Default-Start:     2 3 4 5
        # Default-Stop:      0 1 6
        # Short-Description: starts the the Jasper Reports service
        # Description:       starts Jasper Reports using start-stop-daemon
        ### END INIT INFO
        # Inicia el servicio de JasperServer
        case "$1" in
        'start')
	        /opt/jasperreports-server-cp-5.x.x/ctlscript.sh start
	        ;;
        'stop')
	        /opt/jasperreports-server-cp-5.x.x/ctlscript.sh stop
	        ;;
        'restart')
        	/opt/jasperreports-server-cp-5.x.x/ctlscript.sh restart
        	;;
        *)
	echo "Usage: $0 { start | stop | restart }"
	;;
        esac
        exit 0

* Guardar el archivo. Ahora se procede a configurar el servicio en
el sistema, esto se realiza con la siguiente sentencia: 

        insserv jasperreports

* Luego ejecutar la siguiente sentencia para verificar si se creo correctamente el 
servicio:

        ls /etc/rc* | grep jasperreports

###Cambiar contraseña de JasperReports
* Para cambiar la contraseña del usuario administrador de JasperReports se 
debe iniciar sesión con el usuario descrito en el apartado anterior. Desde el 
menú dirigirse a Administrar → Usuarios y editar al usuario con la nueva 
contraseña.


4. Instalación y configuración del SIAP.
---------------------------------------
La instalación puede realizarse de dos formas:

* Clonando el proyecto desde el servidor git.salud.gob.sv
* Copiando el proyecto directamente en el directorio raiz.

###Clonando el proyecto desde el servidor git.salud.gob.sv
* Clonar el repositorio **gitolite@git-externo.salud.gob.sv/siap**
* Descargar el el archivo **composer.phar** como **usuario normal** con la
siguiente sentencia:

        curl -s https://getcomposer.org/installer | php

* Si se es un usuario para **desarrollo** se puede realizar una de las siguientes 
opciones:
 * Crear una nueva rama para trabajar en ella con la siguiente sentencia:

        git checkout -b nombreRama

 * Si ya se posee una rama simplemente cambiar de rama con la siguiente
sentencia:

        git checkout nombreRama

* Si es para **producción** no realizar cambio de rama y permanecer en la rama 
master.
* Agregar el archivo **parameters.yml** en el directorio **app/config/** con el 
siguiente contenido:

        parameters:
            database_driver: pdo_pgsql
            database_host: nombreHost
            database_port: ''
            database_name: nombreBase
            database_user: usuarioBase
            database_password: contraseñaBase
            mailer_transport: smtp
            mailer_host: localhost
            mailer_user: null
            mailer_password: null
            locale: es_SV
            secret: df1ca40cfc425c4f34e654696720435a044b9ca9
            database_path: null
            jasper_username: usuarioJasperServer
            jasper_password: contraseñaJasperServer
            jasper_url: http://localhost:8080/jasperserver/services/repository?wsdl   
            module1_url: http://siap.establecimiento/admin/login?_moduleSelection=1
            module2_url: http://siap.establecimiento/admin/login?_moduleSelection=2
            module3_url: http://siap.establecimiento/admin/login?_moduleSelection=3
            module4_url: http://siap.establecimiento/admin/login?_moduleSelection=4
            module5_url: http://siap.establecimiento/admin/login?_moduleSelection=5
            module6_url: http://siap.establecimiento/admin/login?_moduleSelection=6

* Cambiar los parámetros por los datos que se definieron en la creación de la 
base de datos y las variables del jasper según como se hayan configurado.Además
se deberá cambiar la palabra establecimiento por el nombre del establecimiento
a configurar.
* Crear los directorios cache/, logs/ , imagenes/ y upload/firmaDigital  con la siguiente sentencia:

        mkdir -p app/cache app/logs web/imagenes upload/firmaDigital

* Siempre como **usuario normal** ejecutar:

         php composer.phar install

* Aplicar las acl al directorio cache y logs:

        setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache/ app/logs/ web/imagenes upload/firmaDigital
        setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache/ app/logs/ web/imagenes upload/firmaDigital

* Limpiar cache de producción con la siguiente instrucción:
    php app/console cache:clear --env=prod

* Agregar los estilos y javascript a producción con la siguiente instrucción:
    php app/console assets:install --symlink --env=prod

###Creando el Virtual Host
* Como **usuario root** ejecutar:

        grep NameVirtualHost /etc/apache2/ports.conf

* Aparecerá algo similar a lo siguiente:

 1. NameVirtualHost 192.168.1.1:80
 2. NameVirtualHost *:80

* El caso 1 indica que NameVirtualHost está configurado en la IP 192.168.1.1 en
el puerto 80. Para el caso 2, NameVirtualHost está configurado para todas las 
direcciones IP configuradas en el servidor en el puerto 80. Esta dirección IP
se repetirá en cada VirtualHost que se cree. Por lo que es importante colocar
el valor indicado.
* Como usuario root, moverse a la carpeta:

        cd /etc/apache2/sites-available/

* Con un editor de texto crear el archivo **siap.establecimiento** con el siguiente
contenido:

        # Inicio del archivo
        <VirtualHost VARIABLE_RETORNADA>
        ServerName siap.establecimiento
        DocumentRoot /var/www/siap/web  ##Esta debe ser la ruta donde está el proyecto, no olvidar borrar esta linea!
        DirectoryIndex app.php
        <Directory /var/www/siap/web >  ##Esta debe ser la ruta donde está el proyecto, no olvidar borrar esta linea!
                Options FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/siap.establecimiento-error.log
        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn
        CustomLog ${APACHE_LOG_DIR}/siap.establecimiento-access.log combined
        </VirtualHost>
        # Fin del archivo

* Guardar el archivo. Luego, como **root** ejecutar:

        a2ensite siap.establecimiento

* Habilitar el modo de reescritura con la siguiente sentencia:

        a2enmod rewrite

* Reiniciar el servicio de Apache

        /etc/init.d/apache2 restart

* Se debe agregar en el archivo **/etc/hosts** la IP junto con el ServerName 
del Virtual Host. La línea debe ser similar a la siguiente:

        X.X.X.X       siap.establecimiento

* Para el caso de todas las maquinas clientes. Agregar la línea anterior en el 
archivo **/etc/hosts** para que puedan acceder al sistema.
*Configurar Iceweasel para poder visualizar los reportes en la ventana del navegador. Abrir en el menú de 
Herramientas la opción "Editar" y seleccionar "Preferencias". Aparecerá una ventana en donde se debe seleccionar
la opción "Aplicaciones" luego en el campo de búsqueda digitar "pdf", deberá aparecer en el tipo de contenido
Portable Document Format(PDF) y en la acción debe seleccionarse "Previsualizar en Iceweasel".
* Probar desde un navegador (recomendado Iceweasel/Firefox) la siguiente url: 
*http://siap.establecimiento/* y deberá aparecer la página de inicio de sesión del 
sistema.


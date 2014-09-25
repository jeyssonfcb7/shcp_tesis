<?php
// src/Minsal/SiapsBundle/EventListener/CalendarEventListener.php  

namespace Minsal\SiapsBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;

class CalendarEventListener {
    private $entityManager;
    private $entityEvents = null;
    private $allDay = null;
    private $bgColor = null;
    private $fgColor = null;
    private $url = null;
    private $cssClass = null;


    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function loadEvents(CalendarEvent $calendarEvent) {
        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');

        if(count($this->entityEvents) > 0 && $this->entityEvents !== null) {
        	foreach($this->entityEvents as $entityEvent) {
	            // create an event with a start/end time, or an all day event
	            if ($entityEvent['endDate'] !== null) {
	                $eventEntity = new EventEntity($entityEvent['title'], $entityEvent['startDatetime'], $entityEvent['endDatetime']);
	            } else {
	                $eventEntity = new EventEntity($entityEvent['title'], $entityEvent['startDatetime'], null, true);
	            }

	            if($this->allDay !== null)
	            	$eventEntity->setAllDay($this->allDay); // default is false, set to true if this is an all day event
	            
	            if($this->bgColor !== null)
	            	$eventEntity->setBgColor($this->bgColor); //set the background color of the event's label

	            if($this->fgColor !== null)
			    	$eventEntity->setFgColor($this->fgColor); //set the foreground color of the event's label
			    	
			    if($this->url !== null)
			    	$eventEntity->setUrl($this->url); // url to send user to when event label is clicked
			    
			    if($this->cssClass !== null)
			    	$eventEntity->setCssClass($this->cssClass); // a custom class you may want to apply to event labels

	            //finally, add the event to the CalendarEvent for displaying on the calendar
	            $calendarEvent->addEvent($eventEntity);
	        }
        }
    }

    public function setQueryBuilder($entityEvents) {
    	$this->entityEvents = $entityEvents;
    }

    public function setAllDay($allDay) {
    	$this->allDay = $allDay;
    }

    public function setBgColor($bgColor) {
    	$this->bgColor = $bgColor;
    }

    public function setFgColor($fgColor) {
    	$this->fgColor = $fgColor;
    }

    public function setUrl($url) {
    	$this->url = $url;
    }

    public function setCssClass($cssClass) {
    	$this->cssClass = $cssClass;
    }
}

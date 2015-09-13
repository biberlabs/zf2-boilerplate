<?php
/**
 * Event Type Log Processor
 *
 * @since     Sep 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Core\Log\Processor;

use Zend\Log\Processor\ProcessorInterface;

class EventType implements ProcessorInterface
{
    const EVENT_TYPE_APPLICATION = 'APPLICATION';
    const EVENT_TYPE_EXCEPTION   = 'EXCEPTION';
    
    /**
     * Add additional information to the event. (Event type.)
     *
     * @param array $event
     * @return array
     */
    public function process(array $event) {

        $type = self::EVENT_TYPE_APPLICATION;
        if(!isset($event['extra'])) {
            $event['extra'] = array('event_type' => $type);
            return $event;
        }

        $extra = $event['extra'];
        if(isset($extra['exception']) && $extra['exception'] instanceof \Exception) {
            $type = self::EVENT_TYPE_EXCEPTION;
        }
        
        $event['extra']['event_type'] = $type;
        return $event;
    }
}
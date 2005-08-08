<?php

class LoggerMap
{
    /**
     * An hash table which couples a (int, string, string) to an string or 
     * object. 
    **/
    private $map;


    /**
     * Add an entry to the map.
    **/
    public function addObject( $eventType, $eventSources, $eventCategories, $object)
    {
    }

    /**
     * Get an object. Return null if object is not present.
    **/
    public function getObject( $eventType, $eventSources, $eventCategories )
    {
    }
}

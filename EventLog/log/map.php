<?php

class ezcLogMap
{
    /**
     * An hash table which couples a (int, string, string) to an mixed variable.
    **/
    private $map;


    /**
     * Add an entry to the map.
     * @return void
    **/
    public function addObject( $eventType, $eventSources, $eventCategories, $mixed)
    {
    }

    /**
     * Get an mixed variable. Return null if variable is not set.
     * @return mixed.
    **/
    public function getObject( $eventType, $eventSources, $eventCategories )
    {
    }
}

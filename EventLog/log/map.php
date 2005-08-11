<?php
/**
 * File containing the ezcLogMap class.
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Map a mixed variable to an eventType, eventSource, and eventCategory.
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcLogMap
{
    /**
     * An hash table which binds an (int, string, string) to an mixed variable.
     */
    protected $map;


    /**
     * Add an entry to the map.
     * 
     * @param integer $eventTypeMask
     * @param array(string) $eventSources
     * @param array(string) $eventCategories
     * @param mixed $mixed
     *
     * @return void
     */
    public function addObject( $eventTypeMask, $eventSources, $eventCategories, $mixed)
    {
    }

    /**
     * Get an mixed variable. Return null if variable is not set.
     *
     * @param integer $eventType
     * @param string eventSources
     * @param string eventCategories
     *
     * @return mixed.
     */
    public function getObject( $eventType, $eventSources, $eventCategories )
    {
    }
}

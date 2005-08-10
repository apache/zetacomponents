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
     * An hash table which couples a (int, string, string) to an mixed variable.
     */
    private $map;


    /**
     * Add an entry to the map.
     * @return void
     */
    public function addObject( $eventType, $eventSources, $eventCategories, $mixed)
    {
    }

    /**
     * Get an mixed variable. Return null if variable is not set.
     * @return mixed.
     */
    public function getObject( $eventType, $eventSources, $eventCategories )
    {
    }
}

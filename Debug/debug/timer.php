<?php

/**
 * File containing the ezcDebugTimer class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/** 
 * The ezcDebugTimer class keeps track of several timers. 
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */ 
class ezcDebugTimer
{
    /**
     * @var array  A nice internal structure which stores sources, groups, and timers.
     */
    private $timer = array();

	public function __construct()
	{
	}

    public function startTimer($name, $source, $group)
    {
    }

    /** 
     * Stores the time from the running timer, and starts a new timer.
     * 
     * @param string $newName   Name of the new timer. 
     * @param string $oldName   The previous timer that must be stopped. 
     *                          Only needed when multiple timers are running. 
     */
    public function switchTimer( $newName, $oldName = false )
    {
    }

    /**
     * Stop the timer
     *
     * @param $name Need to supply a name only when multiple timers are running.
     */ 
    public function stopTimer( $name = false )
    {
    }
 

    /**
     * Returns an array with the used sources, groups, and timers. 
     *
     * @return array 
     */
    public function getTimers()
    {
    }

}

?>

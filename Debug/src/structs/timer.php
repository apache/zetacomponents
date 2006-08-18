<?php

/**
 * File containing the ezcDebugTimerStruct.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 *
 * The ezcDebugTimerStruct structure keeps track of the timing data.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugTimerStruct extends ezcBaseStruct
{
    /**
     * The name of the timer.
     *
     * The name has two purposes:
     * - The (unique) identifier of the running timer.
     * - The description of the timer in the timer summary. 
     * 
     * @var string
     */
    public $name;   

    /** 
     * The source of the timer.
     *
     * @var string
     */
    public $source;   

    /** 
     * The group of the timer.
     *
     * @var string
     */
    public $group;   

    /**
     * An array that contains the switchTimer structures.
     *
     * @var array(ezcDebugSwitchTimerStruct)
     */
    public $switchTime;   

    /**
     * The start time in miliseconds.
     * 
     * @var float
     */
    public $startTime;   

    /**
     * The stop time in miliseconds.
     * 
     * @var float
     */
    public $stopTime;   

    /**
     * The time that elapsed between the startTimer and the stopTimer.
     *
     * @var float
     */
    public $elapsedTime;   

    /**
     * The number of the timer that started.
     * 
     * @var int
     */
    public $startNumber;   
    
    /**
     * The number of the timer that stopped.
     *
     * @var int
     */
    public $stopNumber;   
}

?>

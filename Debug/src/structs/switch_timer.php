<?php

/**
 * File containing the ezcDebugSwitchTimerStruct.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 *
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugSwitchTimerStruct
{
    /**
     * The name of the timer took over the old timer.
     *
     * @var string
     */ 
    public $name;   

    /** 
     * The current time.
     *
     * @var float
     */
    public $time;   

    /** 
     * Empty constructor
     */
    public function __construct()
    {
    }

    /**
     * Throws a BasePropertyNotFound exception.
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Throws a BasePropertyNotFound exception.
     */
    public function __get( $name )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }
}

?>

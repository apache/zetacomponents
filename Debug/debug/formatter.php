<?php

/**
 * File containing the ezcDebugFormatter class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/** 
 * Every class that implements this interface can be used to format
 * timer and writer data to a string. 
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */ 
interface ezcDebugFormatter
{
    /**
     * Returns an string containing the formatted output.
     *
     * @param array $timerData
     * @param array $writerData
     */
	function formatter($timerData, $writerData);
}

?>

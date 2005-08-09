<?php
/**
 * File containing the ezcLogContext class.
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
**/

/**
 * Stores and checks the eventTypeContexts and eventSourceContexts.
 * 
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
**/
class ezcLogContext
{

    private $typeContexts;

    private $sourceContexts;

    /**
     * Remove all contexts. 
    **/
    public function reset()
    {
    }

    /**
     * Set the context for an eventType. These events are hardcoded. 
     *
     * @param int $eventTypeMask    
     *      Bit pattern for the eventType assigned to a context. 
     * @param array $context
     *      Array with strings.
    **/
    private function setEventTypeContext( $eventTypeMask, $context )
    {
    }

    /**
     * Set the context for an eventType. 
     *
     * @param int $eventSource Bit pattern for the eventType assigned to a 
     *                         context. 
     * @param array $context   Array with strings.
    **/
    public function setSourceContext( $eventSource, $context )
    {
    }

    /**
     * Check the context.
     * @return bool The value true if the context is correct, otherwise false.
     */
    public function getContext( $eventType, $eventSource ) 
    {
    }

}


?>

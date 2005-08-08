<?php

/**
 * Stores and checks the eventTypeContexts and eventSourceContexts.
 * 
 *
 * @package Logger
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//
**/
class Context
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
     * Set the context for an eventType. 
     *
     * @param int $eventTypeMask    
     *      Bit pattern for the eventType assigned to a context. 
     * @param array $context
     *      Array with strings.
    **/
    public function setEventTypeContext( $eventTypeMask, $context )
    {
    }

    /**
     * Set the auto context for an eventType. 
     *
     * @param int $eventTypeMask    
     *      Bit pattern for the eventType assigned to a context. 
     * @param array $context
     *      Hash which maps a string to an function. For example
     *      getCurrentUrl(), getCurrentUser(), etc.
     */
    public function setEventTypeAutoContext( $eventTypeMask, $context )
    {
    }

    /**
     * Set the context for an eventType. 
     *
     * @param int $eventTypeMask    
     *      Bit pattern for the eventType assigned to a context. 
     * @param array $context
     *      Array with strings.
    **/
    public function setEventSourceContext( $eventSource, $context )
    {
    }

    /**
     * Set the auto context for an eventType. 
     *
     * @param int $eventTypeMask    
     *      Bit pattern for the eventType assigned to an auto context. 
     * @param array $context
     *      Hash which maps the bit pattern to an function.
    **/
    public function setEventSourceAutoContext( $eventSource, $context )
    {
    }

    /**
     * Check the context.
     * @return bool The value true if the context is correct, otherwise false.
     */
    public function checkContext( $eventType, $eventSource, $context ) 
    {
    }

    /**
     * @return array Returns an hash which contains the auto contexts.
    **/
    public function getAutoContexts( $eventType, $eventSource )
    {
    }
}


?>

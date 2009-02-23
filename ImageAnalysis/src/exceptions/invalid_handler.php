<?php
/**
 * File containing the ezcImageAnalyzerInvalidHandlerException.
 * 
 * @package ImageAnalysis
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * A registered handler class does not exist or does not inherit from ezcImageAnalyzerHandler.
 *
 * @package ImageAnalysis
 * @version //autogen//
 */
class ezcImageAnalyzerInvalidHandlerException extends ezcImageAnalyzerException
{
    /**
     * Creates a new ezcImageAnalyzerInvalidHandlerException.
     * 
     * @param string $handlerClass Invalid class name.
     * @return void
     */
    function __construct( $handlerClass )
    {
        parent::__construct( "The registered handler class '{$handlerClass}' does not exist or does not inherit from ezcImageAnalyzerHandler." );
    }
}

?>

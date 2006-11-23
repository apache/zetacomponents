<?php
/**
 * File containing the ezcImageAnalyzerInvalidHandlerException.
 * 
 * @package ImageAnalysis
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
    function __construct( $handlerClass )
    {
        parent::__construct( "The registered handler class '{$handlerClass}' does not exist or does not inherit from ezcImageAnalyzerHandler." );
    }
}

?>

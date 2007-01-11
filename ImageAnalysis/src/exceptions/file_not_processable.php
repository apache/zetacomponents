<?php
/**
 * File containing the ezcImageAnalyzerFileNotProcessableException.
 * 
 * @package ImageAnalysis
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The option name you tried to register is already in use.
 *
 * @package ImageAnalysis
 * @version //autogen//
 */
class ezcImageAnalyzerFileNotProcessableException extends ezcImageAnalyzerException
{
    function __construct( $file, $reason = null )
    {
        $reasonPart = '';
        if ( $reason )
        {
            $reasonPart = " Reason: $reason.";
        }
        parent::__construct( "Could not process file '{$file}'.{$reasonPart}" );
    }
}

?>

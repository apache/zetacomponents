<?php
/**
 * File containing the ezcImageFileNotProcessableException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a specified handler class is not available.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageFileNotProcessableException extends ezcImageException
{
    function __construct( $file, $reason = null )
    {
        $reasonPart = "";
        if ( $reason )
        {
            $reasonPart = " $reason";
        }
        parent::__construct( "Handler class '{$handlerClass}> not found.{$reasonPart}" );
    }
}

?>

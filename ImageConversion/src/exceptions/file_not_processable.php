<?php
/**
 * File containing the ezcImageFileNotProcessableException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a file could not be processed by a handler.
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
        parent::__construct( "File '{$file}' could not be processed.{$reasonPart}" );
    }
}

?>

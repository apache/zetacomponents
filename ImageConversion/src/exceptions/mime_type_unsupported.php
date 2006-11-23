<?php
/**
 * File containing the ezcImageMimeTypeUnsupportedException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a requested MIME type is not supported for input, output or input/output.
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageMimeTypeUnsupportedException extends ezcImageException
{
    function __construct( $mimeType, $direction )
    {
        parent::__construct( "Converter does not support MIME type '{$mimeType}' for '{$direction}'." );
    }
}

?>

<?php
/**
 * File containing the ezcImageFileNameInvalidException.
 * 
 * @package ImageConversion
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if a given file name contains illegal characters (', ", $).
 *
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageFileNameInvalidException extends ezcImageException
{
    function __construct( $file )
    {
        parent::__construct( "The file name <{$file}> contains an illegal character (', \", $)." );
    }
}

?>

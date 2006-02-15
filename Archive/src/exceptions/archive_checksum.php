<?php
/**
 * File containing the ezcArchiveValueException class
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception will be thrown when the checksum of the file is invalid.
 *
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveChecksumException extends ezcArchiveException
{
    function __construct( $file )
    {
        parent::__construct( "The checksum of the file <$file> is invalid." );
    }
}
?>

<?php
/**
 * File containing the ezcArchiveChecksumException class.
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception will be thrown when the checksum of the file is invalid.
 *
 * @package Archive
 * @version //autogen//
 */
class ezcArchiveChecksumException extends ezcArchiveException
{
    /**
     * Constructs a new checksum exception for the specified file.
     *
     * @param string $file
     */
    public function __construct( $file )
    {
        parent::__construct( "The checksum of the file '$file' is invalid." );
    }
}
?>

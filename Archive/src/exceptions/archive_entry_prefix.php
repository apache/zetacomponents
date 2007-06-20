<?php
/**
 * File containing the ezcArchiveEntryPrefixException class.
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * An exception for an invalid prefix of a file entry.
 * 
 * @package Archive
 * @version //autogen//
 */
class ezcArchiveEntryPrefixException extends ezcArchiveException
{
    /**
     * Constructs a new entry prefix exception for the specified file entry.
     *
     * @param string $prefix
     * @param string $fileName
     */
    public function __construct( $prefix, $fileName )
    {
        parent::__construct( "The prefix '$prefix' from the file entry '$fileName' is invalid." );
    }
}
?>

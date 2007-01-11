<?php
/**
 * File containing the ezcArchiveValueException class
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * 
 * 
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveEntryPrefixException extends ezcArchiveException
{
    function __construct( $prefix, $fileName )
    {
        parent::__construct( "The prefix '$prefix' from the file entry '$fileName' is invalid." );
    }
}
?>

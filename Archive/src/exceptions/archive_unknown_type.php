<?php
/**
 * File containing the ezcArchiveUnknownTypeException class.
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown when encountering an archive of an unknow type.
 *
 * @package Archive
 * @version //autogen//
 */
class ezcArchiveUnknownTypeException extends ezcArchiveException
{
    /**
     * Constructs a new unknown type exception for the specified archive.
     *
     * @param string $archiveName
     */
    public function __construct( $archiveName )
    {
        parent::__construct( "The type of the archive '$archiveName' cannot be determined." );
    }
}
?>

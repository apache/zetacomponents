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
 * Exception will be thrown when the prefix given to the file that should be appended, is incorrect. 
 *
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveUnknownTypeException extends ezcArchiveException
{
    function __construct( $archiveName )
    {
        parent::__construct( "The type of the archive <$archiveName> cannot be determined." );
    }
}
?>

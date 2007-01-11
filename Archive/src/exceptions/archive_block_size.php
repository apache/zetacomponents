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
 * Exception will be thrown when the prefix given to the file that should be appended, is incorrect. 
 *
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveBlockSizeException extends ezcArchiveException
{
    function __construct( $archiveName, $msg = null )
    {
        $default = "The archive '$archiveName' has an invalid block size.";

        if ( $msg !== null )
        {
            $default .= " $msg";
        }

        parent::__construct( $default );
    }
}
?>

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
 * Archive is empty.
 * 
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveEmptyException extends ezcArchiveException
{
    /**
     * Construct an archive is empty exception.
     *
     * @param string $message
     * @param int $code
     */
    function __construct(  )
    {
        $msg = "The archive is empty.";

        parent::__construct( $msg );
    }
}
?>

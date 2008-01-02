<?php
/**
 * File containing the ezcArchiveIoException class.
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown when an IO error occurs.
 *
 * @package Archive
 * @version //autogen//
 */
class ezcArchiveIoException extends ezcArchiveException
{
    /**
     * Constructs a new IO exception.
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

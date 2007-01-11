<?php
/**
 * File containing the ezcArchiveInternalException class
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * General exception class for the Archive package.
 * 
 * @package Archive
 * @version //autogen//
 */
class ezcArchiveInternalException extends ezcArchiveException
{
    /**
     * Construct an internal archive exception.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct( $message )
    {
        parent::__construct( "Internal error: " . $message );
    }

}
?>

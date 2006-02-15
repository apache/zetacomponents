<?php
/**
 * File containing the ezcFileWriterException class
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * General exception class for the Archive package.
 * 
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveException extends Exception
{
    /**
     * Construct an archive exception.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }

}
?>

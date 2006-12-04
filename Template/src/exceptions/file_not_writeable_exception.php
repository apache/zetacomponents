<?php
/**
 * File containing the ezcTemplateFileNotWriteableException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception for problems when writing to template files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateFileNotWriteableException extends Exception
{
    /**
     *
     * @param string $stream The stream path to the template file which could not be
     * written.
     */
    public function __construct( $stream, $type = "template file" )
    {
        parent::__construct( "The requested {$type} '{$stream}' is not writeable." );
    }
}
?>

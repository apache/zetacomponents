<?php
/**
 * File containing the ezcTemplateFileNotReadableException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception for problems when reading from template files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateFileNotReadableException extends ezcTemplateException
{
    /**
     * Initialises the exception with the template file path.
     *
     * @param string $stream The stream path to the template file which could not be
     * read.
     */
    public function __construct( $stream )
    {
        parent::__construct( "The requested template file '$stream' is not readable." );
    }
}
?>

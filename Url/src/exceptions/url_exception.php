<?php
/**
 * File containing the ezcUrlException class
 *
 * @package Url
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcUrlExceptions are thrown when an exceptional state
 * occures in the Url package.
 *
 * @package Url
 * @version //autogen//
 */
class ezcUrlException extends ezcBaseException
{
    /**
     * Constructs a new ezcUrlException with error message $message.
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

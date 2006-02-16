<?php
/**
 * File containing the ezcUrlPrefixNotFoundException class
 *
 * @package Mail
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcUrlPrefixNotFoundException is thrown whenever you try to use a prefix
 * that is not registered.
 *
 * @package Url
 * @version //autogen//
 */
class ezcUrlPrefixNotFoundException extends ezcUrlException
{
    /**
     * Constructs a new ezcUrlPrefixNotFoundException with error message $message.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct( $prefixName )
    {
        $message = "The path prefix: {$prefixName} could not be found.";
        parent::__construct( $message, 0 );
    }
}
?>

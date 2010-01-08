<?php
/**
 * File containing the ezcUrlNotRegisteredException class
 *
 * @package Url
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcUrlNotRegisteredException is thrown whenever you try to use a url
 * that is not registered.
 *
 * @package Url
 * @version //autogen//
 */
class ezcUrlNotRegisteredException extends ezcUrlException
{
    /**
     * Constructs a new ezcUrlNotRegisteredException.
     *
     * @param string $name
     */
    public function __construct( $name )
    {
        $message = "The url '{$name}' is not registered.";
        parent::__construct( $message );
    }
}
?>

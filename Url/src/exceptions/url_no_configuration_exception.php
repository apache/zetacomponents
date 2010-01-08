<?php
/**
 * File containing the ezcUrlNoConfigurationException class
 *
 * @package Url
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcUrlNoConfigurationException is thrown whenever you try to use a url
 * configuration that is not defined.
 *
 * @package Url
 * @version //autogen//
 */
class ezcUrlNoConfigurationException extends ezcUrlException
{
    /**
     * Constructs a new ezcUrlNoConfigurationException.
     *
     * @param string $param
     */
    public function __construct( $param )
    {
        $message = "The parameter '{$param}' could not be set/get because the url doesn't have a configuration defined.";
        parent::__construct( $message );
    }
}
?>

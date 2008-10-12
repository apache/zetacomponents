<?php
/**
 * File containing the ezcWebdavInvalidCallbackException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a plugin tries to register an invalid callback for a hook.
 *
 * If an instance of {@link ezcWebdavPluginConfiguration} returns an invalid
 * callback to {@link ezcWebdavPluginConfiguration::getHooks()}, {@link
 * ezcWebdavPluginRegistry} will throw this exception. This most propably
 * means, that the plugin you try to configure is malicious or works only with
 * a newer version of the Webdav component.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavInvalidCallbackException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $callback.
     * 
     * @param mixed $callback
     * @return void
     */
    public function __construct( $callback )
    {
        parent::__construct(
            'The variable ' . var_export( $callback, true ) . ' is not a valid callback.'
        );
    }
}



?>

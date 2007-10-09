<?php
/**
 * File containing the ezcWebdavInvalidHookException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown if a plugin tries to register for a non-existent hook.
 *
 * If an instance of {@link ezcWebdavPluginConfiguration} returns an invalid
 * class or hook name on the call to {@link
 * ezcWebdavPluginConfiguration::getHooks()}, {@link ezcWebdavPluginRegistry}
 * will throw this exception. This most propably means, that the plugin you try
 * to configure is malicious or works only with a newer version of the Webdav
 * component.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavInvalidHookException extends ezcWebdavException
{
    /**
     * Creates a new exception.
     * 
     * @param string $class
     * @param string $hook
     * @return void
     */
    public function __construct( $class, $hook = null )
    {
        if ( $hook === null )
        {
            $msg = "The class {$class} does not provide any plugin hooks.";
        }
        else
        {
            $msg = "The class {$class} does not provide a plugin hook named {$hook}.";
        }
        parent::__construct( $msg );
    }
}



?>

<?php
/**
 * File containing the ezcWebdavPluginRegistry class.
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Global plugin registry class.
 *
 * An instance of this class is request wide uniquely responsible for handling
 * plugins to the Webdav component. It has a number of different hooks
 * available of the server and transport layer of the component to allow
 * plugins to interact and integrate with these layers to add extended
 * funtionality.
 *
 * A good overview of the working of the plugin system can be found in its
 * design document {@link Webdav/design/extensibility.txt}.
 *
 * @see ezcWebdavServer
 * @see ezcWebdavTransport
 * @see ezcWebdavPropertyHandler
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavPluginRegistry
{
    /**
     * Known hooks. 
     * 
     * <code>
     *      array(
     *          '<class>' => array(
     *              '<method>' => <bitmask>,
     *              // ...
     *          )
     *          // ...
     *      )
     * </code>
     *
     * @var array(string=>array(string=>bool))
     */
    private $hooks = array();

    /**
     * Registered plugins. 
     *
     * <code>
     *      array(
     *          '<namespace>' => '<config-object>',
     *          // ...
     *      )
     * </code>
     * 
     * @var array(string=>ezcWebdavPluginConfiguration)
     */
    private $plugins = array();

    /**
     * Creates a new plugin registry.
     * 
     * @return void
     */
    public function __construct()
    {
        // Transport layer hooks

        // Extract parsing methods
        foreach ( ezcWebdavTransport::$parsingMap as $httpMethod => $method )
        {
            $this->createHook( 'ezcWebdavTransport', $method, 'before' );
            $this->createHook( 'ezcWebdavTransport', $method, 'after' );
        }
        // Extract handling methods
        foreach ( ezcWebdavTransport::$handlingMap as $class => $method )
        {
            $this->createHook( 'ezcWebdavTransport', $method, 'before' );
            $this->createHook( 'ezcWebdavTransport', $method, 'after' );
        }
        // Add additional Transport layer hooks
        $this->createHook( 'ezcWebdavTransport', 'processUnknownRequest' );
        $this->createHook( 'ezcWebdavTransport', 'handleUnknownResponse' );

        // Property related hooks
        $this->createHook( 'ezcWebdavTransport', 'extractLiveProperty', 'before' );
        $this->createHook( 'ezcWebdavTransport', 'extractLiveProperty', 'after' );

        $this->createHook( 'ezcWebdavTransport', 'extractDeadProperty', 'before' );
        $this->createHook( 'ezcWebdavTransport', 'extractDeadProperty', 'after' );
        
        $this->createHook( 'ezcWebdavTransport', 'serializeLiveProperty', 'before' );
        $this->createHook( 'ezcWebdavTransport', 'serializeLiveProperty', 'after' );
        
        $this->createHook( 'ezcWebdavTransport', 'serializeDeadProperty', 'before' );
        $this->createHook( 'ezcWebdavTransport', 'serializeDeadProperty', 'after' );

        $this->createHook( 'ezcWebdavTransport', 'extractUnknownLiveProperty' );
        $this->createHook( 'ezcWebdavTransport', 'serializeUnknownLiveProperty' );
        
        $this->createHook( 'ezcWebdavTransport', 'extractUnknownDeadProperty' );
        $this->createHook( 'ezcWebdavTransport', 'serializeUnknownDeadProperty' );

        // Server layer hooks

        $this->createHook( 'ezcWebdavServer', 'receivedRequest' );
        $this->createHook( 'ezcWebdavServer', 'generatedResponse' );
    }

    /**
     * Creates a new hook.
     * 
     * Helper method. Used in {@link __construct()} to create a hook. The
     * $class identifies the base class the hook is provided by, $method
     * specificies the name of the affected method of this class or a "pseudo
     * method name", if no such is available.
     * 
     * @param mixed $class 
     * @param mixed $method 
     * @param mixed $prefix 
     * @return void
     */
    private function createHook( $class, $method, $prefix = null )
    {
        $this->hooks[$class][( $prefix !== null ? $prefix . ucfirst( $method )  : $method )] = true;
    }

    /**
     * Registers a new plugin to be used.
     *
     * Receives an instance of {@link ezcWebdavPluginConfiguration}, which is
     * possible extended for internal use in the plugin. The 'namespace'
     * property of this class is used to register it internally. Multiple
     * registrations of the same namespace will lead to an exception.
     *
     * @param ezcWebdavPluginConfiguration $config
     *
     * @throws ezcWebdavPluginDoubleRegistrationException
     *         if the namespace of a plugin is registered twice.
     */
    public final function registerPlugin( ezcWebdavPluginConfiguration $config )
    {

    }


    /**
     * Can be used to deactivate a plugin.
     *
     * Receives an instance of {@link ezcWebdavPluginConfiguration}, which is
     * possible extended for internal use in the plugin. The 'namespace'
     * property of this class is used to unregister it internally.
     * Unregistration of a notregistered $config object will be silently
     * ignored.
     *
     * @param ezcWebdavPluginConfiguration $config
     */
    public final function unregisterPlugin( ezcWebdavPluginConfiguration $config )
    {

    }

    /**
     * Returns a plugins configuration object.
     *
     * Returns the instance of {@link ezcWebdavPluginConfiguration} used for
     * the plugin with a given $namespace. Throws an exception, if the plugin
     * was not found.
     * 
     * @param string $namespace 
     * @return ezcWebdavPluginConfiguration
     */
    public final function getPluginConfig( $namespace )
    {

    }

    /**
     * Returns if a plugin is active in the server.
     *
     * Checks if a configuration with the given $namespace exists and returns
     * this information as a boolean value.
     * 
     * @param string $namespace 
     * @return bool
     */
    public final function hasPlugin( $namespace )
    {

    }

    /**
     * Announces the given hook.
     *
     * This class may only be used by {@link ezcWebdavServer} and {@link
     * ezcWebdavTransport} to announce the reaching of a hook. Therefore, this
     * method is marked private. Receives the name of the class issuing the
     * $hook and the $params that may be used for information extraction and
     * _careful_ possible manipulation.
     * 
     * @param string $class
     * @param string $hook 
     * @param ezcWebdavPluginParameters $params 
     * @return void
     *
     * @throws ezcWebdavPluginFailureException
     *         in case a plugin threw an exception. The original one can be
     *         accessed for processing through the public $originalException
     *         attribute.
     */
    public final function announceHook( $class, $hook, ezcWebdavPluginParameters $params )
    {

    }
}

?>

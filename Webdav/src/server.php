<?php
/**
 * File containing the basic webdav server class
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class for creating a webdav server, capable of serving webdav requests.
 *
 * <code>
 * $server = ezcWebdavServer::getInstance();
 *
 * // Optionally register aditional transport handlers
 *   
 * // This step is only required, when a user wants to provide own 
 * // implementations for special clients.
 * $server->configurations[] = new ezcWebdavServerConfiguration(
 *     // Regular expression to match client name
 *     '(Microsoft.*Webdav\s+XP)i',
 *     // Class name of transport handler, extending ezcWebdavTransportHandler
 *     'ezcWebdavMicrosoftTransport'
 * );  
 * $server->configurations[] = new ezcWebdavServerConfiguration(
 *     // Regular expression to match client name
 *     '(.*Firefox.*)i',
 *     // Class name of transport handler, extending ezcWebdavTransportHandler
 *     'customWebdavMozillaTransport',
 *     // A custom implementation of {@link ezcWebdavXmlTool}
 *     'customWebdavXmlTool',
 *     // A custom implementation of {@link ezcWebdavPropertyHandler}
 *     'customWebdavPropertyHandler',
 *     // A custom path factory
 *     new customWebdavPathFactory()
 * );  
 *
 * // Server data using file backend with data in "path/"
 * $backend = new ezcWebdavBackendFile( '/path' );
 *
 * // Serve requests
 * $server->handle( $backend );
 * </code>
 *
 * @properties ezcWebdavServerConfigurationManager $configurations
 *             Webdav server configuration manager
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavServer
{
    /**
     * Singleton instance.
     *
     * @var ezcWebdavServer
     */
    protected static $instance;

    /**
     * Properties. 
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new instance.
     *
     * The constructor is private due to singleton reasons. Use {@link
     * self::getInstance()} and then use the properties of the server to adjust
     * it's configuration.
     * 
     * @return void
     */
    protected function __construct()
    {
        $this->reset();
    }

    /**
     * Singleton retrieval.
     *
     * The instantiation of 2 WebDAV servers at the same time does not make
     * sense. Therefore the server is a singleton and its only instance must be
     * retrieved using this method.
     * 
     * @return void
     */
    public static function getInstance()
    {
        if ( self::$instance === null )
        {
            self::$instance = new ezcWebdavServer();
        }
        return self::$instance;
    }

    /**
     * Makes the Webdav server handle the current request.
     *
     * This method is the absolute heart of the Webdav component. It is called
     * to make the server instance handle the current request. This means, a
     * {@link ezcWebdavTransport} is selected and instantiated through the
     * {@link ezcWebdavServerConfigurationManager} in {@link $this->configurations}.
     *
     * The method receives at least an instance of {@link ezcWebdavBackend},
     * which is used to server the request.
     *
     * @param ezcWebdavBackend $backend
     * @param string $uri
     * 
     * @return void
     */
    public final function handle( ezcWebdavBackend $backend, $uri = null )
    {
        $uri = ( $uri === null 
            ? 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']
            : $uri );

        // Perform final setup
        $this->properties['backend'] = $backend;
        if ( !isset( $_SERVER['HTTP_USER_AGENT'] ) )
        {
            throw new ezcWebdavMissingHeaderException( 'User-Agent' );
        }
        // Configure the server according to the requesting client
        $this->configurations->configure( $this, $_SERVER['HTTP_USER_AGENT'] );

        // Initialize all plugins
        $this->pluginRegistry->initPlugins();

        // Parse request into request object
        $request = $this->transport->parseRequest( $uri );
        
        if ( $request instanceof ezcWebdavRequest )
        {
            // Plugin hook receivedRequest
            ezcWebdavServer::getInstance()->pluginRegistry->announceHook(
                __CLASS__,
                'receivedRequest',
                new ezcWebdavPluginParameters(
                    array(
                        'request'  => $request,
                    )
                )
            );
            $response = $this->backend->performRequest( $request );
        }
        else
        {
            // The transport layer already issued an error.
            $response = $request;
        }

        // Plugin hook generatedResponse
        ezcWebdavServer::getInstance()->pluginRegistry->announceHook(
            __CLASS__,
            'generatedResponse',
            new ezcWebdavPluginParameters(
                array(
                    'response'  => $response,
                )
            )
        );

        $this->transport->handleResponse( $response );
    }

    /**
     * Initialize the server with the given objects.
     * 
     * This method is marked proteced, because it is intended to be used by by
     * {@link ezcWebdavServerConfiguration} instances and instances of derived
     * classes, but not directly.
     *
     * @param ezcWebdavPathFactory $pathFactory
     * @param ezcWebdavXmlTool $xmlTool
     * @param ezcWebdavPropertyHandler $propertyHandler
     * @param ezcWebdavTransport $transport
     * @return void
     */
    public function init(
        ezcWebdavPathFactory $pathFactory,
        ezcWebdavXmlTool $xmlTool,
        ezcWebdavPropertyHandler $propertyHandler,
        ezcWebdavHeaderHandler $headerHandler,
        ezcWebdavTransport $transport
    )
    {
        $this->properties['pathFactory']     = $pathFactory;
        $this->properties['xmlTool']         = $xmlTool;
        $this->properties['propertyHandler'] = $propertyHandler;
        $this->properties['headerHandler']   = $headerHandler;
        $this->properties['transport']       = $transport;
    }

    /**
     * Reset the server to its initial state.
     *
     * Resets the internal server state as if a new instance has just been
     * constructed.
     * 
     * @return void
     */
    public function reset()
    {
        unset( $this->properties['configurations'] );
        unset( $this->properties['pluginRegistry'] );
        $this->properties['configurations']  = new ezcWebdavServerConfigurationManager();
        $this->properties['pluginRegistry']  = new ezcWebdavPluginRegistry();

        $this->properties['transport']       = null;
        $this->properties['backend']         = null;
        $this->properties['pathFactory']     = null;
        $this->properties['xmlTool']         = null;
        $this->properties['propertyHandler'] = null;
        $this->properties['headerHandler']   = null;
    }

    /**
     * Sets a property.
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBaseValueException
     *         if the value to be assigned to a property is invalid.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a read-only property.
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'configurations':
                if ( ( $propertyValue instanceof ezcWebdavServerConfigurationManager ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavServerConfigurationManager' );
                }
                break;
            case 'backend':
            case 'pluginRegistry':
            case 'pathFactory':
            case 'xmlTool':
            case 'propertyHandler':
            case 'headerHandler':
            case 'transport':
                throw new ezcBasePropertyPermissionException( $propertyName, ezcBasePropertyPermissionException::READ );

            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Property get access.
     * Simply returns a given property.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property propertys is not an instance of
     * @param string $propertyName The name of the property to get.
     * @return mixed The property value.
     *
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a write-only property.
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) === true )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Returns if a property exists.
     * Returns true if the property exists in the {@link $properties} array
     * (even if it is null) and false otherwise. 
     *
     * @param string $propertyName Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>

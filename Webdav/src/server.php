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
 * $server = new ezcWebdavServer();
 *
 * // Server data using file backend with data in "path/"
 * $server->backend = new ezcWebdavBackendFile( '/path' );
 *
 * // Optionally register aditional transport handlers
 * //  
 * // This step is only required, when a user wants to provide own 
 * // implementations for special clients.
 * $server->registerTransportHandler(
 *     // Regular expression to match client name
 *     '(Microsoft.*Webdav\s+XP)i',
 *     // Class name of transport handler, extending ezcWebdavTransportHandler
 *     'ezcWebdavMicrosoftTransport'
 * );  
 * $server->registerTransportHandler(
 *     // Regular expression to match client name
 *     '(.*Firefox.*)i',
 *     // Class name of transport handler, extending ezcWebdavTransportHandler
 *     'ezcWebdavMozillaTransport'
 * );  
 *
 * // Serve requests
 * $server->handle();
 * </code>
 *
 * @properties ezcWebdavBackend $backend
 *             Data backend used to serve the request.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavServer
{
    /**
     * Array with available transport handlers. The key of this array is a
     * regular expression which should match the client name the handler has
     * been designed for, while the value is the name of the handler class
     * extending the basic ezcWebdavTransport class.
     *
     *  array(
     *      '(regular\s+expression)' =>
     *          'ezcWebdavSomeTransport',
     *      ...
     *  )
     * 
     * @var array
     */
    protected $transportHandlers = array(
        '(Internet\s+Explorer)' =>
            'ezcWebdavMicrosoftTransport',

        // Fall back to default handler, if none special handler matches
        '(.*)' =>
            'ezcWebdavTransport',
    );

    /**
     * Selected transport handler 
     * 
     * @var ezcWebdavTransport
     */
    protected $transport = null;

    /**
     * Array with properties of the basic server class.
     * 
     * @var array
     */
    protected $properties = array();

    /**
     * Constructor for webdav server. The used backend to use might be passed
     * right away with the constructor.
     * 
     * @param ezcWebdavBackend $backend 
     * @return void
     */
    public function __construct( ezcWebdavBackend $backend = null )
    {
        // @TODO: Implement
    }

    /**
     * Select a transport handler to use.
     *
     * The main server instance knows about available clients and has a regular
     * expression for each of them, to identify the clients it communicates to
     * by matching the regular expression against the client name provided in
     * the HTTP headers.
     *
     * The protected property $transport will contain the best matching
     * instantiated tarnsport handler after executing the method.
     * 
     * @throws ezcWebdavNotTransportHandlerException
     *         If no matching handler could be found for the current user
     *         agent.
     * @return void
     */
    protected function selectTransportHandler()
    {
        foreach ( $this->transportHandlers as $expression => $class )
        {
            if ( preg_match( $expression, $_SERVER['HTTP_USER_AGENT'] ) )
            {
                // Transport handler matches
                $this->transport = new $class();
                break;
            }
        }

        // If no handler matched throw an exception
        if ( $this->transport === null )
        {
            throw new ezcWebdavNotTransportHandlerException( $_SERVER['HTTP_USER_AGENT'] );
        }
    }

    /**
     * Actually handle request using the specified backend and matching
     * transport handlers.
     * 
     * This method will send the proper response headers and echo the request
     * response.
     *
     * You shouldn't have send any headers prior to the execution of this
     * method.
     *
     * @return void
     */
    public function handle()
    {
        $this->selectTransportHandler();

        // @TODO: Implement
    }

    /**
     * Register a new transport handler for the webdav server.
     *
     * A handler is registered by a PCRE regular expression which should match
     * the clients name the transport handler will used for. Newly added
     * handlers will be added at highest priority.
     *
     * The given handler class should extend the basic webdav transport class
     * ezcWebdavTransport.
     * 
     * @throws ezcBaseValueException
     *         If a handler class name has been provided not implementing
     *         ezcWebdavTransport.
     * @param string $expression 
     * @param string $handler 
     * @return void
     */
    public function registerTransportHandler( $expression, $handler )
    {
        // Check if handler class is an extension of the base transport
        // mechanism
        if ( !is_subclass_of( $handler, 'ezcWebdavTransport' ) )
        {
            throw new ezcBaseValueException( 'transportHandler', $handler, 'ezcWebdavTransport' );
        }

        // Use array_unshift to prepend new registrations to transport handler
        // array
        $this->transportHandlers = array_merge(
            array( $expression => $handler ),
            $this->transportHandlers
        );
    }

    /**
     * Unregister a new transport handler for the webdav server.
     *
     * Remove a handler from the handler list by its regular expression. If no
     * handler with theis expression has been registerd before, the method will
     * return false.
     * 
     * @param string $expression 
     * @return bool
     */
    public function unregisterTransportHandler( $expression )
    {
        if ( array_key_exists( $expression, $this->transportHandlers ) )
        {
            unset( $this->transportHandlers[$expression] );
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>

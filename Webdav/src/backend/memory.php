<?php
/**
 * File containing a fake memory webdav backend.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Fake backend to serve some virtual content tree, offering options to cause
 * failures in operations, mainly for testing the webdav server.
 *
 * The fake server is constructed from a multidimentional array structure
 * representing the collections and files. The metadata may only be set by
 * appropriate requests to the backend. No information is stored anywhere, so
 * that every reinitialisations gives you a fresh backend.
 *
 * <code>
 *  $backend = new ezcWebdavMemoryBackend( 
 *      array(
 *          'foo' => 'bar', // File with content "bar"
 *          'bar' => array( // Collection "bar"
 *              'blubb' => 'Some more content.'
 *                  // File bar/blubb with some more content
 *          ),
 *      )
 *  );
 * </code>
 *
 * This backend does not implement any special features to test the servers
 * capabilities to work with thos features.
 *
 * @version //autogentag//
 * @package Webdav
 * @access private
 */
class ezcWebdavMemoryBackend
    extends
        ezcWebdavBackend
    implements
        ezcWebdavBackendPut,
        ezcWebdavBackendChange,
        ezcWebdavBackendMakeCollection
{
    /**
     * Options of the memory backend
     * 
     * @var ezcWebdavMemoryBackendOptions
     */
    protected $options;

    /**
     * Content structure of memory backend
     * 
     * @var array
     */
    protected $content = array(
        '/' => array(),
    );

    /**
     * Properties for collections and ressources.
     *
     * They are stored in an array of the following form reusing the initial
     * content example:
     *
     *  array(
     *      '/foo' => array(
     *          'property name' => 'property value',
     *      ),
     *      '/bar' => array(),
     *      '/bar/blubb' => array(),
     *      ...
     *  )
     * 
     * @var array
     */
    protected $props = array();

    /**
     * Construct backend from a given path.
     * 
     * @param string $path 
     * @return void
     */
    public function __construct()
    {
        $this->options = new ezcWebdavMemoryBackendOptions();
    }

    /**
     * Offer access to some of the server properties.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If the property $name is not defined
     * @param string $name 
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'options':
                return $this->$name;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'options':
                if ( ! $value instanceof ezcWebdavMemoryBackendOptions )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcWebdavMemoryBackendOptions' );
                }

                $this->$name = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Return an initial set o fproperties for ressources and collections.
     *
     * The second parameter indicates wheather the given ressource is a
     * collection. The returned properties are used to initialize the property
     * arrays for the given content.
     * 
     * @param string $name
     * @param bool $isCollection
     * @return array
     */
    protected function initializeProperties( $name, $isCollection = false )
    {
        if ( $this->options->fakeLiveProperties )
        {
            return array(
                'creationdate'          => 1054034820,
                'displayname'           => basename( $name ),
                'getcontentlanguage'    => 'en',
                'getcontentlength'      => strlen( $this->content[$name] ),
                'getcontenttype'        => 'application/octet-stream',
                'getetag'               => md5( $name ),
                'getlastmodified'       => 1124118780,
                'resourcetype'          => null,
                'source'                => null,
            );
        }
        else
        {
            return array();
        }
    }

    /**
     * Read valid data from given content array and initialize property
     * storage.
     * 
     * @param array $contents 
     * @return void
     */
    public function addContents( array $contents, $path = '/' )
    {
        foreach ( $contents as $name => $content )
        {
            if ( !is_string( $name ) )
            {
                // Ignore elements which do not have a string key
                continue;
            }

            // Full path to ressource
            $ressourcePath = $path . $name;

            if ( is_array( $content ) )
            {
                // Collections always postpended by a slash
                $ressourcePath .= '/';

                // Content is a collection
                $this->content[$ressourcePath] = array();
                $this->props[$ressourcePath] = $this->initializeProperties(
                    $ressourcePath,
                    true
                );

                // Recurse
                $this->addContents( $content, $ressourcePath );
            }
            elseif ( is_string( $content ) )
            {
                // Content is a file
                $this->content[$ressourcePath] = $content;
                $this->props[$ressourcePath] = $this->initializeProperties(
                    $ressourcePath
                );
            }
            else
            {
                // Ignore everything else...
                continue;
            }

            // Add contents to parent directory
            $this->content[$path][] = $ressourcePath;
        }
    }

    /**
     * Manually set a property on a ressource to request it later.
     * 
     * @param string $ressource 
     * @param string $propertyName 
     * @param string $propertyValue 
     * @return bool
     */
    public function setProperty( $ressource, $propertyName, $propertyValue )
    {
        // Check if ressource exists at all
        if ( !array_key_exists( $ressource, $this->props ) )
        {
            return false;
        }

        // Do not check if an existing value will be overwritten, just set
        // property
        $this->props[$ressource][$propertyName] = $propertyValue;

        return true;
    }

    /**
     * Return bitmap of additional features supported by the backend referenced
     * by constants from the basic ezcWebdavBackend class.
     * 
     * @return int
     */
    public function getFeatures()
    {
        return 0;
    }

    /**
     * Required method to serve GET requests.
     *
     * The method receives a {@link ezcWebdavGetRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any
     * other {@link ezcWebdavResponse} objects.
     * 
     * @param ezcWebdavGetRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    public function get( ezcWebdavGetRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve HEAD requests.
     *
     * The method receives a {@link ezcWebdavHeadRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any other
     * {@link ezcWebdavResponse} objects.
     * 
     * @param ezcWebdavGetRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    public function head( ezcWebdavHeadRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve PROPFIND requests.
     * 
     * The method receives a {@link ezcWebdavPropFindRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any
     * other {@link ezcWebdavResponse} objects.
     *
     * The {@link ezcWebdavPropFindRequest} object contains a definition to
     * find one or more properties of a given file or collection.
     *
     * @param ezcWebdavPropFindRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    public function propFind( ezcWebdavPropFindRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve PROPPATCH requests.
     * 
     * The method receives a {@link ezcWebdavPropPatchRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any
     * other {@link ezcWebdavResponse} objects.
     *
     * @param ezcWebdavPropPatchRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    public function propPatch( ezcWebdavPropPatchRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve PUT requests.
     *
     * The method receives a ezcWebdavPutRequest objects containing all
     * relevant information obout the clients request and should either return
     * an error by returning an ezcWebdavErrorResponse object, or any other
     * ezcWebdavResponse objects.
     * 
     * @param ezcWebdavPutRequest $request 
     * @return ezcWebdavResponse
     */
    public function put( ezcWebdavPutRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve DELETE requests.
     *
     * The method receives a ezcWebdavDeleteRequest objects containing all
     * relevant information obout the clients request and should either return
     * an error by returning an ezcWebdavErrorResponse object, or any other
     * ezcWebdavResponse objects.
     * 
     * @param ezcWebdavDeleteRequest $request 
     * @return ezcWebdavResponse
     */
    public function delete( ezcWebdavDeleteRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve COPY requests.
     *
     * The method receives a ezcWebdavCopyRequest objects containing all
     * relevant information obout the clients request and should either return
     * an error by returning an ezcWebdavErrorResponse object, or any other
     * ezcWebdavResponse objects.
     * 
     * @param ezcWebdavCopyRequest $request 
     * @return ezcWebdavResponse
     */
    public function copy( ezcWebdavCopyRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve MOVE requests.
     *
     * The method receives a ezcWebdavMoveRequest objects containing all
     * relevant information obout the clients request and should either return
     * an error by returning an ezcWebdavErrorResponse object, or any other
     * ezcWebdavResponse objects.
     * 
     * @param ezcWebdavMoveRequest $request 
     * @return ezcWebdavResponse
     */
    public function move( ezcWebdavMoveRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve MKCOL (make collection) requests.
     *
     * The method receives a ezcWebdavMakeCollectionRequest objects containing
     * all relevant information obout the clients request and should either
     * return an error by returning an ezcWebdavErrorResponse object, or any
     * other ezcWebdavResponse objects.
     * 
     * @param ezcWebdavMakeCollectionRequest $request 
     * @return ezcWebdavResponse
     */
    public function makeCollection( ezcWebdavMakeCollectionRequest $request )
    {
        // @TODO: Implement.
    }
}

?>

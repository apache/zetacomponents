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
     * Properties for collections and resources.
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
     * Return an initial set o fproperties for resources and collections.
     *
     * The second parameter indicates wheather the given resource is a
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
                'getcontentlength'      => ( $isCollection ? 0 : strlen( $this->content[$name] ) ),
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

            // Full path to resource
            $resourcePath = $path . $name;

            if ( is_array( $content ) )
            {
                // Content is a collection
                $this->content[$resourcePath] = array();
                $this->props[$resourcePath] = $this->initializeProperties(
                    $resourcePath,
                    true
                );

                // Recurse
                $this->addContents( $content, $resourcePath . '/' );
            }
            elseif ( is_string( $content ) )
            {
                // Content is a file
                $this->content[$resourcePath] = $content;
                $this->props[$resourcePath] = $this->initializeProperties(
                    $resourcePath
                );
            }
            else
            {
                // Ignore everything else...
                continue;
            }

            // Add contents to parent directory
            $parent = ( $path === '/' ? '/' : substr( $path, 0, -1 ) );
            $this->content[$parent][] = $resourcePath;
        }
    }

    /**
     * Create a new collection.
     *
     * Creates a new collection at the given path.
     * 
     * @param string $path 
     * @return void
     */
    protected function createCollection( $path )
    {
        // Create collection
        $this->content[$path] = array();

        // Add collection to parent node
        $this->content[dirname( $path )][] = $path;

        // Set initial metadata for collection
        $this->props[$path] = $this->initializeProperties( $path, true );
    }

    /**
     * Create a new resource.
     *
     * Creates a new resource at the given path, optionally with the given
     * content.
     * 
     * @param string $path 
     * @param string $content 
     * @return void
     */
    protected function createResource( $path, $content = null )
    {
        // Create resource
        $this->content[$path] = $content;

        // Add resource to parent node
        $this->content[dirname( $path )][] = $path;

        // Set initial metadata for collection
        $this->props[$path] = $this->initializeProperties( $path, false );
    }

    /**
     * Manually set a property on a resource to request it later.
     * 
     * @param string $resource 
     * @param string $propertyName 
     * @param string $propertyValue 
     * @return bool
     */
    public function setProperty( $resource, $propertyName, $propertyValue )
    {
        // Check if resource exists at all
        if ( !array_key_exists( $resource, $this->props ) )
        {
            return false;
        }

        // Do not check if an existing value will be overwritten, just set
        // property
        $this->props[$resource][$propertyName] = $propertyValue;

        return true;
    }

    /**
     * Copy resources recursively from one path to another.
     *
     * Returns an array with resources / collections, which caused an error
     * during copy operation. An empty array means full success.
     * 
     * @param string $fromPath 
     * @param string $toPath 
     * @param int $depth
     * @return array
     */
    protected function memCopy( $fromPath, $toPath, $depth = ezcWebdavRequest::DEPTH_INFINITY )
    {
        $causeErrors = (bool) ( $this->options->failingOperations & ezcWebdavRequest::COPY );
        $errors = array();
        
        if ( !is_array( $this->content[$fromPath] ) ||
             ( is_array( $this->content[$fromPath] ) && ( $depth === ezcWebdavRequest::DEPTH_ZERO ) ) )
        {
            // Copy a resource, or a collection, but the depth header told not
            // to recurse into collections
            if ( $causeErrors && preg_match( $this->options->failForRegexp, $fromPath ) )
            {
                // Completely abort with error
                return array( $fromPath );
            }

            // Perform copy operation
            if ( is_array( $this->content[$fromPath] ) )
            {
                // Create a new empty collection
                $this->content[$toPath] = array();
            }
            else
            {
                // Copy file content
                $this->content[$toPath] = $this->content[$fromPath];
            }

            // Copy properties
            $this->props[$toPath] = $this->props[$fromPath];

            // Update modification date
            $this->props[$toPath]['getlastmodified'] = time();

            // Add to parent node
            $this->content[dirname( $toPath )][] = $toPath;
        }
        else
        {
            // Copy a collection
            $errnousSubtrees = array();

            // Array of copied collections, where the child names are required
            // to be modified depending on the success of the copy operation.
            $copiedCollections = array();

            // Check all nodes, if they math the fromPath
            foreach ( $this->content as $resource => $content )
            {
                if ( strpos( $resource, $fromPath ) !== 0 )
                {
                    // This resource is not affected by the copy operation
                    continue;
                }

                // Check if this resource should be skipped, because
                // already one of the parent nodes caused an error.
                foreach ( $errnousSubtrees as $subtree )
                {
                    if ( strpos( $resource, $subtree ) )
                    {
                        // Skip resource, then.
                        continue 2;
                    }
                }

                // Check if this resource should cause an error
                if ( $causeErrors && preg_match( $this->options->failForRegexp, $resource ) )
                {
                    // Cause an error and skip resource
                    $errors[] = $resource;
                    continue;
                }

                // To actually perform the copy operation, modify the
                // destination resource name
                $newResourceName = preg_replace( '(^' . preg_quote( $fromPath ) . ')', $toPath, $resource );
                
                // Add collection to collection child recalculation array
                if ( is_array( $this->content[$resource] ) )
                {
                    $copiedCollections[] = $newResourceName;
                }

                // Actually copy
                $this->content[$newResourceName] = $this->content[$resource];

                // Copy properties
                $this->props[$newResourceName] = $this->props[$resource];

                // Update modification date
                $this->props[$newResourceName]['getlastmodified'] = time();

                // Add to parent node
                $this->content[dirname( $newResourceName )][] = $newResourceName;
            }

            // Iterate over all copied collections and update the child
            // references
            foreach ( $copiedCollections as $collection )
            {
                foreach ( $this->content[$collection] as $nr => $child )
                {
                    foreach ( $errnousSubtrees as $subtree )
                    {
                        if ( strpos( $child, $subtree ) )
                        {
                            // If child caused an error, it has not been
                            // copied, so we remove it.
                            unset( $this->content[$collection][$nr] );
                            continue 2;
                        }
                    }

                    // Also remove all references to old children, new children
                    // have already been added during the last step.
                    if ( preg_match( '(^' . preg_quote( $fromPath ) . ')', $child ) )
                    {
                        unset( $this->content[$collection][$nr] );
                    }
                }

                $this->content[$collection] = array_values( $this->content[$collection] );
            }
        }

        return $errors;
    }

    /**
     * Delete everything below this path.
     *
     * Returns false if the delete process failed.
     * 
     * @param string $path 
     * @return bool
     */
    protected function memDelete( $path )
    {
        if ( $this->options->failingOperations & ezcWebdavRequest::DELETE )
        {
            if ( preg_match( $this->options->failForRegexp, $path ) )
            {
                return false;
            }
        }

        // Remove all content nodes starting with requested path
        foreach ( $this->content as $name => $content )
        {
            if ( strpos( $name, $path ) === 0 )
            {
                unset( $this->content[$name] );
            }
        }

        // Remove parent node assignement to removed node
        $id = array_search( $path, $this->content[$parent = dirname( $path )] );
        if ( $id !== false )
        {
            unset( $this->content[$parent][$id] );
            $this->content[$parent] = array_values( $this->content[$parent] );
        }

        // Also remove all properties for removed content nodes
        foreach ( $this->props as $name => $properties )
        {
            if ( strpos( $name, $path ) === 0 )
            {
                unset( $this->props[$name] );
            }
        }

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
     * @param ezcWebdavGetRequest $request
     * @return ezcWebdavResponse
     */
    public function get( ezcWebdavGetRequest $request )
    {
        $source = $request->requestUri;

        // Check if resource is available
        if ( !isset( $this->content[$source] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_404,
                $source
            );
        }

        if ( !is_array( $this->content[$source] ) )
        {
            // Just deliver file
            return new ezcWebdavGetResourceResponse(
                new ezcWebdavResource(
                    $source,
                    $this->props[$source],
                    $this->content[$source]
                )
            );
        }

        // Build and add an array with structs for contained collections and
        // resources of an collection if requested resource is not just a
        // file.
        //
        // It is up to the transport handler, to render some listing out of
        // this. 
        $contents = array();

        foreach ( $this->content[$source] as $child )
        {
            if ( is_array( $this->content[$child] ) )
            {
                // Add collection without any childs
                $contents[] = new ezcWebdavCollection(
                    $child,
                    $this->props[$child]
                );
            }
            else
            {
                // Add files without content
                $contents[] = new ezcWebdavResource(
                    $child,
                    $this->props[$child]
                );
            }
        }

        // Return collection with contained childs
        return new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                $source,
                $this->props[$source],
                $contents
            )
        );
    }

    /**
     * Required method to serve HEAD requests.
     *
     * The method receives a {@link ezcWebdavHeadRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any other
     * {@link ezcWebdavResponse} objects.
     * 
     * @param ezcWebdavGetRequest $request
     * @return ezcWebdavResponse
     */
    public function head( ezcWebdavHeadRequest $request )
    {
        $source = $request->requestUri;

        // Check if resource is available
        if ( !isset( $this->content[$source] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_404,
                $source
            );
        }

        if ( !is_array( $this->content[$source] ) )
        {
            // Just deliver file without contents
            return new ezcWebdavHeadResponse(
                new ezcWebdavResource(
                    $source,
                    $this->props[$source]
                )
            );
        }
        else
        {
            // Just deliver collection without childs
            return new ezcWebdavHeadResponse(
                new ezcWebdavCollection(
                    $source,
                    $this->props[$source]
                )
            );
        }
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
     * @param ezcWebdavPropFindRequest $request
     * @return ezcWebdavResponse
     */
    public function propFind( ezcWebdavPropFindRequest $request )
    {
        // @TODO: Implement.
    }

    /**
     * Required method to serve PROPPATCH requests.
     * 
     * The method receives a {@link ezcWebdavPropPatchRequest} object
     * containing all relevant information obout the clients request and should
     * either return an error by returning an {@link ezcWebdavErrorResponse}
     * object, or any other {@link ezcWebdavResponse} objects.
     *
     * @param ezcWebdavPropPatchRequest $request
     * @return ezcWebdavResponse
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
        $source = $request->requestUri;

        // Check if parent node exists and throw a 409 otherwise
        if ( !isset( $this->content[dirname( $source )] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                $source
            );
        }

        // Check if parent node is a collection, and throw a 409 otherwise
        if ( !is_array( $this->content[dirname( $source )] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                $source
            );
        }

        // Check if resource to be updated or created does not exists already
        // AND is a collection
        if ( isset( $this->content[$source] ) &&
             is_array( $this->content[$source] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                $source
            );
        }

        // Everything is OK, create or update resource.
        if ( !isset( $this->content[$source] ) )
        {
            $this->createResource( $source );
        }
        $this->content[$source] = $request->body;

        // Return success response
        return new ezcWebdavPutResponse(
            $source
        );
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
        $source = $request->requestUri;

        // Check if resource is available
        if ( !isset( $this->content[$source] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_404,
                $source
            );
        }

        // Delete
        $deletion = $this->memDelete( $source );

        // If deletion failed, this has again been caused by the automatic
        // error causing facilities of the backend. Send 423 by choice.
        if ( $deletion !== true )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_423,
                $source
            );
        }

        // Send proper response on success
        return new ezcWebdavDeleteResponse(
            $source
        );
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
        // Indicates wheather a destiantion resource has been replaced or not.
        // The success response code depends on this.
        $replaced = false;

        // Extract paths from request
        $source = $request->requestUri;
        $dest = $request->getHeader( 'Destination' );

        // Check if resource is available
        if ( !isset( $this->content[$source] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_404,
                $source
            );
        }

        // If source and destination are equal, the request should always fail.
        if ( $source === $dest )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_403,
                $source
            );
        }

        // Check if destination resource exists and throw error, when
        // overwrite header is F
        if ( ( $request->getHeader( 'Overwrite' ) === 'F' ) &&
             ( isset( $this->content[$dest] ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_412,
                $dest
            );
        }

        // Check if the destination parent directory already exists, otherwise
        // bail out.
        if ( !isset( $this->content[dirname( $dest )] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                $dest
            );
        }

        // The destination resource should be deleted if it exists and the
        // overwrite headers is T
        if ( ( $request->getHeader( 'Overwrite' ) === 'T' ) &&
             ( isset( $this->content[$dest] ) ) )
        {
            $replaced = true;
            $this->memDelete( $dest );
        }

        // All checks are passed, we can actuall copy now.
        $errors = $this->memCopy( $source, $dest, $request->getHeader( 'Depth' ) );

        if ( !count( $errors ) )
        {
            // No errors occured during copy. Just response with success.
            return new ezcWebdavCopyResponse(
                $replaced
            );
        }

        // We need a multistatus response, because some errors occured for some
        // of the resources.
        //
        // For each errnous resource we create a 423 error response, because
        // they were randomly caused and we do not hav a "real" error here.        
        $responses = array();
        foreach ( $errors as $error )
        {
            $responses[] = new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_423,
                $error
            );
        }

        // Send proper response on success
        return new ezcWebdavMultistatusResponse(
            $responses
        );
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
        // Indicates wheather a destiantion resource has been replaced or not.
        // The success response code depends on this.
        $replaced = false;

        // Extract paths from request
        $source = $request->requestUri;
        $dest = $request->getHeader( 'Destination' );

        // Check if resource is available
        if ( !isset( $this->content[$source] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_404,
                $source
            );
        }

        // If source and destination are equal, the request should always fail.
        if ( $source === $dest )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_403,
                $source
            );
        }

        // Check if destination resource exists and throw error, when
        // overwrite header is F
        if ( ( $request->getHeader( 'Overwrite' ) === 'F' ) &&
             ( isset( $this->content[$dest] ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_412,
                $dest
            );
        }

        // Check if the destination parent directory already exists, otherwise
        // bail out.
        if ( !isset( $this->content[dirname( $dest )] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                $dest
            );
        }

        // The destination resource should be deleted if it exists and the
        // overwrite headers is T
        if ( ( $request->getHeader( 'Overwrite' ) === 'T' ) &&
             ( isset( $this->content[$dest] ) ) )
        {
            $replaced = true;
            $this->memDelete( $dest );
        }

        // All checks are passed, we can actuall copy now.
        //
        // MOVEd contents should always be copied using infinity depth.
        $errors = $this->memCopy( $source, $dest, ezcWebdavRequest::DEPTH_INFINITY );

        // If an error occured we skip deletion of source.
        //
        // @IMPORTANT: This is a definition / assumption made by us, because it
        // is not defined in the RFC how to handle such a case.
        if ( count( $errors ) )
        {
            // We need a multistatus response, because some errors occured for some
            // of the resources.
            //
            // For each errnous resource we create a 423 error response, because
            // they were randomly caused and we do not hav a "real" error here.        
            $responses = array();
            foreach ( $errors as $error )
            {
                $responses[] = new ezcWebdavErrorResponse(
                    ezcWebdavErrorResponse::STATUS_423,
                    $error
                );
            }

            return new ezcWebdavMultistatusResponse(
                $responses
            );
        }

        // Delete the source, COPY has been successful
        $deletion = $this->memDelete( $source );

        // If deletion failed, this has again been caused by the automatic
        // error causing facilities of the backend. Send 423 by choice.
        if ( $deletion !== true )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_423,
                $source
            );
        }

        // Send proper response on success
        return new ezcWebdavMoveResponse(
            $replaced
        );
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
        $collection = $request->requestUri;

        // If resource already exists, the collection cannot be created and a
        // 405 is thrown.
        if ( isset( $this->content[$collection] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_405,
                $collection
            );
        }

        // Check if the parent node already exists, otherwise throw a 409
        // error.
        if ( !isset( $this->content[dirname( $collection )] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_409,
                $collection
            );
        }

        // If the parent node exists, but is a resource, which obviously can
        // not accept any members, throw a 403 error.
        if ( !is_array( $this->content[dirname( $collection )] ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_403,
                $collection
            );
        }

        // As the handling of request bodies is not described in RFC 2518, we
        // skip their handling and always return a 415 error.
        if ( $request->body )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavErrorResponse::STATUS_415,
                $collection
            );
        }

        // Cause error, if requested?

        // All checks passed, we can create the collection
        $this->createCollection( $collection );

        // Return success
        return new ezcWebdavMakeCollectionResponse(
            $collection
        );
    }
}

?>

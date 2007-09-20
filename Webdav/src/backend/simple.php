<?php
/**
 * File containing a abstract simple webdav backend.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This backend provides the generic handling of requests and dispatches the
 * requuired actions to some basic manipulation methods, which you are required
 * to implement.
 *
 * This backend does not provide support for extended Webdav features, like
 * compression, or locking handled by the backend, therefore the getFeatures()
 * method is final. If you want to develop a backend which is capable of manual
 * handling those features directly extend from {@link ezcWebdavBackend}.
 *
 * @version //autogentag//
 * @package Webdav
 */
abstract class ezcWebdavSimpleBackend
    extends
        ezcWebdavBackend
    implements
        ezcWebdavBackendPut,
        ezcWebdavBackendChange,
        ezcWebdavBackendMakeCollection
{
    /**
     * Create a new collection.
     *
     * Creates a new collection at the given path.
     * 
     * @param string $path 
     * @return void
     */
    abstract protected function createCollection( $path );

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
    abstract protected function createResource( $path, $content = null );

    /**
     * Set contents of a resource.
     *
     * Change the contents of the given resource to the given content.
     * 
     * @param string $path 
     * @param string $content 
     * @return void
     */
    abstract protected function setResourceContents( $path, $content );

    /**
     * Manually set a property on a resource to request it later.
     * 
     * @param string $resource 
     * @param ezcWebdavProperty $property
     * @return bool
     */
    abstract public function setProperty( $resource, ezcWebdavProperty $property );

    /**
     * Manually remove a property from a resource.
     * 
     * @param string $resource 
     * @param ezcWebdavProperty $property
     * @return bool
     */
    abstract public function removeProperty( $resource, ezcWebdavProperty $property );

    /**
     * Reset property storage for a resource.
     * 
     * @param string $resource 
     * @param ezcWebdavPropertyStorage $properties
     * @return bool
     */
    abstract public function resetProperties( $resource, ezcWebdavPropertyStorage $properties );

    /**
     * Manually get a property on a resource.
     * 
     * Get the property with the given name from the given resource. You may
     * optionally define a namespace to receive the property from.
     *
     * @param string $resource 
     * @param string $propertyName 
     * @param string $namespace 
     * @return ezcWebdavProperty
     */
    abstract public function getProperty( $resource, $propertyName, $namespace = 'DAV:' );

    /**
     * Manually get a property on a resource.
     * 
     * Get all properties for the given resource as a {@link
     * ezcWebdavPropertyStorage}
     *
     * @param string $resource 
     * @return ezcWebdavPropertyStorage
     */
    abstract public function getAllProperties( $resource );

    /**
     * Copy resources recursively from one path to another.
     *
     * Returns an array with {@link ezcWebdavErrorResponse}s for all subtree,
     * where the copy operation failed. Errors subsequent nodes in a subtree
     * should be ommitted.
     *
     * If an empty array is return, the operation has been completed
     * successfully.
     * 
     * @param string $fromPath 
     * @param string $toPath 
     * @param int $depth
     * @return array(ezcWebdavErrorResponse)
     */
    abstract protected function performCopy( $fromPath, $toPath, $depth = ezcWebdavRequest::DEPTH_INFINITY );

    /**
     * Delete everything below this path.
     *
     * Returns false if the delete process failed.
     * 
     * @param string $path 
     * @return bool
     */
    abstract protected function performDelete( $path );

    /**
     * Check if node exists.
     *
     * Check if a node exists with the given path.
     * 
     * @param string $path 
     * @return bool
     */
    abstract protected function nodeExists( $path );

    /**
     * Check if node is a collection.
     *
     * Check if the node behind the given path is a collection.
     * 
     * @param string $path 
     * @return bool
     */
    abstract protected function isCollection( $path );

    /**
     * Get members of collection.
     *
     * Returns an array with the members of the collection given by the path of
     * the collection.
     *
     * The returned array holds elements which are either ezcWebdavCollection,
     * or ezcWebdavResource.
     * 
     * @param string $path 
     * @return array
     */
    abstract protected function getCollectionMembers( $path );

    /**
     * Return bitmap of additional features supported by the backend referenced
     * by constants from the basic ezcWebdavBackend class.
     * 
     * @return int
     */
    public final function getFeatures()
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
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        if ( !$this->isCollection( $source ) )
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

        // Return collection with contained childs
        return new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                $source,
                $this->props[$source],
                $this->getCollectionMembers( $source )
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
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        if ( !$this->isCollection( $source ) )
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
     * Get all children nodes.
     *
     * Get all nodes from given $source path up to the given depth. Reuses the
     * method {@link getCollectionMembers}, but you may want to overwrite this
     * implementation by somethings which fits better with your backend.
     * 
     * @param string $source 
     * @param int $depth 
     * @return array
     */
    protected function getNodes( $source, $depth )
    {
        // No special handling for plain ressources
        if ( !$this->isCollection( $source ) )
        {
            return array( new ezcWebdavResource( $source ) );
        }

        // For zero depth just return the collection
        if ( $depth === ezcWebdavRequest::DEPTH_ZERO )
        {
            return array( new ezcWebdavCollection( $source ) );
        }

        $nodes = array( new ezcWebdavCollection( $source ) );
        $recurseCollections = array( $source );

        // Collect children for all collections listed in $recurseCollections.
        for ( $i = 0; $i < count( $recurseCollections); ++$i )
        {
            $source = $recurseCollections[$i];
            $childs = $this->getCollectionMembers( $source );

            foreach ( $childs as $child )
            {
                $nodes[] = $child;

                // Check if we should recurse deeper, and add collections to
                // processing list in this case.
                if ( ( $child instanceof ezcWebdavCollection ) && 
                     ( $depth === ezcWebdavRequest::DEPTH_INFINITY ) )
                {
                    $recurseCollections[] = $child->path;
                }
            }
        }

        return $nodes;
    }

    /**
     * Fetch properties by name as defined in propfind prop request.
     *
     * Fetch properties as defined by the passed propfind request by their
     * names for the given node.
     * 
     * @param ezcWebdavPropFindRequest $request 
     * @return ezcWebdavResponse
     */
    protected function fetchProperties( ezcWebdavPropFindRequest $request )
    {
        $source = $request->requestUri;

        // Get list of all affected node, depeding on source and depth
        $nodes = $this->getNodes( $source, $request->getHeader( 'Depth' ) );

        // Get requested properties for all files
        $responses = array();
        foreach ( $nodes as $node )
        {
            // We only check if a property could not be found. Normally there
            // are more other errors which could occur when retrieving a
            // property, like 403 (Forbidden), which are not handled by this
            // simple backend. Overwrite this method to handle them.

            // Get all properties form node ...
            $nodeProperties = $this->getAllProperties( $node->path );

            // ... and diff the with the requested properties.
            $notFound = $request->prop->diff( $nodeProperties );
            $valid = $request->prop->intersect( $nodeProperties );

            $nodeResponses = array();
            // Add propstat sub response for valid responses
            if ( count( $valid ) )
            {
                $nodeResponses[] = new ezcWebdavPropStatResponse( $valid );
            }

            // Only create error response, when some properties could not be
            // found.
            if ( count( $notFound ) )
            {
                $nodeResponses[] = new ezcWebdavPropStatResponse(
                    $notFound,
                    ezcWebdavResponse::STATUS_404
                );
            }

            // Create response
            $responses[] = new ezcWebdavPropFindResponse(
                $node,
                $nodeResponses
            );
        }

        return new ezcWebdavMultistatusResponse(
            $responses
        );
    }

    /**
     * Fetch names of all available properties for a node.
     *
     * Fetch names of properties in one node, and if the node is a collection,
     * also return children, depending on the set depth header.
     * 
     * @param ezcWebdavPropFindRequest $request 
     * @return ezcWebdavResponse
     */
    protected function fetchPropertyNames( ezcWebdavPropFindRequest $request )
    {
        $source = $request->requestUri;

        // Get list of all affected node, depeding on source and depth
        $nodes = $this->getNodes( $source, $request->getHeader( 'Depth' ) );

        // Get requested properties for all files
        $responses = array();
        foreach ( $nodes as $node )
        {
            // Get all properties form node ...
            $nodeProperties = $this->getAllProperties( $node->path );

            // ... and clear and add them to the property name storage.
            $propertyNames = new ezcWebdavPropertyStorage();
            foreach( $nodeProperties->getAllProperties() as $namespace => $properties )
            {
                foreach ( $properties as $name => $property )
                {
                    // Clear property, because the client only want the names
                    // of the available properties.
                    $property = clone $property;
                    $property->clear();
                    $propertyNames->attach( $property );
                }
            }

            // Add response
            $responses[] = new ezcWebdavPropFindResponse(
                $node,
                new ezcWebdavPropStatResponse( $propertyNames )
            );
        }

        return new ezcWebdavMultistatusResponse(
            $responses
        );
    }

    /**
     * Fetch all available properties for a node.
     *
     * Fetch properties in one node, and if the node is a collection, also
     * return children, depending on the set depth header.
     * 
     * @param ezcWebdavPropFindRequest $request 
     * @return ezcWebdavResponse
     */
    protected function fetchAllProperties( ezcWebdavPropFindRequest $request )
    {
        $source = $request->requestUri;

        // Get list of all affected node, depeding on source and depth
        $nodes = $this->getNodes( $source, $request->getHeader( 'Depth' ) );

        // Get requested properties for all files
        $responses = array();
        foreach ( $nodes as $node )
        {
            // Just create response from properties
            $responses[] = new ezcWebdavPropFindResponse(
                $node,
                new ezcWebdavPropStatResponse( 
                    $this->getAllProperties( $node->path )
                )
            );
        }

        return new ezcWebdavMultistatusResponse(
            $responses
        );
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
        $source = $request->requestUri;

        // Check if resource is available
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        // Check the exact type of propfind request and dispatch to
        // corresponding method.
        switch ( true )
        {
            case $request->prop:
                return $this->fetchProperties( $request );

            case $request->propName:
                return $this->fetchPropertyNames( $request );

            case $request->allProp:
                return $this->fetchAllProperties( $request );
        }

        // This should really never happen, because the request class itself
        // should have ensured, that on of those options is set. Untestable.
        return new ezcWebdavErrorResponse(
            ezcWebdavResponse::STATUS_500
        );
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
        $source = $request->requestUri;

        // Check if resource is available
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        // Store proeprties, to be able to revert all changes later
        $propertyBackup = clone $this->getAllProperties( $source );

        $errors = array(
            ezcWebdavResponse::STATUS_403 => new ezcWebdavPropertyStorage(),
            ezcWebdavResponse::STATUS_409 => new ezcWebdavPropertyStorage(),
            ezcWebdavResponse::STATUS_424 => new ezcWebdavPropertyStorage(),
        );
        $errnous = false;

        // Update properties, like requested
        foreach ( $request->updates as $property )
        {
            // If there already has been some error, issue failed
            // dependency errors for everything else.
            if ( $errnous )
            {
                $errors[ezcWebdavResponse::STATUS_424]->attach( $property );
                continue;
            }

            // Check for property validation errors and add a 409 for this.
            if ( $property->hasError )
            {
                $errors[ezcWebdavResponse::STATUS_409]->attach( $property );
                $errnous = true;
                continue;
            }

            switch ( $request->updates->getFlag( $property->name, $property->namespace ) )
            {
                case ezcWebdavPropPatchRequest::REMOVE:
                    if ( !$this->removeProperty( $source, $property ) )
                    {
                        // If update failed, we assume the access has been denied.
                        $errors[ezcWebdavResponse::STATUS_403]->attach( $property );
                        $errnous = true;
                    }
                    break;

                case ezcWebdavPropPatchRequest::SET:
                    if ( !$this->setProperty( $source, $property ) )
                    {
                        // If update failed, we assume the access has been denied.
                        $errors[ezcWebdavResponse::STATUS_403]->attach( $property );
                        $errnous = true;
                    }
                    break;

                default:
                    // This may happen, when a broken flag has been assigned
                    // during request generation. This SHOULD never happen.
                    $this->resetProperties( $source, $propertyBackup );

                    return new ezcWebdavErrorResponse(  
                        ezcWebdavResponse::STATUS_500
                    );
            }
        }

        // Create node from source for response
        if ( $this->isCollection( $source ) )
        {
            $node = new ezcWebdavCollection( $source );
        }
        else
        {
            $node = new ezcWebdavResource( $source );
        }

        if ( $errnous )
        {
            // Revert all changes
            $this->resetProperties( $source, $propertyBackup );

            // Create response
            return new ezcWebdavPropPatchResponse(
                $node,
                new ezcWebdavPropStatResponse(
                    $errors[ezcWebdavResponse::STATUS_403],
                    ezcWebdavResponse::STATUS_403
                ),
                new ezcWebdavPropStatResponse(
                    $errors[ezcWebdavResponse::STATUS_409],
                    ezcWebdavResponse::STATUS_409
                ),
                new ezcWebdavPropStatResponse(
                    $errors[ezcWebdavResponse::STATUS_424],
                    ezcWebdavResponse::STATUS_424
                )
            );
        }

        return new ezcWebdavPropPatchResponse(
            $node
        );
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
        if ( !$this->nodeExists( dirname( $source ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $source
            );
        }

        // Check if parent node is a collection, and throw a 409 otherwise
        if ( !$this->isCollection( dirname( $source ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $source
            );
        }

        // Check if resource to be updated or created does not exists already
        // AND is a collection
        if ( $this->nodeExists( $source ) &&
             $this->isCollection( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $source
            );
        }

        // Everything is OK, create or update resource.
        if ( !$this->nodeExists( $source ) )
        {
            $this->createResource( $source );
        }
        $this->setResourceContents( $source, $request->body );

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
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        // Delete
        $deletion = $this->performDelete( $source );

        // If deletion failed, this has again been caused by the automatic
        // error causing facilities of the backend. Send 423 by choice.
        if ( $deletion !== true )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_423,
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
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        // If source and destination are equal, the request should always fail.
        if ( $source === $dest )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                $source
            );
        }

        // Check if destination resource exists and throw error, when
        // overwrite header is F
        if ( ( $request->getHeader( 'Overwrite' ) === 'F' ) &&
             $this->nodeExists( $dest ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $dest
            );
        }

        // Check if the destination parent directory already exists, otherwise
        // bail out.
        if ( !$this->nodeExists( dirname( $dest ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $dest
            );
        }

        // The destination resource should be deleted if it exists and the
        // overwrite headers is T
        if ( ( $request->getHeader( 'Overwrite' ) === 'T' ) &&
             $this->nodeExists( $dest ) )
        {
            $replaced = true;
            $this->performDelete( $dest );
        }

        // All checks are passed, we can actuall copy now.
        $errors = $this->performCopy( $source, $dest, $request->getHeader( 'Depth' ) );

        if ( !count( $errors ) )
        {
            // No errors occured during copy. Just response with success.
            return new ezcWebdavCopyResponse(
                $replaced
            );
        }

        // Send proper response on success
        return new ezcWebdavMultistatusResponse(
            $errors
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
        if ( !$this->nodeExists( $source ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $source
            );
        }

        // If source and destination are equal, the request should always fail.
        if ( $source === $dest )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                $source
            );
        }

        // Check if destination resource exists and throw error, when
        // overwrite header is F
        if ( ( $request->getHeader( 'Overwrite' ) === 'F' ) &&
             $this->nodeExists( $dest ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $dest
            );
        }

        // Check if the destination parent directory already exists, otherwise
        // bail out.
        if ( !$this->nodeExists( dirname( $dest ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $dest
            );
        }

        // The destination resource should be deleted if it exists and the
        // overwrite headers is T
        if ( ( $request->getHeader( 'Overwrite' ) === 'T' ) &&
             $this->nodeExists( $dest ) )
        {
            $replaced = true;
            $this->performDelete( $dest );
        }

        // All checks are passed, we can actuall copy now.
        //
        // MOVEd contents should always be copied using infinity depth.
        $errors = $this->performCopy( $source, $dest, ezcWebdavRequest::DEPTH_INFINITY );

        // If an error occured we skip deletion of source.
        //
        // @IMPORTANT: This is a definition / assumption made by us, because it
        // is not defined in the RFC how to handle such a case.
        if ( count( $errors ) )
        {
            // We need a multistatus response, because some errors occured for some
            // of the resources.
            return new ezcWebdavMultistatusResponse(
                $errors
            );
        }

        // Delete the source, COPY has been successful
        $deletion = $this->performDelete( $source );

        // If deletion failed, this has again been caused by the automatic
        // error causing facilities of the backend. Send 423 by choice.
        if ( $deletion !== true )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_423,
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
        if ( $this->nodeExists( $collection ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                $collection
            );
        }

        // Check if the parent node already exists, otherwise throw a 409
        // error.
        if ( !$this->nodeExists( dirname( $collection ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $collection
            );
        }

        // If the parent node exists, but is a resource, which obviously can
        // not accept any members, throw a 403 error.
        if ( !$this->isCollection( dirname( $collection ) ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                $collection
            );
        }

        // As the handling of request bodies is not described in RFC 2518, we
        // skip their handling and always return a 415 error.
        if ( $request->body )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_415,
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

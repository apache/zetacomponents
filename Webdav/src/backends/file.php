<?php
/**
 * File containing a fake file webdav backend.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Simple file backend which just serves a directory tree through the webdav
 * server. You might want to extend this by user authentication and
 * authorization.
 *
 * <code>
 *  $backend = new ezcWebdavFileBackend(
 *      'directory/'
 *  );
 * </code>
 *
 * @version //autogentag//
 * @package Webdav
 * @mainclass
 */
class ezcWebdavFileBackend
    extends
        ezcWebdavSimpleBackend
{
    /**
     * Options of the file backend
     * 
     * @var ezcWebdavFileBackendOptions
     */
    protected $options;

    /**
     * Root directory for webdav contents.
     * 
     * @var string
     */
    protected $root;

    /**
     * Names of live properties from the DAV: namespace which will be handled
     * live, and should not bestored like dead properties.
     * 
     * @var array
     */
    protected $handledLiveProperties = array( 
        'getcontentlength', 
        'getlastmodified', 
        'creationdate', 
        'displayname', 
        'getetag', 
        'getcontenttype', 
        'resourcetype',
        'supportedlock',
        'lockdiscovery',
    );

    /**
     * Construct backend from a given path.
     * 
     * @param string $path 
     * @return void
     */
    public function __construct( $root )
    {
        if ( !is_dir( $root ) )
        {
            throw new ezcBaseFileNotFoundException( $root );
        }

        if ( !is_readable( $root ) )
        {
            throw new ezcBaseFilePermissionException( $root, ezcBaseFileException::READ );
        }

        $this->root = realpath( $root );
        $this->options = new ezcWebdavFileBackendOptions();
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
                if ( ! $value instanceof ezcWebdavFileBackendOptions )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcWebdavFileBackendOptions' );
                }

                $this->$name = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Wait and get lock for complete directory tree.
     *
     * Acquire lock for the complete tree, fore read or write operations. This
     * does not implement any priorities for operations, or check if several
     * read operation may run in parallel. The plain locking should / could be
     * extended by something more sophisticated.
     *
     * If the tree already has been locked, the method waits until the lock can
     * be acquired.
     *
     * The optional second parameter indicates wheather a read only lock should
     * be acquired. This may be used by extended implementations, but it is not
     * used in this implementation.
     *
     * @param bool $readOnly
     * @return void
     */
    protected function acquireLock( $readOnly = false )
    {
        if ( $this->options->noLock )
        {
            return true;
        }

        $sleeptime = $this->options->waitForLock;
        $lockFileName = $this->root . '/' . $this->options->lockFileName;

        // fopen in mode 'x' will only open the file, if it does not exist yet.
        // Even this is is expected it will throw a warning, if the file
        // exists, which we need to silence using the @
        while ( ( $fp = @fopen( $lockFileName, 'x' ) ) === false )
        {
            // This is untestable.
            usleep( $sleeptime );
        }

        // Store random bit in file ... the microtime for example - might prove
        // useful some time.
        fwrite( $fp, microtime() );
        fclose( $fp );

        return true;
    }

    /**
     * Free lock.
     *
     * Frees the lock if the operation ahs been finished.
     * 
     * @return void
     */
    protected function freeLock()
    {
        if ( $this->options->noLock )
        {
            return true;
        }

        // Just remove the lock file
        $lockFileName = $this->root . '/' . $this->options->lockFileName;
        unlink( $lockFileName );
    }

    /**
     * Get mime type for resource
     *
     * Return the mime type for a resource. If a mime type extension is
     * available it will be used to read the real mime type, otherwise the
     * original mime type passed by the client when uploading the file will be
     * returned. If no mimetype has ever been associated with the file, the
     * method will just return 'application/octet-stream'.
     * 
     * @param string $resource 
     * @return string
     */
    protected function getMimeType( $resource )
    {
        // Check if extension pecl/fileinfo is usable.
        if ( $this->options->useMimeExts && function_exists( 'finfo_file' ) )
        {
            $fInfo = new fInfo( FILEINFO_MIME );
            $mimeType = $fInfo->file( $this->root . $resource );
            $fInfo->close();

            return $mimeType;
        }

        // Check if extension ext/mime-magic is usable.
        if ( $this->options->useMimeExts && function_exists( 'mime_content_type' ) )
        {
            return mime_content_type( $this->root . $resource );
        }

        // Check if some browser submitted mime type is available.
        $storage = $this->getPropertyStorage( $resource );
        $properties = $storage->getAllProperties();

        if ( isset( $properties['DAV:']['getcontenttype'] ) )
        {
            return $properties['DAV:']['getcontenttype']->mime;
        }

        // Default to 'application/octet-stream' if nothing else is available.
        return 'application/octet-stream';
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
        mkdir( $this->root . $path );
        chmod( $this->root . $path, $this->options->directoryMode );

        // This automatically creates the property storage
        $storage = $this->getPropertyStoragePath( $path . '/foo' );
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
        file_put_contents( $this->root . $path, $content );
        chmod( $this->root . $path, $this->options->fileMode );

        // This automatically creates the property storage if missing
        $storage = $this->getPropertyStoragePath( $path );
    }

    /**
     * Set contents of a resource.
     *
     * Change the contents of the given resource to the given content.
     * 
     * @param string $path 
     * @param string $content 
     * @return void
     */
    protected function setResourceContents( $path, $content )
    {
        file_put_contents( $this->root . $path, $content );
        chmod( $this->root . $path, $this->options->fileMode );
    }

    /**
     * Get contents of a resource.
     * 
     * @param string $path 
     * @return string
     */
    protected function getResourceContents( $path )
    {
        return file_get_contents( $this->root . $path );
    }

    /**
     * Get the storage path for a property.
     *
     * Get the storage path for a resources property. This depends on the name
     * of the resource, if it is a directory and the namespace and name of the
     * property. If the property is omitted, the root directory for the
     * property storage will be returned. Otherwise the method will return the
     * path to the property storage file.
     * 
     * @param string $resource 
     * @return string
     */
    protected function getPropertyStoragePath( $resource )
    {
        // Get storage path for properties depending on the type of the
        // ressource.
        $storagePath = realpath( $this->root . dirname( $resource ) ) 
            . '/' . $this->options->propertyStoragePath . '/'
            . basename( $resource ) . '.xml';

        // Create property storage if it does not exist yet
        if ( !is_dir( dirname( $storagePath ) ) )
        {
            mkdir( dirname( $storagePath ), $this->options->directoryMode );
        }

        // Append name of namespace to property storage path
        return $storagePath;
    }

    /**
     * Get property storage
     *
     * Get property storage for a ressource for one namespace.
     * 
     * @param string $resource 
     * @return ezcWebdavBasicPropertyStorage
     */
    protected function getPropertyStorage( $resource )
    {
        $storagePath = $this->getPropertyStoragePath( $resource );

        // If no properties has been stored yet, just return an empty property
        // storage.
        if ( !is_file( $storagePath ) )
        {
            return new ezcWebdavBasicPropertyStorage();
        }

        // Create handler structure to read properties
        $handler = new ezcWebdavPropertyHandler(
            $xml = new ezcWebdavXmlTool()
        );
        $storage = new ezcWebdavBasicPropertyStorage();

        // Read document
        if ( !$doc = $xml->createDomDocument( file_get_contents( $storagePath ) ) )
        {
            throw new ezcWebdavFileBackendBrokenStorageException(
                "Could not open XML as DOMDocument: '{$storage}'."
            );
        }

        // Get property node from document
        $properties = $doc->getElementsByTagname( 'properties' )->item( 0 )->childNodes;

        // Extract and return properties
        $handler->extractProperties( 
            $properties,
            $storage
        );

        return $storage;
    }

    /**
     * Store properties back to file
     *
     * Create a new property storage file and store the properties back there.
     * This depends on the affected resource and the actual properties in the
     * property storage.
     * 
     * @param string $resource 
     * @param ezcWebdavBasicPropertyStorage $storage 
     * @return void
     */
    protected function storeProperties( $resource, ezcWebdavBasicPropertyStorage $storage )
    {
        $storagePath = $this->getPropertyStoragePath( $resource );

        // Create handler structure to read properties
        $handler = new ezcWebdavPropertyHandler(
            $xml = new ezcWebdavXmlTool()
        );

        // Create new dom document with property storage for one namespace
        $doc = new DOMDocument( '1.0' );

        $properties = $doc->createElement( 'properties' );
        $doc->appendChild( $properties );

        // Store and store properties
        $handler->serializeProperties(
            $storage,
            $properties
        );

        return $doc->save( $storagePath );
    }

    /**
     * Manually set a property on a resource to request it later.
     * 
     * @param string $resource 
     * @param ezcWebdavProperty $property
     * @return bool
     */
    public function setProperty( $resource, ezcWebdavProperty $property )
    {
        // Check if property is a self handled live property and return an
        // error in this case.
        if ( ( $property->namespace === 'DAV:' ) &&
             in_array( $property->name, $this->handledLiveProperties, true ) &&
             ( $property->name !== 'getcontenttype' ) )
        {
            return false;
        }

        // Get namespace property storage
        $storage = $this->getPropertyStorage( $resource );

        // Attach property to store
        $storage->attach( $property );

        // Store document back
        $this->storeProperties( $resource, $storage );

        return true;
    }

    /**
     * Manually remove a property from a resource.
     * 
     * @param string $resource 
     * @param ezcWebdavProperty $property
     * @return bool
     */
    public function removeProperty( $resource, ezcWebdavProperty $property )
    {
        // Live properties may not be removed.
        if ( $property instanceof ezcWebdavLiveProperty )
        {
            return false;
        }

        // Get namespace property storage
        $storage = $this->getPropertyStorage( $resource );

        // Attach property to store
        $storage->detach( $property->name, $property->namespace );

        // Store document back
        $this->storeProperties( $resource, $storage );

        return true;
    }

    /**
     * Reset property storage for a resource.
     * 
     * @param string $resource 
     * @param ezcWebdavPropertyStorage $storage
     * @return bool
     */
    public function resetProperties( $resource, ezcWebdavPropertyStorage $storage )
    {
        $this->storeProperties( $resource, $storage );
    }

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
    public function getProperty( $resource, $propertyName, $namespace = 'DAV:' )
    {
        $storage = $this->getPropertyStorage( $resource );

        // Handle dead propreties
        if ( $namespace !== 'DAV:' )
        {
            $properties = $storage->getAllProperties();
            return $properties[$namespace][$name];
        }

        // Handle live properties
        switch ( $propertyName )
        {
            case 'getcontentlength':
                $property = new ezcWebdavGetContentLengthProperty();
                $property->length = ( $this->isCollection( $resource ) ?
                    ezcWebdavGetContentLengthProperty::COLLECTION :
                    (string) filesize( $this->root . $resource ) );
                return $property;

            case 'getlastmodified':
                $property = new ezcWebdavGetLastModifiedProperty();
                $property->date = new ezcWebdavDateTime( '@' . filemtime( $this->root . $resource ) );
                return $property;

            case 'creationdate':
                $property = new ezcWebdavCreationDateProperty();
                $property->date = new ezcWebdavDateTime( '@' . filectime( $this->root . $resource ) );
                return $property;

            case 'displayname':
                $property = new ezcWebdavDisplayNameProperty();
                $property->displayName = basename( $resource );
                return $property;

            case 'getcontenttype':
                $property = new ezcWebdavGetContentTypeProperty(
                    $this->getMimeType( $resource )
                );
                return $property;

            case 'getetag':
                $property = new ezcWebdavGetEtagProperty();
                // @TODO: Use proper etag hashing stuff
                $property->etag = md5( $resource . filemtime( $this->root . $resource ) );
                return $property;

            case 'resourcetype':
                $property = new ezcWebdavResourceTypeProperty();
                $property->type = $this->isCollection( $resource ) ?
                    ezcWebdavResourceTypeProperty::TYPE_COLLECTION : 
                    ezcWebdavResourceTypeProperty::TYPE_RESSOURCE;
                return $property;

            case 'supportedlock':
                $property = new ezcWebdavSupportedLockProperty();
                return $property;

            case 'lockdiscovery':
                $property = new ezcWebdavLockDiscoveryProperty();
                return $property;

            default:
                // Handle all other live properties like dead properties
                $properties = $storage->getAllProperties();
                return $properties[$namespace][$name];
        }
    }

    /**
     * Manually get a property on a resource.
     * 
     * Get all properties for the given resource as a {@link
     * ezcWebdavBasicPropertyStorage}
     *
     * @param string $resource 
     * @return ezcWebdavBasicPropertyStorage
     */
    public function getAllProperties( $resource )
    {
        $storage = $this->getPropertyStorage( $resource );
        
        // Add all live properties to stored properties
        foreach ( $this->handledLiveProperties as $property )
        {
            $storage->attach(
                $this->getProperty( $resource, $property )
            );
        }

        return $storage;
    }

    /**
     * Recursively copy a file or directory.
     *
     * Recursively copy a file or directory in $source to the given
     * destination. If a depth is given, the operation will stop, if the given
     * recursion depth is reached. A depth of -1 means no limit, while a depth
     * of 0 means, that only the current file or directory will be copied,
     * without any recursion.
     *
     * Returns an empty array if no errors occured, and an array with the files
     * which caused errors otherwise.
     * 
     * @param string $source 
     * @param string $destination 
     * @param int $depth 
     * @return array
     */
    public function copyRecursive( $source, $destination, $depth = ezcWebdavRequest::DEPTH_INFINITY )
    {
        // Skip non readable files in source directory, or non writeable
        // destination directories.
        if ( !is_readable( $source ) || !is_writeable( dirname( $destination ) ) )
        {
            return array( $source );
        }

        // Copy
        if ( is_dir( $source ) )
        {
            mkdir( $destination );
            // To ignore umask, umask() should not be changed on multithreaded
            // servers...
            chmod( $destination, $this->options->directoryMode );
        } 
        elseif ( is_file( $source ) )
        {
            copy( $source, $destination );
            chmod( $destination, $this->options->fileMode );
        }

        if ( ( $depth === 0 ) ||
             ( !is_dir( $source ) ) )
        {
            // Do not recurse (any more)
            return array();
        }

        // Recurse
        $dh = opendir( $source );
        $errors = array();
        while( $file = readdir( $dh ) )
        {
            if ( ( $file === '.' ) ||
                 ( $file === '..' ) )
            {
                continue;
            }

            $errors = array_merge(
                $errors,
                $this->copyRecursive( 
                    $source . '/' . $file, 
                    $destination . '/' . $file,
                    $depth - 1
                )
            );
        }
        closedir( $dh );

        return $errors;
    }

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
    protected function performCopy( $fromPath, $toPath, $depth = ezcWebdavRequest::DEPTH_INFINITY )
    {
        $errors = $this->copyRecursive( $this->root . $fromPath, $this->root . $toPath, $depth );

        // Transform errors
        foreach ( $errors as $nr => $error )
        {
            $errors[$nr] = new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_423,
                str_replace( $this->root, '', $error )
            );
        }

        // Copy dead properties
        $storage = $this->getPropertyStorage( $fromPath );
        $this->storeProperties( $toPath, $storage );

        // Updateable live properties are updated automagically, because they
        // are regenerated on request on base of the file they affect. So there
        // is no reason to keep them "alive".

        return $errors;
    }

    /**
     * Check recusively if everything can be deleted.
     *
     * Check files and directories recursively, if everything can be deleted.
     *
     * Returns an empty array if no errors occured, and an array with the files
     * which caused errors otherwise.
     *
     * @param string $source 
     * @return array
     */
    public function checkDeleteRecursive( $source )
    {
        // Skip non readable files in source directory, or non writeable
        // destination directories.
        if ( !is_writeable( dirname( $source ) ) )
        {
            return array( $source );
        }

        if ( is_file( $source ) )
        {
            // For plain files the above checks should be sufficant
            return array();
        }

        // Recurse
        $dh = opendir( $source );
        $errors = array();
        while( $file = readdir( $dh ) )
        {
            if ( ( $file === '.' ) ||
                 ( $file === '..' ) )
            {
                continue;
            }

            $errors = array_merge(
                $errors,
                $this->checkDeleteRecursive( $source . '/' . $file )
            );
        }
        closedir( $dh );

        // Return errors
        return $errors;
    }

    /**
     * Delete everything below this path.
     *
     * Returns an error response if the deletion failed, and null on success.
     * 
     * @param string $path 
     * @return ezcWebdavErrorResponse
     */
    protected function performDelete( $path )
    {
        $errors = $this->checkDeleteRecursive( $this->root . $path );

        // If an error will occur return the proper status
        if ( count( $errors ) )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_403,
                $path
            );
        }

        // Just delete otherwise
        if ( is_file( $this->root . $path ) )
        {
            unlink( $this->root . $path );
        }
        else
        {
            ezcBaseFile::removeRecursive( $this->root . $path );
        }

        // Finally empty property storage for removed node
        $storagePath = $this->getPropertyStoragePath( $path );
        if ( is_file( $storagePath ) )
        {
            unlink( $storagePath );
        }

        return null;
    }

    /**
     * Check if node exists.
     *
     * Check if a node exists with the given path.
     * 
     * @param string $path 
     * @return bool
     */
    protected function nodeExists( $path )
    {
        return ( is_file( $this->root . $path ) || is_dir( $this->root . $path ) );
    }

    /**
     * Check if node is a collection.
     *
     * Check if the node behind the given path is a collection.
     * 
     * @param string $path 
     * @return bool
     */
    protected function isCollection( $path )
    {
        return is_dir( $this->root . $path );
    }

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
    protected function getCollectionMembers( $path )
    {
        $contents = array();
        $dh = opendir( $this->root . $path );
        $errors = array();
        while( $file = readdir( $dh ) )
        {
            // Skip files used for somethig else...
            //
            // @TODO: Mind hideDotFiles option
            if ( ( $file === '.' ) ||
                 ( $file === '..' ) ||
                 ( strpos( $file, $this->options->lockFileName ) !== false ) ||
                 ( strpos( $file, $this->options->propertyStoragePath ) !== false ) )
            {
                continue;
            }

            $file = $path . '/' . $file;
            if ( is_dir( $this->root . $file ) )
            {
                // Add collection without any childs
                $contents[] = new ezcWebdavCollection( $file );
            }
            else
            {
                // Add files without content
                $contents[] = new ezcWebdavResource( $file );
            }
        }
        closedir( $dh );

        return $contents;
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
        $this->acquireLock( true );
        $return = parent::get( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock( true );
        $return = parent::head( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock( true );
        $return = parent::propFind( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock();
        $return = parent::propPatch( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock();
        $return = parent::put( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock();
        $return = parent::delete( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock();
        $return = parent::copy( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock();
        $return = parent::move( $request );
        $this->freeLock();

        return $return;
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
        $this->acquireLock();
        $return = parent::makeCollection( $request );
        $this->freeLock();

        return $return;
    }
}

?>

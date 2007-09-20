<?php
/**
 * File containing a fake file webdav backend.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
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
 * @access private
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
     * Create a new collection.
     *
     * Creates a new collection at the given path.
     * 
     * @param string $path 
     * @return void
     */
    protected function createCollection( $path )
    {
        mkdir( $this->root . $path, $this->options->directoryMode );

        // @TODO: Also create property storage?
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

        // @TODO: Also create property storage?
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

        // @TODO: Also update properties?
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
     * @param ezcWebdavProperty $property 
     * @return string
     */
    protected function getPropertyStoragePath( $resource, ezcWebdavProperty $property = null )
    {
        // Get storage path for properties depending on the type of the
        // ressource.
        if ( is_dir( $resource ) )
        {
            $storage = realpath( $this->root . $resource ) . '/' . $this->options->propertyStoragePath . '/';
        }
        else
        {
            $storage = realpath( $this->root . dirname( $resource ) ) . '/' . $this->options->propertyStoragePath . '/';
        }

        // Create property storage if it does not exist yet
        if ( !is_dir( $storage ) )
        {
            mkdir( $storage, $this->options->directoryMode );
        }

        // Return root storage dir, if property has been ommitted.
        if ( $property === null )
        {
            return $storage;
        }

        // Check if sub path for namespace exists and create otherwise
        if ( !is_dir( $storage = $storage . base64_encode( $property->namespace ) ) )
        {
            mkdir( $storage, $this->options->directoryMode );
        }

        // Return path to property.
        return $storage . '/' . $property->name . '.xml';
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
        $storage = $this->getPropertyStoragePath( $resource, $property );

        // @TODO: We should handle some (/most?) of the live properties
        // differently.
        //
        // @TODO: Get rid of serialize here. We should either store them as
        // vlaid XML, or use var_export. Both make some internal serialize
        // methods fpr all properties necessary.
        file_put_contents( $storage, serialize( $property ) );
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

        $storage = $this->getPropertyStoragePath( $resource, $property );
        
        if ( is_file( $storage ) )
        {
            unlink( $storage );
        }

        return true;
    }

    /**
     * Reset property storage for a resource.
     * 
     * @param string $resource 
     * @param ezcWebdavPropertyStorage $properties
     * @return bool
     */
    public function resetProperties( $resource, ezcWebdavPropertyStorage $properties )
    {
        // Remove all properties by removing the property storage directory.
        $storageDir = $this->getPropertyStoragePath( $resource );
        ezcBaseFile::removeRecursive( $storageDir );

        // Recreate all properties
        foreach( $properties as $property )
        {
            $this->setProperty( $resource, $property );
        }
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
        $storage = $this->getPropertyStoragePath( $resource, new ezcWebdavDeadProperty( $namespace, $propertyName ) );

        // handle dead propreties
        if ( $namespace !== 'DAV:' )
        {
            return unserialize( file_get_contents( $storage ) );
        }

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
                $property->date = new DateTime( '@' . filemtime( $this->root . $resource ) );
                return $property;

            default:
                throw new Exception( 'Start handling this one immediately!' );
        }
    }

    /**
     * Manually get a property on a resource.
     * 
     * Get all properties for the given resource as a {@link
     * ezcWebdavPropertyStorage}
     *
     * @param string $resource 
     * @return ezcWebdavPropertyStorage
     */
    public function getAllProperties( $resource )
    {
        $storageDir = $this->getPropertyStoragePath( $resource );

        $storage = new ezcWebdavPropertyStorage();
        
        // Scan through namespaces
        foreach ( glob( $storageDir . '*', GLOB_ONLYDIR ) as $dir )
        {
            foreach ( glob( $dir . '/*.xml' ) as $file )
            {
                $storage->attach( 
                    unserialize( file_get_contents( $storage ) )
                );
            }
        }

        // Also attach generated live properties
        $liveProperties = array( 'getcontentlength', 'getlastmodified' );
        foreach( $liveProperties as $name )
        {
            $storage->attach( $this->getProperty( $resource, $name ) );
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
     * @throws ezcBaseFileNotFoundException
     *      If the $sourceDir directory is not a directory or does not exist.
     * @throws ezcBaseFilePermissionException 
     *      If the $sourceDir directory could not be opened for reading, or the
     *      destination is not writeable.
     * 
     * @param string $source 
     * @param string $destination 
     * @param int $depth 
     * @return void
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

        // @TODO: Copy properties

        // @TODO: Update live properties if requested

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
    protected function performDelete( $path )
    {
        // @TODO: Handle errors
        //
        if ( is_file( $this->root . $path ) )
        {
            unlink( $this->root . $path );
        }
        else
        {
            ezcBaseFile::removeRecursive( $this->root . $path );
        }

        return true;
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
        return parent::get( $request );
        $this->freeLock();
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
        return parent::head( $request );
        $this->freeLock();
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
        return parent::propFind( $request );
        $this->freeLock();
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
        return parent::propPatch( $request );
        $this->freeLock();
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
        return parent::put( $request );
        $this->freeLock();
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
        return parent::delete( $request );
        $this->freeLock();
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
        return parent::copy( $request );
        $this->freeLock();
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
        return parent::move( $request );
        $this->freeLock();
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
        return parent::makeCollection( $request );
        $this->freeLock();
    }
}

?>

<?php
/**
 * File containing the ezcCacheStorageFile class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * This class implements most of the methods which have been declared abstract 
 * in {@link ezcCacheStorage}, but also declares 2 new methods abstract, which
 * have to be implemented by storage driver itself. 
 *
 * This class is a common base class for all file system based storage classes.
 * To implement a file system based cache storage, you simply have to derive
 * from this class and implement the {@link ezcCacheStorageFile::fetchData()}
 * and {@link ezcCacheStorageFile::prepareData()} methods. Everything else is
 * done for you by the ezcCacheStorageFile base class.
 *
 * For example code of using a cache storage, see {@link ezcCacheManager}.
 *
 * The Cache package already contains several implementations of 
 * {@link ezcCacheStorageFile}. As there are:
 *
 * - ezcCacheStorageFileArray
 * - ezcCacheStorageFileEvalArray
 * - ezcCacheStorageFilePlain
 * 
 * @package Cache
 * @version //autogentag//
 */
abstract class ezcCacheStorageFile extends ezcCacheStorage
{
    /**
     * Creates a new cache storage in the given location.
     * Creates a new cache storage for a given location. The location in case
     * of this storage class is a valid file system directory.
     *
     * Options can contain the 'ttl' ( Time-To-Life ). This is per default set
     * to 1 day. The option 'permissions' can be used to define the file
     * permissions of created cache items. Specific ezcCacheStorageFile
     * implementations can have additional options.
     *
     * For details about the options see {@link ezcCacheStorageFileOptions}.
     * 
     * @param string $location               Path to the cache location
     * @param array(string=>string) $options Options for the cache.
     *
     * @throws ezcBaseFileNotFoundException
     *         If the storage location does not exist. This should usually not 
     *         happen, since {@link ezcCacheManager::createCache()} already
     *         performs sanity checks for the cache location. In case this 
     *         exception is thrown, your cache location has been corrupted 
     *         after the cache was configured.
     * @throws ezcBaseFileNotFoundException
     *         If the storage location is not a directory. This should usually 
     *         not happen, since {@link ezcCacheManager::createCache()} already
     *         performs sanity checks for the cache location. In case this 
     *         exception is thrown, your cache location has been corrupted 
     *         after the cache was configured.
     * @throws ezcBaseFilePermissionException
     *         If the storage location is not writeable. This should usually not 
     *         happen, since {@link ezcCacheManager::createCache()} already
     *         performs sanity checks for the cache location. In case this 
     *         exception is thrown, your cache location has been corrupted 
     *         after the cache was configured.
     * @throws ezcBasePropertyNotFoundException
     *         If you tried to set a non-existent option value. The accpeted 
     *         options depend on th ezcCacheStorage implementation and my 
     *         vary.
     */
    public function __construct( $location, $options = array() )
    {
        parent::__construct( $location, $options );
        // Overwrite parent set options with new ezcCacheFileStorageOptions
        $this->properties['options'] = new ezcCacheStorageFileOptions( $options );
    }
    /**
     * Fetch data from the cache.
     * This method does the fetching of the data itself. In this case, the
     * method simply includes the file and returns the value returned by the
     * include ( or false on failure ).
     * 
     * @param string $filename The file to fetch data from.
     * @return mixed The fetched data or false on failure.
     */
    abstract protected function fetchData( $filename );

    /**
     * Serialize the data for storing.
     * Serializes a PHP variable ( except type resource and object ) to a
     * executable PHP code representation string.
     * 
     * @param mixed $data Simple type or array
     * @return string The serialized data
     *
     * @throws ezcCacheInvalidDataException
     *         If the data submitted can not be handled by the implementation 
     *         of {@link ezcCacheStorageFile}. Most implementations can not
     *         handle objects and resources.
     */
    abstract protected function prepareData( $data );

    /**
     * Store data to the cache storage.
     * This method stores the given cache data into the cache, assigning the
     * ID given to it.
     *
     * The type of cache data which is expected by a ezcCacheStorage depends on
     * it's implementation. In most cases strings and arrays will be accepted, 
     * in some rare cases only strings might be accepted.
     *
     * Using attributes you can describe your cache data further. This allows 
     * you to deal with multiple cache data at once later. Some ezcCacheStorage
     * implementations also use the attributes for storage purposes. Attributes
     * form some kind of "extended ID".
     * 
     * @param string $id                        Unique identifier for the data.
     * @param mixed $data                       The data to store.
     * @param array(string=>string) $attributes Attributes describing the 
     *                                          cached data.
     * 
     * @return string The ID string of the newly cached data.
     *
     * @throws ezcBaseFilePermissionException
     *         If an already existsing cache file could not be unlinked to 
     *         store the new data (may occur, when a cache item's TTL
     *         has expired and the file should be stored with more actual
     *         data). This exception means most likely that your cache diretory
     *         has been corrupted by external influences (file permission 
     *         change).
     * @throws ezcBaseFilePermissionException
     *         If the directory to store the cache file could not be created.
     *         This exception means most likely that your cache diretory
     *         has been corrupted by external influences (file permission 
     *         change).     
     * @throws ezcBaseFileIoException
     *         If an error occured while writing the data to the cache. If this
     *         exception occurs, a serious error occured and your storage might
     *         be corruped (e.g. broken network connection, file system broken,
     *         ...).
     * @throws ezcCacheInvalidDataException
     *         If the data submitted can not be handled by the implementation 
     *         of {@link ezcCacheStorageFile}. Most implementations can not
     *         handle objects and resources.
     */
    public function store( $id, $data, $attributes = array() ) 
    {
        $filename = $this->properties['location'] . $this->generateIdentifier( $id, $attributes );
        if ( file_exists( $filename ) ) 
        {
            if ( unlink( $filename ) === false ) 
            {
                throw new ezcBaseFilePermissionException( $filename, ezcBaseFileException::WRITE, 'Could not delete existsing cache file.' );
            }
        }
        $dataStr = $this->prepareData( $data );
        $dirname = dirname( $filename );
        if ( !is_dir( $dirname ) && !mkdir( $dirname, 0777, true ) )
        {
            throw new ezcBaseFilePermissionException( $dirname, ezcBaseFileException::WRITE, 'Could not create directory to stor cache file.' );
        }
        
        if ( file_put_contents( $filename, $dataStr ) !== strlen( $dataStr ) ) 
        {
            throw new ezcBaseFileIoException( $filename, ezcBaseFileException::WRITE, 'Could not write data to cache file.' );
        }
        if ( ezcBaseFeatures::os() !== "Windows" )
        {
            chmod( $filename, $this->options->permissions );
        }
        return $id;
    }

    /**
     * Restore data from the cache.
     * Restores the data associated with the given cache and
     * returns it. Please see {@link ezcCacheStorage::store()}
     * for more detailed information of cachable datatypes.
     *
     * During access to cached data the caches are automatically
     * expired. This means, that the ezcCacheStorage object checks
     * before returning the data if it's still actual. If the cache 
     * has expired, data will be deleted and false is returned.
     *
     * You should always provide the attributes you assigned, although
     * the cache storages must be able to find a cache ID even without
     * them. BEWARE: Finding cache data only by ID can be much
     * slower than finding it by ID and attributes.
     *
     * Note that with the {@link ezcCacheStorageFilePlain} all restored data
     * will be of type string. If you expect a different data type you need to
     * perform a cast after restoring.
     *
     * @param string $id                         The item ID to restore.
     * @param array(string=>string) $attributes  Attributes describing the 
     *                                           data to restore.
     * @param bool $search                       Wheather to search for items
     *                                           if not found directly.
     * 
     * @return mixed|bool The cached data on success, otherwise false.
     *
     * @throws ezcBaseFilePermissionException
     *         If an already existsing cache file could not be unlinked. 
     *         This exception means most likely that your cache diretory
     *         has been corrupted by external influences (file permission 
     *         change).
     */
    public function restore( $id, $attributes = array(), $search = false )
    {
        $filename = $this->properties['location'] . $this->generateIdentifier( $id, $attributes );
        if ( file_exists( $filename ) === false ) 
        {
            if ( $search === true && count( $files = $this->search( $id, $attributes ) ) === 1 ) 
            {
                $filename = $files[0];
            } 
            else 
            {
                return false;
            }
        }
        // No cached data
        if ( file_exists( $filename ) === false ) 
        {
            return false;
        }
        // Cached data outdated, purge it.
        if ( $this->calcLifetime( $filename ) > $this->properties['options']['ttl'] && $this->properties['options']['ttl'] !== false ) 
        {
            $this->delete( $id, $attributes );
            return false;
        }
        return ( $this->fetchData( $filename ) );
    }

    /**
     * Delete data from the cache.
     * Purges the cached data for a given ID and or attributes. Using an ID
     * purges only the cache data for just this ID. 
     *
     * Additional attributes provided will matched additionally. This can give
     * you an immense speed improvement against just searching for ID ( see 
     * {@link ezcCacheStorage::restore()} ).
     *
     * If you only provide attributes for deletion of cache data, all cache
     * data matching these attributes will be purged.
     *
     * @param string $id                         The item ID to purge.
     * @param array(string=>string) $attributes  Attributes describing the 
     *                                           data to restore.
     * @param bool $search                       Wheather to search for items
     *                                           if not found directly.
     * @return void
     *
     * @throws ezcBaseFilePermissionException
     *         If an already existsing cache file could not be unlinked. 
     *         This exception means most likely that your cache diretory
     *         has been corrupted by external influences (file permission 
     *         change).
     */
    public function delete( $id = null, $attributes = array(), $search = false )
    {
        $filename = $this->properties['location'] . $this->generateIdentifier( $id, $attributes );
        $delFiles = array();
        if ( file_exists( $filename ) ) 
        {
            $delFiles[] = $filename;
        } 
        else if ( $search === true )
        {
            $delFiles = $this->search( $id, $attributes );
        }
        foreach ( $delFiles as $filename ) 
        {
            if ( unlink( $filename ) === false ) 
            {
                throw new ezcBaseFilePermissionException( $filename, ezcBaseFileException::WRITE, 'Could not unlink cache file.' );
            }
        }
    }

    /**
     * Return the number of items in the cache matching a certain criteria.
     * This method determines if cache data described by the given ID and/or
     * attributes exists. It returns the number of cache data items found.
     *
     * @param string $id                         The item ID.
     * @param array(string=>string) $attributes  Attributes describing the 
     *                                           data to restore.
     * @return int Number of data items matching the criteria. 
     */
    public function countDataItems( $id = null, $attributes = array() )
    {
        return count( $this->search( $id, $attributes ) );
    }

    /**
     * Returns the time ( in seconds ) which remains for a cache object,
     * before it gets outdated. In case the cache object is already 
     * outdated or does not exists, this method returns 0.
     * 
     * @param string $id                         The item ID.
     * @param array(string=>string) $attributes  Attributes describing the 
     *                                           data to restore.
     * @access public
     * @return int The remaining lifetime (0 if nonexists or oudated).
     */
    public function getRemainingLifetime( $id, $attributes = array() )
    {
        if ( count( $objects = $this->search( $id, $attributes ) ) > 0 ) 
        {
            $lifetime = $this->calcLifetime( $objects[0] );
            return ( ( $remaining = ( $this->properties['options']['ttl'] - $lifetime ) ) > 0 ) ? $remaining : 0;
        }
        return 0;
    }

    /**
     * Search the storage for data.
     * 
     * @param string $id                         An item ID.
     * @param array(string=>string) $attributes  Attributes describing the 
     *                                           data to restore.
     * @return array(int=>string) Found cache items.
     */
    protected function search( $id = null, $attributes = array() )
    {
        $globArr = explode( "-", $this->generateIdentifier( $id, $attributes ), 2 );
        if ( sizeof( $globArr ) > 1 )
        {
            $glob = $globArr[0]  . "-" . strtr( $globArr[1], array( '-' => '*', '.' => '*' ) );
        }
        else
        {
            $glob = strtr( $globArr[0], array( '-' => '*', '.' => '*' ) );
        }
        $glob = ( $id === null ? '*' : '' ) . $glob;
        return $this->searchRecursive( $glob, $this->properties['location'] );
    }

    /**
     * Search the storage for data recursively. 
     * 
     * @param string $pattern  Pattern used with {@link glob()}.
     * @param mixed $directory Directory to search in.
     * @return array(int=>string) Found cache items.
     */
    protected function searchRecursive( $pattern, $directory )
    {
        $itemArr = glob( $directory . $pattern );
        $dirArr = glob( $directory . "*", GLOB_ONLYDIR );
        foreach ( $dirArr as $dirEntry )
        {
            $result = $this->searchRecursive( $pattern, "$dirEntry/" );
            $itemArr = array_merge( $itemArr, $result );
        }
        return $itemArr;
    }

    /**
     * Checks the path in the location property exists, and is read-/writable. It
     * throws an exception if not.
     *
     * @throws ezcBaseFileNotFoundException
     *         If the storage location does not exist. This should usually not 
     *         happen, since {@link ezcCacheManager::createCache()} already
     *         performs sanity checks for the cache location. In case this 
     *         exception is thrown, your cache location has been corrupted 
     *         after the cache was configured.
     * @throws ezcBaseFileNotFoundException
     *         If the storage location is not a directory. This should usually 
     *         not happen, since {@link ezcCacheManager::createCache()} already
     *         performs sanity checks for the cache location. In case this 
     *         exception is thrown, your cache location has been corrupted 
     *         after the cache was configured.
     * @throws ezcBaseFilePermissionException
     *         If the storage location is not writeable. This should usually not 
     *         happen, since {@link ezcCacheManager::createCache()} already
     *         performs sanity checks for the cache location. In case this 
     *         exception is thrown, your cache location has been corrupted 
     *         after the cache was configured.
     */
    protected function validateLocation()
    {
        if ( file_exists( $this->properties['location'] ) === false ) 
        {
            throw new ezcBaseFileNotFoundException( $this->properties['location'], 'cache location' );
        }
            
        if ( is_dir( $this->properties['location'] ) === false ) 
        {
            throw new ezcBaseFileNotFoundException( $this->properties['location'], 'cache location', 'Cache location not a directory.' );
        }

        if ( is_writeable( $this->properties['location'] ) === false ) 
        {
            throw new ezcBaseFilePermissionException( $this->properties['location'], ezcBaseFileException::WRITE, 'Cache location is not a directory.' );
        }
    }

    /**
     * Generate the storage internal identifier from ID and attributes.
     *
     * Generates the storage internal identifier out of the provided ID and the
     * attributes. This is the default implementation and can be overloaded if
     * necessary.
     *
     * @param string $id                         The ID.
     * @param array(string=>string) $attributes  Attributes describing the 
     *                                           data to restore.
     * @return string              The generated identifier
     */
    public function generateIdentifier( $id, $attributes = null )
    {
        $filename = (string) $id;
        $illegalFileNameChars = array(
            ' '  => '_',
            '/'  => DIRECTORY_SEPARATOR,
            '\\' => DIRECTORY_SEPARATOR,
        );
        $filename = strtr( $filename, $illegalFileNameChars );
      
        // Chars used for filename concatination
        $illegalChars = array(
            '-' => '#',
            ' ' => '%',
            '=' => '+',
            '.' => '+',
        );
        if ( is_array( $attributes ) && count( $attributes ) > 0 ) 
        {
            ksort( $attributes );
            foreach ( $attributes as $key => $val ) 
            {
                $attrStr = '-' . strtr( $key, $illegalChars ) . '=' . strtr( $val, $illegalChars );
                if ( strlen( $filename . $attrStr ) > 250 ) 
                {
                    // Max filename length
                    break;
                }
                $filename .= $attrStr;
            }   
        }
        else
        {
            $filename .= "-";
        }
        return $filename . $this->properties['options']['extension'];
    }


    /**
     * Set new options.
     * This method allows you to change the options of a cache file storage. Change 
     * of options take effect directly after this method has been called. The 
     * available options depend on the ezcCacheStorageFile implementation. All 
     * implementations have to offer the following options:
     *
     * - ttl         The time-to-life. After this time span, a cache item becomes
     *               invalid and will be purged. The 
     *               {@link ezcCacheStorage::restore()} method will then return 
     *               false.
     * - extension   The "extension" for your cache items. This is usually the 
     *               file name extension, when you deal with file system based
     *               caches or e.g. a database ID extension.
     * - permissions The file permissions to set for new files.
     *
     * The usage of ezcCacheStorageOptions and arrays for setting options is
     * deprecated, but still supported. You should migrate to
     * ezcCacheStorageFileOptions.
     *
     * @param ezcCacheStorageFileOptions $options The options to set (accepts
     *                                            ezcCacheStorageOptions or 
     *                                            array for compatibility 
     *                                            reasons, too).
     *
     * @throws ezcBasePropertyNotFoundException
     *         If you tried to set a non-existent option value. The accpeted 
     *         options depend on th ezcCacheStorage implementation and my 
     *         vary.
     * @throws ezcBaseValueException
     *         If the value is not valid for the desired option.
     * @throws ezcBaseValueException
     *         If you submit neither an instance of ezcCacheStorageFileOptions,
     *         nor an instance of ezcCacheStorageOptions nor an array.
     */
    public function setOptions( $options )
    {
        if ( is_array( $options ) )
        {
            $this->properties['options']->merge( $options );
        }
        else if ( $options instanceof ezcCacheStorageFileOptions )
        {
            $this->properties['options'] = $options;
        }
        else if ( $options instanceof ezcCacheStorageOptions )
        {
            $this->properties['options']->mergeStorageOptions( $options );
        }
        else
        {
            throw new ezcBaseValueException( "options", $options, "instance of ezcCacheStorageFileOptions or (deprecated) ezcCacheStorageOptions" );
        }
    }

    /**
     * Calculates the lifetime remaining for a cache object. 
     * This calculates the time a cached object stays valid and returns it.
     * 
     * @param string $file The file to calculate the remaining lifetime for.
     * @access protected
     * @return int The remaining lifetime in seconds ( 0 if no time remaining ).
     */
    protected function calcLifetime( $file )
    {
        if ( ( file_exists( $file ) !== false ) && ( ( $modTime = filemtime( $file ) ) !== false ) ) 
        {
            return ( ( $lifeTime = ( time() - $modTime ) ) > 0 ) ? $lifeTime : 0;
        }
    }

    /**
     * Property write access.
     * 
     * @param string $propertyName Name of the property.
     * @param mixed $val  The value for the property.
     *
     * @throws ezcBaseValueException 
     *         If a the value for the property options is not an instance of 
     *         ezcCacheStorageOptions. 
     * @ignore
     */
    public function __set( $propertyName, $val )
    {
        switch ( $propertyName ) 
        {
            case 'options':
                if ( $val instanceof ezcCacheStorageFileOptions )
                {
                    $this->options = $val;
                }
                else if ( $val instanceof ezcCacheStorageOptions )
                {
                    $this->options->mergeStorageOptions( $val );
                }
                else
                {
                    throw new ezcBaseValueException( $propertyName, $val, 'instance of ezcCacheStorageFileOptions' );
                }
                $this->properties['options'] = $val;
                return;
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }
}
?>

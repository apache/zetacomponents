<?php
/**
 * File containing the ezcCacheMemcacheBackend class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * This backend stores data in a Memcache.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheMemcacheBackend extends ezcCacheMemoryBackend
{
    /**
     * The compress threshold.
     *
     * Nearly 1MB (48,576B less).
     */
    const COMPRESS_THRESHOLD = 1000000;

    /**
     * Holds an instance to a Memcache object.
     *
     * @var resource
     */
    protected $memcache;

    /**
     * Holds the options for this class.
     *
     * @var ezcCacheStorageMemcacheOptions
     */
    protected $options;

    /**
     * Constructs a new ezcCacheMemcacheBackend object.
     *
     * For options for this backend see {@link ezcCacheStorageMemcacheOptions}.
     *
     * @throws ezcBaseExtensionNotFoundException
     *         If the PHP memcache and zlib extensions are not installed.
     * @throws ezcCacheMemcacheException
     *         If the connection to the Memcache host did not succeed.
     *
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'memcache' ) )
        {
            throw new ezcBaseExtensionNotFoundException( 'memcache', null, "PHP not configured with --enable-memcache." );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'zlib' ) )
        {
            throw new ezcBaseExtensionNotFoundException( 'zlib', null, "PHP not configured with --with-zlib." );
        }

        $this->options = new ezcCacheStorageMemcacheOptions( $options );
        $this->memcache = new Memcache();
        if ( $this->options->persistent === true )
        {
            if ( !@$this->memcache->pconnect( $this->options->host, $this->options->port, $this->options->ttl ) )
            {
                throw new ezcCacheMemcacheException( 'Could not connect to Memcache using a persistent connection.' );
            }
        }
        else
        {
            if ( !@$this->memcache->connect( $this->options->host, $this->options->port, $this->options->ttl ) )
            {
                throw new ezcCacheMemcacheException( 'Could not connect to Memcache.' );
            }
        }

        $this->memcache->setCompressThreshold( self::COMPRESS_THRESHOLD );
    }

    /**
     * Destructor for the Memcache backend.
     */
    public function __destruct()
    {
        $this->memcache->close();
    }

    /**
     * Adds the $var data to the cache under the key $key. Returns true or
     * false depending on the success of the operation.
     *
     * @param string $key
     * @param mixed $var
     * @param int $expire
     * @return bool
     */
    public function store( $key, $var, $expire = 0 )
    {
        // protect our data by wrapping it in an object
        $data = new ezcCacheMemoryVarStruct( $key, $var, $expire );
        $compressed = ( $this->options->compressed === true ) ? MEMCACHE_COMPRESSED : false;
        return $this->memcache->set( $key, $data, $this->options->compressed, $expire );
    }

    /**
     * Returns the data from the cache associated with key $key.
     *
     * @param mixed $key
     * @return mixed
     */
    public function fetch( $key )
    {
        $data = $this->memcache->get( $key );
        return ( is_object( $data ) ) ? $data->var : false;
    }

    /**
     * Deletes the data from the cache associated with key $key. Returns true or
     * false depending on the success of the operation.
     *
     * The value $timeout specifies the timeout period in seconds for the delete
     * command.
     *
     * @param string $key
     * @param int $timeout
     * @return bool
     */
    public function delete( $key, $timeout = 0 )
    {
        return $this->memcache->delete( $key, $timeout );
    }
}
?>

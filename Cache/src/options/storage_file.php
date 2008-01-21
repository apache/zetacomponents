<?php
/**
 * File containing the ezcCacheStorageFileOptions class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Option class for the ezcCacheStorageFile class.
 * Instances of this class store the option of ezcCacheStorageFile implementations.
 *
 * @property int    $ttl       The time to live of cache entries.
 * @property string $extension The (file) extension to use for the storage items.
 * @property int    $permissions     Permissions to create a file with (Posix only).
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageFileOptions extends ezcBaseOptions
{
    /**
     * Parent storage options. 
     * 
     * @var ezcCacheStorageOptions
     */
    protected $storageOptions;

    /**
     * Constructs a new options class.
     *
     * It also sets the default values of the format property
     *
     * @param array(string=>mixed) $options The initial options to set.
     
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    public function __construct( $options = array() )
    {
        $this->properties["permissions"] = 0644;
        $this->storageOptions = new ezcCacheStorageOptions();
        parent::__construct( $options );
    }

    /**
     * Sets an option.
     * This method is called when an option is set.
     * 
     * @param string $key  The option name.
     * @param mixed $value The option value.
     * @ignore
     */
    public function __set( $key, $value )
    {
        switch ( $key )
        {
            case "permissions":
                if ( !is_int( $value )  || $value < 0 || $value > 0777 )
                {
                    throw new ezcBaseValueException( $key, $value, "int > 0 and <= 0777" );
                }
                break;
            // Delegate
            default:
                $this->storageOptions->$key = $value;
                return;
        }
        $this->properties[$key] = $value;
    }

    /**
     * Property get access.
     * Simply returns a given option.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @param string $key The name of the option to get.
     * @return mixed The option value.
     * @ignore
     */
    public function __get( $key )
    {
        if ( isset( $this->properties[$key] ) )
        {
            return $this->properties[$key];
        }
        // Delegate
        return $this->storageOptions->$key;
    }

    /**
     * Returns if a option exists.
     * 
     * @param string $key Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $key )
    {
        // Delegate
        return ( array_key_exists( $key, $this->properties ) || isset( $this->storageOptions->$key ) );
    }

    /**
     * Merge an ezcCacheStorageOptions object into this object.
     * 
     * @param ezcCacheStorageOptions $options The options to merge.
     * @return void
     * @ignore
     */
    public function mergeStorageOptions( ezcCacheStorageOptions $options )
    {
        $this->storageOptions = $options;
    }
}

?>

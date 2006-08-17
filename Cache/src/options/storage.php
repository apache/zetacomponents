<?php
/**
 * File containing the ezcCacheStorageOptions class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Option class for the ezcCacheStorage class.
 * Instances of this class store the option of ezcCacheStorage implementations.
 *
 * @package Cache
 */
class ezcCacheStorageOptions extends ezcBaseOptions
{
    /**
     * The time to live. 
     * 
     * @var int
     */
    protected $ttl = 86400;   // 60 * 60 * 24 = 24 hrs

    /**
     * The (file) extension to use for the storage items.
     * 
     * @var string
     */
    protected $extension = ".cache";

    /**
     * Sets an options.
     * This method is called when an options is set.
     * 
     * @param string $key  The option name.
     * @param mixed $value The option value.
     * @return void
     */
    public function __set( $key, $value )
    {
        switch ( $key )
        {
            case "extension":
                if ( !is_string( $value ) || strlen( $value ) < 1 )
                {
                    throw new ezcBaseSettingValueException( $key, $val, "string, size > 0" );
                }
                break;
            case "ttl":
                if ( !is_int( $value ) && $value !== false )
                {
                    throw new ezcBaseSettingValueException( $key, $value, "int > 0 or false" );
                }
                break;
            default:
                throw new ezcBaseSettingNotFoundException( $key );
        }
        $this->$key = $value;
    }
}


?>

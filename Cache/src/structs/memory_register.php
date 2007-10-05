<?php
/**
 * File containing the ezcCacheStorageMemoryRegisterStruct class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Defines an APC Register structure.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageMemoryRegisterStruct extends ezcBaseStruct
{
    /**
     * Holds the ID of an entry in the registry.
     *
     * @var string
     */
    public $id;

    /**
     * Holds the attributes of an entry in the registry.
     *
     * @var array(mixed)
     */
    public $attributes;

    /**
     * Holds the identifier of an entry in the registry.
     *
     * @var string
     */
    public $identifier;

    /**
     * Holds the location of the cache.
     *
     * @var string
     */
    public $location;

    /**
     * Constructs a new ezcCacheStorageMemoryRegisterStruct.
     *
     * @param string $id
     * @param array(mixed) $attributes
     * @param string $identifier
     * @param mixed $location
     */
    public function __construct( $id, $attributes, $identifier , $location )
    {
        $this->id = $id;
        $this->attributes = $attributes;
        $this->identifier = $identifier;
        $this->location = $location;
    }
}
?>

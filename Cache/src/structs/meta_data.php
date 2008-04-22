<?php
/**
 * File containing the ezcCacheMetaData struct.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Struct represnting meta data for a ezcCacheStackReplacementStrategy.
 *
 * This struct is stored and restored by {@link ezcCacheStackMetaDataStorage}
 * storages and used by a {@link ezcCacheStackReplacementStrategy}. The
 * replacement strategy is identified through the {@link
 * ezcCacheStackMetaData::$id}, which should be the class name of the
 * replacement strategy. Replacement strategies need this id to check
 * that the data in {@link ezcCacheStackMetaData::$data} is computable. The
 * $data can by any arbitrary array structure, which does not include objects
 * and resources.
 * 
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStackMetaData extends ezcBaseStruct
{
    /**
     * Identifier of the replacement strategy.
     *
     * The id of the {@link ezcCacheStackReplacementStrategy}. Used to
     * check if the stored $data is computable.
     * 
     * @var string
     */
    public $id;

    /**
     * Meta data.
     *
     * The meta data for a {@link ezcCacheStackReplacementStrategy}. The
     * strategy is identified by the $id. This may include any
     * arbitrary data, except objects and resources. Usually, the nesting level
     * and complexity of this array is quite high.
     * 
     * @var array(mixed)
     */
    public $data = array();

    /**
     * Creates a new meta data struct.
     *
     * Creates a new meta data struct with the given $id and $data.
     * 
     * @param string $id 
     * @param array $data 
     * @return void
     */
    public function __construct( $id, array $data )
    {
        $this->id   = $id;
        $this->data = $data;
    }
}

?>

<?php
/**
 * File containing the ezcCacheInvalidMetaDataException
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if an {@link ezcCacheStackReplacementStrategy} could not process the
 * given {@link ezcCacheStackMetaData}.
 *
 * @see ezcCacheStackReplacementStrategy::store()
 * @see ezcCacheStackReplacementStrategy::restore()
 * @see ezcCacheStackReplacementStrategy::delete()
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheInvalidMetaDataException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheInvalidMetaDataException.
     * 
     * @param ezcCacheStackMetaData $metaData 
     * @param string $id 
     */
    function __construct( ezcCacheStackMetaData $metaData, $id )
    {
        parent::__construct(
            "The given meta data with ID '{$metaData->id}' could not be handled by replacement strategy with ID '$id'."
        );
    }
}
?>

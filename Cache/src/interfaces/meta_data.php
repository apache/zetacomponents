<?php
/**
 * File containing the ezcCacheStackMetaDatainterface.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Interface for stack meta data.
 *
 * This interface describes the methods that must be supported by a meta data
 * class that is to be used with a {@link ezcCacheStackReplacementStrategy} and
 * therefore used with {@link ezcCacheStackMetaDataStorage::storeMetaData()}
 * and {@link ezcCacheStackMetaDataStorage::restoreMetaData()}.
 * 
 * @package Cache
 * @version //autogen//
 */
interface ezcCacheStackMetaData extends ezcBasePersistable
{
}

?>

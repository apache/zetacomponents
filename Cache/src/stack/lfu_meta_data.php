<?php
/**
 * File containing the ezcCacheStackLfuMetaData class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Meta data for the LFU replacement strategy.
 *
 * This meta data class is to be used with the {@link ezcCacheStackLfuMetaData}.
 *
 * @package Cache
 * @version //autogen//
 *
 * @access private
 */
class ezcCacheStackLfuMetaData extends ezcCacheStackBaseMetaData
{
    /**
     * Adds the given $itemId to the replacement data.
     *
     * Initializes the entry for $itemId with 1, if it does not exist, yet.
     * Increments the entry by 1, if it does exist.
     * 
     * @param string $itemId 
     */
    public function addItemToReplacementData( $itemId )
    {
        if ( !isset( $this->replacementData[$itemId] ) )
        {
            $this->replacementData[$itemId] = 0;
        }
        ++$this->replacementData[$itemId];
    }
}

?>

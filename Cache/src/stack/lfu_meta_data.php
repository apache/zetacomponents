<?php
/**
 * File containing the ezcCacheStackLfuMetaData class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Cache
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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

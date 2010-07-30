<?php
/**
 * File containing the ezcCacheInvalidMetaDataException
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
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
     * @param string $class Expected class of $metaData.
     */
    function __construct( ezcCacheStackMetaData $metaData, $class )
    {
        parent::__construct(
            "The given meta data of class '" . get_class( $metaData )
            . "'could not be handled by the replacement strategy. Expected: '$class'."
        );
    }
}
?>

<?php
/**
 * File containing the ezcCacheStackStorageUsedTwiceException.
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
 * Exception that is thrown if a storage is used twice in a stack.
 *
 * @see ezcCacheStack::pushStorage()
 * @package Cache
 * @version //autogen//
 */
class ezcCacheStackStorageUsedTwiceException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheStackStorageUsedTwiceException.
     *
     * The $storage is the object that is used twice in the {@link
     * ezcCacheStack}.
     * 
     * @param ezcCacheStackableStorage $storage
     * @return void
     */
    function __construct( ezcCacheStackableStorage $storage )
    {
        parent::__construct(
            "The storage of type '"
            . get_class( $storage ) 
            . "' with location '"
            . $storage->location 
            . "' is already used in the stack."
        );
    }
}
?>

<?php
/**
 * File containing the ezcCacheMemcacheException class.
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
 * Thrown when encountering an error in the Memcache backend.
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheMemcacheException extends ezcBaseException
{
    /**
     * Creates a new ezcCacheMemcacheException.
     * 
     * @param mixed $message The message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

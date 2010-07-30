<?php
/**
 * File containing the ezcPersistentObjectException class
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
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * General exception class for the PersistentObject package.
 *
 * All exceptions in the persistent object package are derived from this exception.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectException extends ezcBaseException
{

    /**
     * Constructs a new ezcPersistentObjectException with error message $message and reason code $reason.
     *
     * Reason can be omitted if not applicable.
     *
     * @param string $message
     * @param string $reason
     * @return void
     */
    public function __construct( $message, $reason = null )
    {
        $message = $reason !== null ? "$message ($reason)" : $message;
        parent::__construct( $message );
    }
}
?>

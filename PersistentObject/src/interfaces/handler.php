<?php
/**
 * File containing the ezcPersistentSessionHandler abstract base class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Base class for handler classes of ezcPersistentSession.
 *
 * This base class should be used to realized handler classes for {@link
 * ezcPersistentSession}, which are used to structure the methods provided by
 * {@link ezcPersistentSession}.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @access private
 */
abstract class ezcPersistentSessionHandler
{
    /**
     * Session object this instance belongs to.
     * 
     * @var ezcPersistentSession
     */
    protected $session;

    /**
     * Database connection from {@link $session}. 
     *
     * Kept to avoid a call to {@link ezcPersistentSession->__get()} whenever
     * the database connection is used.
     * 
     * @var ezcDbHandler
     */
    protected $database;

    /**
     * Definition manager from {@link $session}. 
     * 
     * Kept to avoid a call to {@link ezcPersistentSession->__get()} whenever
     * the definition manager is used.
     *
     * @var ezcPersistentDefinitionManager
     */
    protected $definitionManager;

    /**
     * Creates a new load handler.
     * 
     * @param ezcPersistentSession $session 
     */
    public function __construct( ezcPersistentSession $session )
    {
        $this->session           = $session;
        $this->database          = $session->database;
        $this->definitionManager = $session->definitionManager;
    }
}

?>

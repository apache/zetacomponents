<?php
/**
 * File containing the ezcPersistentMultiManager class
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
 * Makes it possible to fetch persistent object definitions from several sources.
 *
 * The multimanager will try each of the provided ezcPersistentDefinitionManagers
 * to locate a valid definition for a class.
 *
 * For best performance add the managers which are most likely to contain the definitions
 * first.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentMultiManager extends ezcPersistentDefinitionManager
{
    /**
     * Holds the list of managers.
     *
     * @var array(ezcPersistentDefinitionManager)
     */
    private $managers;

    /**
     * Constructs a new multimanager that will look for persistent object definitions
     * in all $managers.
     *
     * @param array(ezcPersistentDefinitionManager) $managers
     */
    public function __construct( array $managers = array() )
    {
        $this->managers = $managers;
    }

    /**
     * Adds a manager that can provide persistent object definitions.
     *
     * @param ezcPersistentDefinitionManager $manager
     * @return void
     */
    public function addManager( ezcPersistentDefinitionManager $manager )
    {
        $this->managers[] = $manager;
    }

    /**
     * Returns the definition of the persistent object with the class $class.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @param string $class
     * @return ezcPersistentDefinition
     */
    public function fetchDefinition( $class )
    {
        $def = null;
        $errors = "";
        foreach ( $this->managers as $man )
        {
            try
            {
                $def = $man->fetchDefinition( $class );
            }
            catch ( ezcPersistentDefinitionNotFoundException $e )
            {
                $errors = $e->getMessage() . "\n";
            }

            if ( $def !== null )
            {
                return $def;
            }
        }
        throw new ezcPersistentDefinitionNotFoundException( $class, $errors );
    }
}
?>

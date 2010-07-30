<?php
/**
 * File containing the ezcSearchEmbeddedManager class
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
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Handles document type definitions embedded in the class the definitions are for.
 *
 * It calls the fetchDefinition() method on the class in order to retrieve the
 * definition. This method is required to return an ezcSearchDocumentDefinition
 * object. The method is part of the interface ezcSearchDefinitionProvider.
 *
 * @version //autogen//
 * @package Search
 */
class ezcSearchEmbeddedManager implements ezcSearchDefinitionManager
{
    /**
     * Holds the search document definitions that are currently cached.
     *
     * @var array(string=>ezcSearchDocumentDefinition)
     */
    private $cache = array();

    /**
     * Constructs a new embedded manager.
     */
    public function __construct()
    {
    }

    /**
     * Returns the definition of the search document with the type $type.
     *
     * @throws ezcSearchDoesNotProvideDefinitionException if no such definition can be found.
     * @throws ezcSearchDefinitionInvalidException
     *         if the definition does not have an "idProperty" attribute.
     * @param string $type
     * @return ezcSearchDocumentDefinition
     */
    public function fetchDefinition( $type )
    {
        // check the cache
        if ( isset( $this->cache[$type] ) )
        {
            return $this->cache[$type];
        }

        // check for interface implementation
        if ( !in_array( 'ezcSearchDefinitionProvider', class_implements( $type ) ) )
        {
            throw new ezcSearchDoesNotProvideDefinitionException( $type );
        }

        // load definition
        $definition = call_user_func( array( $type, 'getDefinition' ) );

        if ( $definition->idProperty === null )
        {
            throw new ezcSearchDefinitionInvalidException( 'embedded', $type, null, 'Missing ID property' );
        }

        // store in cache
        $this->cache[$type] = $definition;

        // return
        return $definition;
    }
}

?>

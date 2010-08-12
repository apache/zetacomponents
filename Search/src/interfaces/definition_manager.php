<?php
/**
 * File containing the ezcSearchDefinitionManager class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Defines the interface for all persistent object definition managers.
 *
 * Definition managers are used to fetch the definition of a specific
 * persistent object. The definition is returned in form of a
 * ezcSearchDocumentDefinition structure.
 *
 * @version //autogen//
 * @package Search
 */
interface ezcSearchDefinitionManager
{
    /**
     * Returns the definition of the document type $type.
     *
     * @throws ezcSearchDefinitionNotFoundException if no such definition can be found.
     * @param string $type
     * @return ezcSearchDocumentDefinition
     */
    public function fetchDefinition( $type );
}
?>

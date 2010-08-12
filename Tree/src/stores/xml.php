<?php
/**
 * File containing the ezcTreeXmlDataStore interface.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXmlDataStore is an interface defining common methods for XML based
 * data stores.
 *
 * @package Tree
 * @version //autogentag//
 */
interface ezcTreeXmlDataStore extends ezcTreeDataStore
{
    /**
     * Associates the DOM tree for which this data store stores data for with
     * this store.
     *
     * @param DOMDocument $dom
     */
    public function setDomTree( DOMDocument $dom );
}
?>

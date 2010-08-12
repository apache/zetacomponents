<?php
/**
 * File containing the ezcSearchFieldNotDefinedException class.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception thrown when a field name is used that has not been defined
 * through the document definition.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchFieldNotDefinedException extends ezcSearchException
{
    /**
     * Constructs an ezcSearchFieldNotDefinedException for document type $type
     * and field $field.
     *
     * @param string $type
     * @param string $field
     */
    public function __construct( $type, $field )
    {
        $message = "The document type '$type' does not define the field '$field'.";
        parent::__construct( $message );
    }
}
?>

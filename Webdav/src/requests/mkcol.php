<?php
/**
 * File containing the ezcWebdavMakeCollectionRequest class.
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
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Abstract representation of a MKCOL request.
 *
 * An instance of this class represents the WebDAV MKCOL request.
 *
 * @property string $body
 *           The request body of a MKCOL request.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavMakeCollectionRequest extends ezcWebdavRequest
{
    /**
     * Creates a new MKCOL request object.
     *
     * The request contains of the $requestUri which indicates where a
     * collection should be created and an optional request $body.
     * 
     * @param string $requestUri
     * @param string $body
     * @return void
     */
    public function __construct( $requestUri, $body = null )
    {
        // Set from constructor values
        parent::__construct( $requestUri );

        // Create properties
        $this->properties['body'] = $body;
    }

    /**
     * Sets a property.
     *
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @return void
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBaseValueException
     *         if the value to be assigned to a property is invalid.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a read-only property.
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'body':
                throw new ezcBasePropertyPermissionException( 
                    $propertyName,
                    ezcBasePropertyPermissionException::READ
                );

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

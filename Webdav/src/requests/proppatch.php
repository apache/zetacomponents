<?php
/**
 * File containing the ezcWebdavPropPatchRequest class.
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
 * Abstract representation of a PROPPATCH request.
 *
 * An instance of this class represents the WebDAV PROPPATCH request.
 *
 * An object of this class may contain any number of {@link ezcWebdavProperty}
 * objects in both properties: {@link $set} and {$remove}. Both properties
 * represent the corresponding XML elements used inside the <propertyupdate />
 * XML element of the request body.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @property ezcWebdavPropertyStorage $set
 *           Represents the properties contained in <set /> XML elements.
 * @property ezcWebdavPropertyStorage $remove
 *           Represents the properties contained in <remove /> XML elements.
 */
class ezcWebdavPropPatchRequest extends ezcWebdavRequest
{
    /**
     * Flagged {@link ezcWebdavFlaggedPropertyStorage} indicating this property
     * should be set or updated.
     */
    const SET = 1;

    /**
     * Flagged {@link ezcWebdavFlaggedPropertyStorage} indicating this property
     * should be removed.
     */
    const REMOVE = 2;

    /**
     * Creates a new PROPPATCH request object.
     *
     * The $requestUri identifies the resources for which properties should be
     * patched.
     * 
     * @param string $requestUri
     * @return void
     */
    public function __construct( $requestUri )
    {
        // Set from constructor values
        parent::__construct( $requestUri );
        
        // Create properties
        $this->properties['updates'] = new ezcWebdavFlaggedPropertyStorage();
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
            case 'updates':
                if ( !( $propertyValue instanceof ezcWebdavFlaggedPropertyStorage ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavFlaggedPropertyStorage' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

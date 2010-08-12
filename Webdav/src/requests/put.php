<?php
/**
 * File containing the ezcWebdavPutRequest class.
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
 * Abstract representation of a PUT request.
 *
 * An instance of this class represents the WebDAV PUT request.
 *
 * @property string $body
 *           The request body of a PUT request.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavPutRequest extends ezcWebdavRequest
{
    /**
     * Creates a new PUT request object.
     *
     * The request object indicates, that the given $body should be stored in
     * the resource identified by $requestUri.
     * 
     * @param string $requestUri
     * @param string $body
     * @return void
     */
    public function __construct( $requestUri, $body )
    {
        // Set from constructor values
        parent::__construct( $requestUri );
        
        // Create properties
        $this->properties['body'] = (string) $body;
    }

    /**
     * Validates the headers set in this request.
     *
     * This method validates that all required headers are available and that
     * all feasible headers for this request have valid values.
     *
     * @return void
     *
     * @throws ezcWebdavMissingHeaderException
     *         if a required header is missing.
     * @throws ezcWebdavInvalidHeaderException
     *         if a header is present, but its content does not validate.
     */
    public function validateHeaders()
    {
        if ( !isset( $this->headers['Content-Length'] ) )
        {
            throw new ezcWebdavMissingHeaderException( 'Content-Length' );
        }
        if ( !isset( $this->headers['Content-Type'] ) )
        {
            $this->setHeader( 'Content-Type', 'application/octet-stream' );
        }

        // Validate common HTTP/WebDAV headers
        parent::validateHeaders();
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

<?php
/**
 * File containing the class representing a PUT request to the WebDAV server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct-like class representing all relevant information about a webdav PUT
 * request.
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
     * The request is created from the collection, which should be created and
     * a request body.
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
     * Sets a property.
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
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

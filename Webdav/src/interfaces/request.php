<?php
/**
 * File containing the class representing a request to the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class for request objects.
 * This base class must be extended by all request representation classes.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcWebdavRequest
{
    /**
     * Constants for request types.
     *
     * @todo Remove these from here, they are only for testing!
     */
    const GET       = 1;
    const HEAD      = 2;
    const PUT       = 4;
    const PROPFIND  = 8;
    const PROPPATCH = 16;
    const DELETE    = 32;
    const COPY      = 64;
    const MOVE      = 128;
    const MKCOL     = 256;

    /**
     * Constants for the 'Depth' header and property fields. 
     *
     * @see ezcWebdavLockDiscoveryPropertyActiveLock
     */
    const DEPTH_ZERO      =  0;
    const DEPTH_ONE       =  1;
    const DEPTH_INFINITY  = -1;

    /**
     * Container to hold the properties
     *
     * @var array(string=>mixed)
     */
    protected $properties = array();


    /**
     * Container for header information. 
     * 
     * @var array(string=>mixed)
     */
    protected $headers = array();

    /**
     * Validates the headers set in this request.
     * This method is called by ezcWebdavServer after the request object has
     * been created by an ezcWebdavTransport. It must validate all headers
     * specific for this request for existance of required headers and validity
     * of all headers used  by the specific request implementation. The call of
     * the parent method is *mandatory* to have common WebDAV and HTTP headers
     * validated, too!
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
        // @todo Implement general header checks here.
    }

    /**
     * Sets a header to a specified value.
     * Sets the value for $header to $headerValue. All processable headers will
     * be validated centrally in {@link validateHeaders()}.
     *
     * For validation of header content, the method {@link validateHeaders()}
     * can be overwritten.
     * 
     * @param string $headerName 
     * @param mixed $headerValue 
     * @return void
     */
    public final function setHeader( $headerName, $headerValue )
    {
        $this->headers[$headerName] = $headerValue;
    }

    /**
     * Returns the contents of a specific header.
     * Returns the content of the header identified with $headerName with the
     * given name and null if no content for the header is available.
     * 
     * @param string $headerName 
     * @return mixed
     */
    public final function getHeader( $headerName )
    {
        return isset( $this->headers[$headerName] ) ? $this->headers[$headerName] : null;
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
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Property get access.
     * Simply returns a given property.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property propertys is not an instance of
     * @param string $propertyName The name of the property to get.
     * @return mixed The property value.
     *
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a write-only property.
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) === true )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Returns if a property exists.
     * Returns true if the property exists in the {@link $properties} array
     * (even if it is null) and false otherwise. 
     *
     * @param string $propertyName Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>

<?php
/**
 * File containing the class representing a response from the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class for all response objects.
 * This base class must be extended by all response representation classes.
 *
 * @property string $requestUri
 *           Request URI the error occured for.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavErrorResponse extends ezcWebdavResponse
{
    /**
     * Construct error response from status and requested URI.
     * 
     * @param int $status 
     * @param string $requestUri 
     * @return void
     */
    public function __construct( $status, $requestUri = null )
    {
        parent::__construct( $status );

        if ( $requestUri !== null )
        {
            $this->requestUri = $requestUri;
        }
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
            case 'requestUri':
                if ( !is_string( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Return valid HTTP response string from error code.
     * 
     * @return string
     */
    public function __toString()
    {
        return 'HTTP/1.1 ' . $this->status . ' ' . self::$errorNames[$this->status];
    }
}

?>

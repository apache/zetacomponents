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
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavErrorResponse extends ezcWebdavResponse
{
    /**
     * Error status codes
     */
    const STATUS_403        = 403;
    const STATUS_404        = 404;
    const STATUS_409        = 409;
    const STATUS_412        = 412;
    const STATUS_423        = 423;

    const STATUS_502        = 502;
    const STATUS_507        = 507;

    /**
     * User readable names for error status codes
     * 
     * @var array
     */
    static public $errorNames = array(
        self::STATUS_403        => 'Forbidden',
        self::STATUS_404        => 'Not Found',
        self::STATUS_409        => 'Conflict',
        self::STATUS_412        => 'Precondition Failed',
        self::STATUS_423        => 'Locked',

        self::STATUS_502        => 'Bad Gateway',
        self::STATUS_507        => 'Insufficient Storage',
    );

    /**
     * Construct error response from status and requested URI.
     * 
     * @param int $status 
     * @param string $requestUri 
     * @return void
     */
    public function __construct( $status, $requestUri = null )
    {
        $this->status = $status;

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
            case 'status':
                if ( !isset( self::$errorNames[$propertyValue] ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'HTTP error code' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

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

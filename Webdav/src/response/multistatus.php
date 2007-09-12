<?php
/**
 * File containing the class representing a multistatus response from the
 * webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class for multistatus responses, aggregating other responses.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavMultistatusResponse extends ezcWebdavResponse
{
    /**
     * Construct multistatus from any number of requests, provided either in
     * arrays with requests or directly as constructor parameters.
     * 
     * @param int $status 
     * @param string $requestUri 
     * @return void
     */
    public function __construct()
    {
        $params = func_get_args();
        $responses = array();

        foreach ( $params as $param )
        {   
            // Flatten array structure, if given
            if ( is_array( $param ) )
            {
                foreach( $param as $value )
                {
                    $responses[] = $value;
                }

                continue;
            }

            // Just add everything else
            $responses[] = $param;
        }

        $this->responses = $responses;
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
            case 'responses':
                if ( !is_array( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'array( ezcWebdavResponse )' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

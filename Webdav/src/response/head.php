<?php
/**
 * File containing the class representing a GET response on a resource from
 * the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class used to answer GET responses on a resource by the webdav backend.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavHeadResponse extends ezcWebdavResponse
{
    /**
     * Construct head response.
     *
     * Construct head response from {@link ezcWebdavResource} or {@link
     * ezcWebdavCollection} 
     * 
     * @param mixed $resource 
     * @return void
     */
    public function __construct( $resource )
    {
        parent::__construct( ezcWebdavResponse::STATUS_200 );

        $this->resource = $resource;
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
            case 'resource':
                if ( ( ! $propertyValue instanceof ezcWebdavResource ) &&
                     ( ! $propertyValue instanceof ezcWebdavCollection ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavResource or ezcWebdavCollection' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

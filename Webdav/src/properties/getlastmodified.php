<?php
/**
 * File containing the getlastmodified property class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <getlastmodified>.
 *
 * @property DateTime $date
 *           The last modification date.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavGetLastModifiedProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavGetLastModifiedProperty.
     * 
     * @param DateTime $date The date.
     * @return void
     */
    public function __construct( DateTime $date = null )
    {
        parent::__construct( 'getlastmodified' );

        $this->date = $date;
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
            case 'date':
                if ( ( $propertyValue instanceof DateTime ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'DateTime' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

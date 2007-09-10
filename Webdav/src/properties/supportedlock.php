<?php
/**
 * File containing the supportedlock property class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <supportedlock>.
 *
 * @property array(ezcWebdavSupportedLockPropertyLockentry) $lockEntry
 *           Lock information according to <lockentry> elements.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavSupportedLockProperty extends ezcWebdavProperty
{
    /**
     * Creates a new ezcWebdavSourceProperty.
     * 
     * @param array(ezcWebdavSupportedLockPropertyLockentry) $lockEntry
     * @return void
     */
    public function __construct( array $lockEntry = null )
    {
        $this->lockEntry = $lockEntry;
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
            case 'lockEntry':
                if ( is_array( $propertyValue ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'array(ezcWebdavSupportedLockPropertyLockentry)' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>

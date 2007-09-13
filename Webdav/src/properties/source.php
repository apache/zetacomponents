<?php
/**
 * File containing the source property class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <source>.
 *
 * @property array(ezcWebdavSourcePropertyLink) $links
 *           Lock information according to <link> elements.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavSourceProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavSourceProperty.
     * 
     * @param array(ezcWebdavSourcePropertyLink) $links
     * @return void
     */
    public function __construct( array $links = array() )
    {
        parent::__construct();

        $this->links = $links;
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
            case 'links':
                if ( is_array( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'array(ezcWebdavSourcePropertyLink)' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

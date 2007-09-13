<?php
/**
 * File containing the resourcetype property class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <resourcetype>.
 *
 * @property string $type
 *           The resource type (free form).
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavResourceTypeProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavResourceTypeProperty.
     * 
     * @param string $type The resource type.
     * @return void
     */
    public function __construct( $type = null )
    {
        parent::__construct();

        $this->type = $type;
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
            case 'type':
                if ( is_string( $propertyValue ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>

<?php
/**
 * File containing the name property class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <name>.
 *
 * @property string $name
 *           The display name.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavDisplayNameProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavDisplayNameProperty.
     * 
     * @param string $name The display name.
     * @return void
     */
    public function __construct( $name = null )
    {
        parent::__construct( 'displayname' );

        $this->name = $name;
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
            case 'name':
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

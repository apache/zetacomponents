<?php
/**
 * File containing the ezcWebdavResourceTypeProperty class.
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
    const TYPE_RESSOURCE = 1;

    const TYPE_COLLECTION = 2;
    
    /**
     * Creates a new ezcWebdavResourceTypeProperty.
     *
     * The given $type indicates either a collection or non-collection
     * resource ({@link self::TYPE_COLLECTION} or {@link
     * self::TYPE_RESSOURCE}).
     * 
     * @param int $type
     * @return void
     */
    public function __construct( $type = null )
    {
        parent::__construct( 'resourcetype' );

        $this->properties['type'] = null;
        $this->type = $type;
    }

    /**
     * Sets a property.
     *
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
                if ( $propertyValue !== self::TYPE_RESSOURCE && $propertyValue !== self::TYPE_COLLECTION && $propertyValue !== null )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ezcWebdavResourceTypeProperty::TYPE_RESSOURCE, ezcWebdavResourceTypeProperty::TYPE_COLLECTION or null' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Returns if property has no content.
     *
     * Returns true, if the property has no content stored.
     * 
     * @return bool
     */
    public function hasNoContent()
    {
        return $this->properties['type'] === null;
    }
}

?>

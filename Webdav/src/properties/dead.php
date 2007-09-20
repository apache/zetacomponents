<?php
/**
 * File containing the dead property class.
 *
 * @package Webdav
 * @version //autogenetag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents a  Webdav dead property.
 *
 * @property string $content
 *           The content of a dead property.
 *
 * @version //autogenetag//
 * @package Webdav
 */
class ezcWebdavDeadProperty extends ezcWebdavProperty
{
    /**
     * Creates a new dead property.
     *
     * Creates a new dead property by namespace, name and optionally its
     * content.
     * 
     * @param string $namespace
     * @param string $name
     * @param string $content
     * @return void
     */
    public function __construct( $namespace, $name, $content = null )
    {
        parent::__construct( $namespace, $name );
        $this->content = $content;
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
            case 'content':
                if ( ( $propertyValue !== null ) && !is_string( $propertyValue ) )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'string' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Check if property has no content.
     *
     * Should return true, if property has no assigned content.
     * 
     * @access public
     * @return bool
     */
    public function hasNoContent()
    {
        return $this->properties['content'] === null;
    }
}

?>

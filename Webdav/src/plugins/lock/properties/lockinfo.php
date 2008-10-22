<?php

/**
 * Class representing the dead <lockinfo> property. 
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @property ArrayObject(ezcWebdavLockTokenInfo) $tokenInfos
 *           Contains information about the lock tokens applied to a resource.
 * @property bool $null 
 *           Whether the resource is a lock-null resource.
 */
class ezcWebdavLockInfoProperty extends ezcWebdavDeadProperty
{
    /**
     * Property namespace.
     */
    const NAMESPACE = 'http://ezcomponents.org/s/Webdav';

    /**
     * Name of the property. 
     */
    const NAME = 'lockinfo';


    public function __construct( ArrayObject $tokenInfos = null, $null = false )
    {
        parent::__construct( self::NAMESPACE, self::NAME );

        $this->tokenInfos = ( $tokenInfos === null ? new ArrayObject() : $tokenInfos );
        $this->null      = $null;
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
        return ( count( $this->properties['tokenInfos'] ) === 0 
            && $this->properties['null'] === false
        );
    }

    /**
     * Remove all contents from a property.
     *
     * Clear a property, so that it will be recognized as empty later.
     * 
     * @return void
     */
    public function clear()
    {
        $this->tokenInfos = new ArrayObject();
        $this->null      = false;
    }

    /**
     * Sets a property.
     *
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @return void
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
                if ( $propertyValue !== null )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'null' );
                }
                break;

            case 'tokenInfos':
                if ( !is_object( $propertyValue ) || !( $propertyValue instanceof ArrayObject ) )
                {
                    return $this->hasError(
                        $propertyName,
                        $propertyValue,
                        'ArrayObject(ezcWebdavLockTokenInfo)'
                    );
                }
                break;

            case 'null':
                if ( !is_bool( $propertyValue ) )
                {
                    return $this->hasError(
                        $propertyName,
                        $propertyValue,
                        'bool'
                    );
                }
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>

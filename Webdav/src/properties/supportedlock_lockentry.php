<?php
/**
 * File containing the supportedlock property lockentry class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Objects of this class are used in the ezcWebdavSupportedLockProperty class.
 *
 * @property int $LockType
 *           Constant indicating read or write lock.
 * @property int $lockscope
 *           Constant indicating exclusive or shared lock.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavSupportedLockPropertyLockentry extends ezcWebdavProperty
{
    const TYPE_READ       = 1;
    const TYPE_WRITE      = 2;
                       
    const SCOPE_SHARED    = 1;
    const SCOPE_EXCLUSIVE = 2;

    /**
     * Creates a new ezcWebdavSupportedLockPropertyLockentry.
     * 
     * @param int $LockType  Lock type (constant TYPE_*).
     * @param int $lockscope Lock scope (constant SCOPE_*).
     * @return void
     */
    public function __construct( $LockType = self::TYPE_READ, $lockscope = self::SCOPE_SHARED )
    {
        $this->LockType  = $LockType;
        $this->lockscope = $lockscope;
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
            case 'LockType':
                if ( $propertyValue !== self::TYPE_READ && $propertyValue !== self::TYPE_WRITE )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavSupportedLockPropertyLockentry::TYPE_*' );
                }
                break;
            case 'lockscope':
                if ( $propertyValue !== self::SCOPE_SHARED && $propertyValue !== self::SCOPE_EXCLUSIVE )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavSupportedLockPropertyLockentry::SCOPE_*' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}


?>

<?php
/**
 * File containing the lockdiscovery property activeLock class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Objects of this class are used in the ezcWebdavLockDiscoveryProperty class.
 *
 * @property int $depth
 *           Constant indicating 0, 1 or infinity.
 * @property string $owner
 *           Owner of this lock (free form string). Null if not provided.
 * @property DateTime|null $timeout
 *           Timeout date or null for inifinite. Null if not provided.
 * @property array(string) $tokens
 *           Tokens submitted in <locktocken> (URIs). Null if not provided.
 *           These are originally covered in additional <href> elements, which
 *           is left out here.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavLockDiscoveryPropertyActiveLock extends ezcWebdavSupportedLockPropertyLockentry
{

    /**
     * Creates a new ezcWebdavSupportedLockPropertyLockentry.
     * 
     * @param int           $lockType  Lock type (constant self::TYPE_*).
     * @param int           $lockScope Lock scope (constant self::SCOPE_*).
     * @param int           $depth     Lock depth (constant ezcWebdavRequest::DEPTH_*).
     * @param string        $owner
     * @param DateTime      $timeout
     * @param array(string) $tokens
     * @return void
     */
    public function __construct( $lockType         = self::TYPE_READ,
                                 $lockScope        = self::SCOPE_SHARED,
                                 $depth            = ezcWebdavRequest::DEPTH_INFINITY,
                                 $owner            = null,
                                 DateTime $timeout = null,
                                 $tokens           = array() )
    {
        parent::__construct( $lockType, $lockScope );
        $this->depth   = $depth;
        $this->owner   = $owner;
        $this->timeout = $timeout;
        $this->tokens  = $tokens;

        $this->name    = 'activelock';
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
            case 'depth':
                if ( $propertyValue !== ezcWebdavRequest::DEPTH_INFINITY && $propertyValue !== ezcWebdavRequest::DEPTH_ONE && $propertyValue !== ezcWebdavRequest::DEPTH_ZERO )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavLockDiscoveryPropertyActiveLock::DEPTH_*' );
                }
                break;
            case 'owner':
                if ( is_string( $propertyValue ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }
                break;
            case 'timeout':
                if ( ( $propertyValue instanceof DateTime ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'DateTime' );
                }
                break;
            case 'timeout':
                if ( ( $propertyValue instanceof DateTime ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'DateTime' );
                }
                break;
            case 'tokens':
                if ( is_array( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'array(string)' );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
        }
        $this->properties[$propertyName] = $propertyValue;
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
        return false;
    }
}


?>

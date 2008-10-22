<?php
/**
 * File containing the ezcWebdavLockDiscoveryPropertyActiveLock class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Objects of this class are used in the ezcWebdavLockDiscoveryProperty class.
 *
 * @property int $depth
 *           Constant indicating 0, 1 or infinity.
 * @property string $owner
 *           Owner of this lock (free form string). Null if not provided.
 * @property ezcWebdavDateTime|null $timeout
 *           Timeout date or null for inifinite. Null if not provided.
 * @property array(string) $tokens
 *           Tokens submitted in <locktocken> (URIs). Null if not provided.
 *           These are originally covered in additional <href> elements, which
 *           is left out here.
 *
 * @version //autogentag//
 * @package Webdav
 *
 * @access private
 */
class ezcWebdavLockDiscoveryPropertyActiveLock extends ezcWebdavSupportedLockPropertyLockentry
{

    /**
     * Creates a new ezcWebdavSupportedLockPropertyLockentry.
     *
     * The $lockType indicates the type of lock in the given $lockScope. The
     * $depth value indicates the depth of collection locks and the free-form
     * $owner string can be used to specify an identifier for the user owning
     * the lock. The $timeout object indicates the time when the lock will be
     * removed and the $tokens array contains all lock tokens that affect this
     * lock.
     *
     * @param int           $lockType  Lock type (constant ezcWebdavLockRequest::TYPE_*).
     * @param int           $lockScope Lock scope (constant ezcWebdavLockRequest::SCOPE_*).
     * @param int           $depth     Lock depth (constant ezcWebdavRequest::DEPTH_*).
     * @param string        $owner
     * @param ezcWebdavDateTime      $timeout
     * @param array(string) $tokens
     * @return void
     */
    public function __construct( $lockType           = ezcWebdavLockRequest::TYPE_READ,
                                 $lockScope          = ezcWebdavLockRequest::SCOPE_SHARED,
                                 $depth              = ezcWebdavRequest::DEPTH_INFINITY,
                                 $owner              = null,
                                 $timeout            = null,
                                 ArrayObject $tokens = null )
    {
        parent::__construct( $lockType, $lockScope );
        $this->depth   = $depth;
        $this->owner   = $owner;
        $this->timeout = $timeout;
        $this->tokens  = ( $tokens === null ? new ArrayObject() : $tokens );

        $this->name    = 'activelock';
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
            case 'depth':
                if ( $propertyValue !== ezcWebdavRequest::DEPTH_INFINITY && $propertyValue !== ezcWebdavRequest::DEPTH_ONE && $propertyValue !== ezcWebdavRequest::DEPTH_ZERO )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ezcWebdavLockDiscoveryPropertyActiveLock::DEPTH_*' );
                }
                break;
            case 'owner':
                if ( !is_string( $propertyValue ) && $propertyValue !== null )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'string' );
                }
                break;
            case 'timeout':
                if ( ( !is_int( $propertyValue ) || $propertyValue < 1 ) && $propertyValue !== null )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'int > 0' );
                }
                break;
            case 'tokens':
                if ( !is_object( $propertyValue ) || !( $propertyValue instanceof ArrayObject ) )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ArrayObject(string)' );
                }
                break;
            default:
                return parent::__set( $propertyName, $propertyValue );
        }
        $this->properties[$propertyName] = $propertyValue;
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
        return false;
    }

    /**
     * Removes all contents from a property.
     *
     * Clears the property, so that it will be recognized as empty later.
     * 
     * @return void
     */
    public function clear()
    {
        parent::clear();

        $this->properties['lockType']  = ezcWebdavLockRequest::TYPE_READ;
        $this->properties['lockScope'] = ezcWebdavLockRequest::SCOPE_SHARED;
        $this->properties['depth']     = ezcWebdavRequest::DEPTH_INFINITY;
        $this->properties['tokens']    = new ArrayObject();
    }
}


?>

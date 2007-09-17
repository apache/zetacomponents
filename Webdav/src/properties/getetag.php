<?php
/**
 * File containing the geteetag property class.
 *
 * @package Webdav
 * @version //autogenetag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <geteetag>.
 *
 * @property string $etag
 *           The ETag.
 *
 * @version //autogenetag//
 * @package Webdav
 */
class ezcWebdavGetEtagProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavGetEtagProperty.
     * 
     * @param string $etag The etag.
     * @return void
     */
    public function __construct( $etag = null )
    {
        parent::__construct( 'getetag' );

        $this->etag = $etag;
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
            case 'etag':
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

    /**
     * Check if property has no content.
     *
     * Should return true, if property has no assigned content.
     * 
     * @access public
     * @return bool
     */
    public function noContent()
    {
        return $this->properties['etag'] === null;
    }
}

?>

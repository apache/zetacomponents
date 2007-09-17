<?php
/**
 * File containing the getcontenttype property class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <getcontenttype>.
 *
 * @property string $mime
 *           The MIME type.
 * @property string $charset
 *           The character set, if provided, else null.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavGetContentTypeProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavGetContentTypeProperty.
     * 
     * @param string $mime The mime.
     * @return void
     */
    public function __construct( $mime = null, $charset = null )
    {
        parent::__construct( 'getcontenttype' );

        $this->mime = $mime;
        $this->charset = $charset;
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
            case 'mime':
                if ( is_string( $propertyValue ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;
            case 'charset':
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
    public function hasNoContent()
    {
        return $this->properties['mime'] === null;
    }
}

?>

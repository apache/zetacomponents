<?php
/**
 * File containing the getcontentlanguage property class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents the Webdav property <getcontentlanguage>.
 *
 * @property array(string) $languages
 *           The languages.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavGetContentLanguageProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavGetContentLanguageProperty.
     * 
     * @param string $languages The languages.
     * @return void
     */
    public function __construct( array $languages = array() )
    {
        parent::__construct( 'getcontentlanguage' );

        $this->languages = $languages;
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
            case 'languages':
                if ( is_array( $propertyValue ) === false )
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
        return !count( $this->properties['languages'] );
    }
}

?>

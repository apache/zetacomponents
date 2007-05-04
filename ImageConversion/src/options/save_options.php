<?php
/**
 * This file contains the ezcImageGdHandler class.
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @access public
 */

/**
 * Options class for ezcImageHandler->save() methods.
 * 
 * @package ImageConversion
 * @version //autogen//
 */
class ezcImageSaveOptions extends ezcBaseOptions
{
    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        "compression"   => null,
        "quality"       => null,
    );

    /**
     * Property set access.
     * 
     * @param string $propertyName 
     * @param string $propertyValue 
     * @ignore
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "compression":
                if ( !is_int( $propertyValue ) || $propertyValue < 0 || $propertyValue > 9 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "int > 0 and < 10" );
                }
                break;
            case "quality":
                if ( !is_int( $propertyValue ) || $propertyValue < 0 || $propertyValue > 100 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "int > 0 and <= 100" );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>

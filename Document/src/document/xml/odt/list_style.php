<?php
/**
 * File containing the ezcDocumentOdtStyle class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Base class for ODT styles.
 *
 * @property-read string $name The style name.
 * @property ArrayObject $listLevels ArrayObject(ezcDocumentOdtListLevelStyle)
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentOdtListStyle
{
    /**
     * Properties
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'name'       => null,
        'listLevels' => null,
    );

    /**
     * Creates a new style.
     *
     * Creates a style in the given style $family with the given $name. $family 
     * must be one of the FAMILY_* constants. $name can be an arbitrary string. 
     * Note that $name and $family properties can not be changed at a later 
     * time.
     * 
     * @param const $family 
     * @param string $name 
     */
    public function __construct( $name )
    {
        $this->properties['name']   = $name;
        $this->listLevels = new ArrayObject();
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'name':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
            case 'listLevels':
                if ( !is_object( $value ) || !( $value instanceof ArrayObject ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'ArrayObject' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
        $this->properties[$name] = $value;
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        if ( $this->__isset( $name ) )
        {
            return $this->properties[$name];
        }
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param string $name     
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return array_key_exists( $name, $this->properties );
    }
}

?>

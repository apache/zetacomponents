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
 * Class representing an ODT style.
 *
 * @property-read string $name The style name.
 * @property-read constant $family The style family.
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentOdtStyle
{
    const FAMILY_CHART = 'chart';
    const FAMILY_COLUMN = 'column';
    const FAMILY_CONTROL = 'control';
    const FAMILY_DEFAULT = 'default';
    const FAMILY_DRAWING-PAGE = 'drawing-page';
    const FAMILY_GRAPHIC = 'graphic';
    const FAMILY_PARAGRAPH = 'paragraph';
    const FAMILY_PRESENTATION = 'presentation';
    const FAMILY_RUBY = 'ruby';
    const FAMILY_SECTION = 'section';
    const FAMILY_TABLE-CELL = 'table-cell';
    const FAMILY_TABLE_COLUMN = 'table-column';
    const FAMILY_TABLE-PAGE = 'table-page';
    const FAMILY_TABLE-ROW = 'table-row';
    const FAMILY_TABLE = 'table';
    const FAMILY_TEXT = 'text';

    /**
     * Properties
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'name'            => null,
        'family'          => null,
        'parentStyleName' => null,
        'parentStyle'     => null,
        'nextStyleName'   => null,
        'nextStyle'       => null,
        'listStyleName'   => null,
        'listStyle'       => null,
    );

    public function __construct( $name, $family )
    {
        $this->properties['name']   = $name;
        $this->properties['family'] = $family;
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
            case 'family':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
            case 'parentStyleName':
            case 'nextStyleName':
            case 'listStyleName':
                if ( !is_string( $value ) && $value !== null )
                {
                    throw new ezcBaseValueException( $name, $value, 'string or null' );
                }
                break;
            case 'parentStyle':
            case 'nextStyle':
            case 'listStyle':
                // @TODO: Different kinds of styles?
                if ( !( $value instanceof ezcDocumentOdtStyle ) && $value !== null )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcDocumentOdtStyle or null' );
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

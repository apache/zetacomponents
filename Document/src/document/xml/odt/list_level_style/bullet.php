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
class ezcDocumentOdtListLevelStyleBullet extends ezcDocumentOdtListLevelStyle
{
    /**
     * Properties
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'bulletChar' => '',
        'numPrefix'  => '',
        'numSuffix'  => '',
    );

    /**
     * Creates a new list-level style.
     * 
     * @param int $level 
     */
    public function __construct( $level )
    {
        parent::__construct( $level );
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
            case 'bulletChar':
                if ( !is_string( $value ) && strlen( $value ) !== 1 )
                {
                    throw new ezcBaseValueException( $name, $value, 'string, length = 1' );
                }
                break;
            case 'numPrefix':
            case 'numSuffix':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'string' );
                }
                break;
            default:
                return parent::__set( $name, $value );
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
        if ( array_key_exists( $name, $this->properties ) )
        {
            return $this->properties[$name];
        }
        return parent::__get( $name );
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
        return array_key_exists( $name, $this->properties ) || parent::__isset( $name );
    }
}

?>

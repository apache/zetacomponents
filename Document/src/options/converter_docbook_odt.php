<?php
/**
 * File containing the ezcDocumentDocbookToOdtConverterOptions class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the basic options for the ezcDocumentToOdtConverter.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtConverterOptions extends ezcDocumentConverterOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->template = dirname( __FILE__ ) . '/data/template.fodt';
        $this->styler   = new ezcDocumentOdtPcssStyler();
        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'template':
                if ( !is_string( $value ) || !is_file( $value ) || !is_readable( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'file, readable' );
                }
                break;
            case 'styler':
                if ( !is_object( $value ) || !( $value instanceof ezcDocumentOdtStyler ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcDocumentOdtStyler' );
                }
                break;
            default:
                parent::__set( $name, $value );
                break;
        }
        $this->properties[$name] = $value;
    }
}

?>

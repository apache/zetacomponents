<?php
/**
 * File containing the options class for the
 * ezcDocumentDocbookToHtmlXsltConverterOptions class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the basic options for the ezcDocumentEzp3Xml class
 *
 * @property string $xslt
 *           Path to XSLT, which should be used for the conversion.
 * @property array $parameters
 *           List of aparameters for the XSLT transformation. Parameters are
 *           given as array, with the structure array( 'namespace' => array(
 *           'option' => 'value' ) ), where namespace may also be an empty
 *           string. For a reference of parameters of the default XSLT, see
 *           here: http://docbook.sourceforge.net/release/xsl/current/doc/html/
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToHtmlXsltConverterOptions extends ezcDocumentConverterOptions
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
        $this->xslt       = 'http://docbook.sourceforge.net/release/xsl/current/html/docbook.xsl';
        $this->parameters = array(
            '' => array(
                'make.valid.html' => '1',
            ),
        );

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
            case 'xslt':
                $this->properties[$name] = (string) $value;
                break;

            case 'parameters':
                if ( !is_array( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'array' );
                }

                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}

?>

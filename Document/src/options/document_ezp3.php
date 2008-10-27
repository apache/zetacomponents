<?php
/**
 * File containing the options class for the ezcDocumentEzp3Xml class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the basic options for the ezcDocumentEzp3Xml class
 *
 * @property bool $indentXml
 *           Indent XML on output
 * @property string $relaxNgSchema
 *           Relax NG schema which is used to validate the eZ Publish 3
 *           documents.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzp3XmlOptions extends ezcDocumentXmlOptions
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
        $this->indentXml     = false;
        $this->relaxNgSchema = dirname( __FILE__ ) . '/../document/xml/ezp3/schema/ezxml_schema.rng';

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
            case 'indentXml':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }

                $this->properties[$name] = (bool) $value;
                break;

            case 'relaxNgSchema':
                $this->properties[$name] = (string) $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}

?>

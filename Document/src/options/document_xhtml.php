<?php
/**
 * File containing the options class for the ezcDocumentXhtml class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the basic options for the ezcDocumentXhtml class
 *
 * @property bool $xmlHeader
 *           Add the typical XML header to document
 * @property string $doctype
 *           Doctype of the document, defaults to the doctype for XHtml 1.0
 *           Transistional
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentXhtmlOptions extends ezcDocumentXmlOptions
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
        $this->xmlHeader = false;
        $this->doctype   = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

        parent::__construct( $options );

        // Do not fail on error by default in (X)Html documents, as they
        // often contain errors.
        $this->failOnError = false;
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
            case 'xmlHeader':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }

                $this->properties[$name] = (bool) $value;
                break;

            case 'doctype':
                $this->properties[$name] = (string) $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}

?>

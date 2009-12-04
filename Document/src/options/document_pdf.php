<?php
/**
 * File containing the options class for the ezcDocumentPdfOptions class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the basic options for the ezcDocumentDocbook class.
 *
 * @property ezcDocumentPdfHyphenator $hyphenator
 *           Hyphenator to use for word hyphenation
 * @property ezcDocumentPdfTokenizer $tokenizer
 *           Tokenizer used to split strings into single words
 * @property ezcDocumentPdfDriver $driver
 *           Driver used to generate the actual PDF
 * @property ezcDocumentPdfTableColumnWidthCalculator $tableColumnWidthCalculator
 *           Class responsible to obtain sensible column width values from a 
 *           table specification by introspecting its contents.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentPdfOptions extends ezcDocumentOptions
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
        $this->hyphenator     = new ezcDocumentPdfDefaultHyphenator();
        $this->tokenizer      = new ezcDocumentPdfDefaultTokenizer();
        $this->tableColumnWidthCalculator = new ezcDocumentPdfDefaultTableColumnWidthCalculator();

        // @todo: There might be a better default:
        $this->driver     = new ezcDocumentPdfHaruDriver();

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
            case 'hyphenator':
                if ( !$value instanceof ezcDocumentPdfHyphenator )
                {
                    throw new ezcBaseValueException( $name, $value, 'instanceof ezcDocumentPdfHyphenator' );
                }

                $this->properties[$name] = $value;
                break;

            case 'tokenizer':
                if ( !$value instanceof ezcDocumentPdfTokenizer )
                {
                    throw new ezcBaseValueException( $name, $value, 'instanceof ezcDocumentPdfTokenizer' );
                }

                $this->properties[$name] = $value;
                break;

            case 'driver':
                if ( !$value instanceof ezcDocumentPdfDriver )
                {
                    throw new ezcBaseValueException( $name, $value, 'instanceof ezcDocumentPdfDriver' );
                }

                $this->properties[$name] = $value;
                break;

            case 'tableColumnWidthCalculator':
                if ( !$value instanceof ezcDocumentPdfTableColumnWidthCalculator )
                {
                    throw new ezcBaseValueException( $name, $value, 'instanceof ezcDocumentPdfTableColumnWidthCalculator' );
                }

                $this->properties[$name] = $value;
                break;

            default:
                parent::__set( $name, $value );
        }
    }
}

?>

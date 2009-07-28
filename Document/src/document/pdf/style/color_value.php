<?php
/**
 * File containing the ezcDocumentPdfStyleMeasureValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Style directive color value representation
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfStyleColorValue extends ezcDocumentPdfStyleValue
{
    /**
     * Construct value handler from string representation
     *
     * @param mixed $value
     * @return void
     */
    public function __construct( $value )
    {
        switch ( true )
        {
            // Match 12 and 16bit hex value color definitions
            case preg_match( '(^#?(?P<r>[0-9a-f])(?P<g>[0-9a-f])(?P<b>[0-9a-f])(?P<a>[0-9a-f])?$)Ui', $value, $match ):
                $this->value = array(
                    'red'   => hexdec( $match['r'] ) / 15,
                    'green' => hexdec( $match['g'] ) / 15,
                    'blue'  => hexdec( $match['b'] ) / 15,
                    'alpha' => isset( $match['a'] ) ? hexdec( $match['a'] ) / 15 : 0.,
                );
                break;

            // Match 24 and 32bit hex value color definitions
            case preg_match( '(^#?(?P<r>[0-9a-f]{2})(?P<g>[0-9a-f]{2})(?P<b>[0-9a-f]{2})(?P<a>[0-9a-f]{2})?$)Ui', $value, $match ):
                $this->value = array(
                    'red'   => hexdec( $match['r'] ) / 255,
                    'green' => hexdec( $match['g'] ) / 255,
                    'blue'  => hexdec( $match['b'] ) / 255,
                    'alpha' => isset( $match['a'] ) ? hexdec( $match['a'] ) / 255 : 0.,
                );
                break;

            // Match RGB array specification
            case preg_match( '(^\s*rgb\s*\(\s*(?P<r>[0-9]+)\s*,\s*(?P<g>[0-9]+)\s*,\s*(?P<b>[0-9]+)\s*\)\s*$)i', $value, $match ):
                $this->value = array(
                    'red'   => $match['r'] % 256 / 255,
                    'green' => $match['g'] % 256 / 255,
                    'blue'  => $match['b'] % 256 / 255,
                    'alpha' => 0,
                );
                break;

            // Match RGBA array specification
            case preg_match( '(^\s*rgba\s*\(\s*(?P<r>[0-9]+)\s*,\s*(?P<g>[0-9]+)\s*,\s*(?P<b>[0-9]+)\s*,\s*(?P<a>[0-9]+)\s*\)\s*$)i', $value, $match ):
                $this->value = array(
                    'red'   => $match['r'] % 256 / 255,
                    'green' => $match['g'] % 256 / 255,
                    'blue'  => $match['b'] % 256 / 255,
                    'alpha' => $match['a'] % 256 / 255,
                );
                break;

            default:
                throw new ezcDocumentParserException( E_PARSE, "Invalid color specification: " . $value );
        }
    }

    /**
     * Convert value to string
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf( '%.2Fmm', $this->value );
    }
}

?>

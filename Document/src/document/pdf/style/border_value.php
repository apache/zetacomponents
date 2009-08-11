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
 * Style directive border value representation
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfStyleBorderValue extends ezcDocumentPdfStyleValue
{
    /**
     * Parse value string representation
     *
     * Parse the string representation of the value into a usable
     * representation.
     * 
     * @param string $value 
     * @return ezcDocumentPdfStyleValue
     */
    public function parse( $value )
    {
        $widthParser = new ezcDocumentPdfStyleMeasureValue();
        $lineParser  = new ezcDocumentPdfStyleLineValue();
        $colorParser = new ezcDocumentPdfStyleColorValue();

        $regexp = '(^\s*' .
            '(?:(?P<width>' . $widthParser->getRegularExpression() . ')\s*)?' .
            '(?:(?P<line>'  . $lineParser->getRegularExpression()  . ')\s*)?' .
            '(?:(?P<color>' . $colorParser->getRegularExpression() . ')\s*)?' .
        '\s*$)';

        if ( !preg_match( $regexp, $value, $match ) )
        {
            throw new ezcDocumentParserException( E_PARSE, "Invalid border specification: " . $value );
        }
    
        // Line style default values
        $this->value = array(
            'width' => 0,
            'line'  => 'solid',
            'color' => array(
                'red'   => 1,
                'green' => 1,
                'blue'  => 1,
                'alpha' => 0,
            ),
        );

        if ( isset( $match['width'] ) && !empty( $match['width'] ) )
        {
            $this->value['width'] = $widthParser->parse( $match['width'] )->value;
        }

        if ( isset( $match['line'] ) && !empty( $match['line'] ) )
        {
            $this->value['line'] = $lineParser->parse( $match['line'] )->value;
        }

        if ( isset( $match['color'] ) && !empty( $match['color'] ) )
        {
            $this->value['color'] = $colorParser->parse( $match['color'] )->value;
        }

        return $this;
    }

    /**
     * Get regular expression matching the value
     *
     * Return a regular sub expression, which matches all possible values of
     * this value type. The regular expression should NOT contain any named
     * sub-patterns, since it might be repeatedly embedded in some box parser.
     * 
     * @return string
     */
    public function getRegularExpression()
    {
        $widthParser = new ezcDocumentPdfStyleMeasureValue();
        $lineParser  = new ezcDocumentPdfStyleLineValue();
        $colorParser = new ezcDocumentPdfStyleColorValue();

        return '(?:' .
            '(?:' . $widthParser->getRegularExpression() . '\s*)?' .
            '(?:'  . $lineParser->getRegularExpression()  . '\s*)?' .
            '(?:' . $colorParser->getRegularExpression() . ')?' .
        ')';
    }

    /**
     * Convert value to string
     *
     * @return string
     */
    public function __toString()
    {
        return 
            new ezcDocumentPdfStyleMeasureValue( $this->value['width'] ) . ' ' .
            new ezcDocumentPdfStyleLineValue( $this->value['line'] ) . ' ' .
            new ezcDocumentPdfStyleColorValue( $this->value['color'] );
    }
}

?>

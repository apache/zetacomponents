<?php
/**
 * File containing the ezcDocumentPdfStyleBoxValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Abstract value tpye for box value representations.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentPdfStyleBoxValue extends ezcDocumentPdfStyleValue
{
    /**
     * Construct value
     *
     * Optionally pass a parsed representation of the value.
     * 
     * @param mixed $value 
     * @return void
     */
    public function __construct( $value = array(
            'top'    => null,
            'right'  => null,
            'bottom' => null,
            'left'   => null,
        ) )
    {
        $this->value = $value;
    }

    /**
     * Parse value string representation
     *
     * Parse the string representation of the value into a usable
     * representation.
     * 
     * @param string $value 
     * @return void
     */
    public function parse( $value )
    {
        $subValueClass = $this->getSubValue();
        $subValue      = new $subValueClass();
        $subExpression = $subValue->getRegularExpression();

        $regexp = '(^\s*(?:' .
            "(?P<m0>(?P<m00>$subExpression))|" .
            "(?P<m1>(?P<m10>$subExpression)\s+(?P<m11>$subExpression))|" .
            "(?P<m2>(?P<m20>$subExpression)\s+(?P<m21>$subExpression)\s+(?P<m22>$subExpression))|" .
            "(?P<m3>(?P<m30>$subExpression)\s+(?P<m31>$subExpression)\s+(?P<m32>$subExpression)\s+(?P<m33>$subExpression))" .
        ')\s*$)S';

        if ( !preg_match( $regexp, $value, $match ) )
        {
            throw new ezcDocumentParserException( E_PARSE, "Invalid number of elements in measure box specification: $value" );
        }

        switch ( true )
        {
            case !empty( $match['m0'] ):
                $this->value = array(
                    'top'    => $subValue->parse( $match['m00'] )->value,
                    'right'  => $subValue->parse( $match['m00'] )->value,
                    'bottom' => $subValue->parse( $match['m00'] )->value,
                    'left'   => $subValue->parse( $match['m00'] )->value,
                );
                break;

            case !empty( $match['m1'] ):
                $this->value = array(
                    'top'    => $subValue->parse( $match['m10'] )->value,
                    'right'  => $subValue->parse( $match['m11'] )->value,
                    'bottom' => $subValue->parse( $match['m10'] )->value,
                    'left'   => $subValue->parse( $match['m11'] )->value,
                );
                break;

            case !empty( $match['m2'] ):
                $this->value = array(
                    'top'    => $subValue->parse( $match['m20'] )->value,
                    'right'  => $subValue->parse( $match['m21'] )->value,
                    'bottom' => $subValue->parse( $match['m22'] )->value,
                    'left'   => $subValue->parse( $match['m21'] )->value,
                );
                break;

            case !empty( $match['m3'] ):
                $this->value = array(
                    'top'    => $subValue->parse( $match['m30'] )->value,
                    'right'  => $subValue->parse( $match['m31'] )->value,
                    'bottom' => $subValue->parse( $match['m32'] )->value,
                    'left'   => $subValue->parse( $match['m33'] )->value,
                );
                break;
        }

        return $this;
    }

    /**
     * Get sub value handler class name
     * 
     * @return string
     */
    abstract protected function getSubValue();

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
        // Embedding a boxed measure would lead to totally npredictable
        // results, so we just return null.
        return null;
    }

    /**
     * Convert value to string
     *
     * @return string
     */
    public function __toString()
    {
        $subValueClass = $this->getSubValue();

        return 
            new $subValueClass( $this->value['top'] ) . ' ' .
            new $subValueClass( $this->value['right'] ) . ' ' .
            new $subValueClass( $this->value['bottom'] ) . ' ' .
            new $subValueClass( $this->value['left'] );
    }
}

?>

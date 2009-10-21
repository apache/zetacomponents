<?php
/**
 * File containing the ezcDocumentPcssMeasure class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Pdf measure wrapper, including measure conversions
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPcssMeasure
{
    /**
     * Internal value representation
     *
     * @var mixed
     */
    protected $value;

    /**
     * One millimeter in inch
     */
    const MM_IN_INCH = 0.0393700787;

    /**
     * Resolution in DPI for transformations between mm and pixels.
     *
     * @var int
     */
    protected $resolution = 72;

    /**
     * Construct measure from input value
     *
     * @param mixed $value
     * @return void
     */
    public function __construct( $value )
    {
        $this->value = $value;
    }

    /**
     * Static constructor wrapper
     *
     * Static constructor wrapper, because direct dereferencing does
     * not work with the new operator, and this makes the usage of
     * this simple wrpper class easier.
     *
     * @param mixed $value
     * @return ezcDocumentPcssMeasure
     */
    public static function create( $value )
    {
        return new ezcDocumentPcssMeasure( $value );
    }

    /**
     * Set resolution in dpi
     *
     * @param int $dpi
     * @return void
     */
    public function setResolution( $dpi )
    {
        $this->resolution = (int) $dpi;
    }

    /**
     * Get unit factor
     *
     * Get the factor for the given unit, so values can be transformed from the
     * passed unit into milli meters.
     *
     * @param string $unit
     * @param int $resolution
     * @return void
     */
    protected function getUnitFactor( $unit, $resolution )
    {
        switch ( $unit )
        {
            case 'mm':
                return 1;
            case 'in':
                return self::MM_IN_INCH;
            case 'px':
                // The pixel transformation depends on the current resolution
                return self::MM_IN_INCH * $resolution;
            case 'pt':
                // Points are defined as 72 points per inch
                return self::MM_IN_INCH * 72;
            default:
                throw new ezcDocumentParserException( E_PARSE, "Unknown unit '$unit'." );
        }
    }

    /**
     * Convert values
     *
     * Convert measure values from the PCSS input file into another unit. The
     * input unit is read from the passed value and defaults to milli meters.
     * The output unit can be specified as the second parameter and also
     * default to milli meters.
     *
     * Supported units currently are: mm, px, pt, in
     *
     * Optionally a resolution (dpi) can specified for the
     * conversion of pixel values.
     *
     * @param string $format
     * @param int $resolution
     * @return float
     */
    public function get( $format = 'mm', $resolution = null )
    {
        if ( !preg_match( '(^\s*(?P<value>[+-]?\s*(?:\d*\.)?\d+)(?P<unit>[A-Za-z]+)?\s*$)S', $this->value, $match ) )
        {
            throw new ezcDocumentParserException( E_PARSE, "Could not parse '{$this->value}' as size value." );
        }

        if ( $resolution === null )
        {
            $resolution = $this->resolution;
        }

        $value = (float) $match['value'];
        $input = isset( $match['unit'] ) ? strtolower( $match['unit'] ) : 'mm';

        $inputFactor  = $this->getUnitFactor( $input, $resolution );
        $outputFactor = $this->getUnitFactor( $format, $resolution );

        return $value / $inputFactor * $outputFactor;
    }
}

?>

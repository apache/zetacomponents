<?php
/**
 * File containing the ezcDocumentPdfStyleMeasureBoxValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Pdf CSS layout directive.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfStyleMeasureBoxValue extends ezcBaseStruct
{
    /**
     * Directive value
     *
     * @var array
     */
    public $value;

    /**
     * Construct value handler from string representation
     *
     * @param mixed $value
     * @return void
     */
    public function __construct( $value )
    {
        $values = preg_split( '(\s+)', $value );

        switch ( count( $values ) )
        {
            case 1:
                $this->value = array(
                    'top'    => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'right'  => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'bottom' => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'left'   => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                );
                break;

            case 2:
                $this->value = array(
                    'top'    => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'right'  => ezcDocumentPdfMeasure::create( $values[1] )->get(),
                    'bottom' => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'left'   => ezcDocumentPdfMeasure::create( $values[1] )->get(),
                );
                break;

            case 3:
                $this->value = array(
                    'top'    => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'right'  => ezcDocumentPdfMeasure::create( $values[1] )->get(),
                    'bottom' => ezcDocumentPdfMeasure::create( $values[2] )->get(),
                    'left'   => ezcDocumentPdfMeasure::create( $values[1] )->get(),
                );
                break;

            case 4:
                $this->value = array(
                    'top'    => ezcDocumentPdfMeasure::create( $values[0] )->get(),
                    'right'  => ezcDocumentPdfMeasure::create( $values[1] )->get(),
                    'bottom' => ezcDocumentPdfMeasure::create( $values[2] )->get(),
                    'left'   => ezcDocumentPdfMeasure::create( $values[3] )->get(),
                );
                break;

            default:
                throw new ezcDocumentParserException( E_PARSE, "Invalid number of elements in measure box specification: " . count( $values ) );
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

<?php
/**
 * File containing the ezcDocumentPdfRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Abstract renderer base class
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentPdfRenderer
{
    /**
     * Used driver implementation
     *
     * @var ezcDocumentPdfDriver
     */
    protected $driver;

    /**
     * Used PDF style inferencer for evaluating current styling
     *
     * @var ezcDocumentPcssStyleInferencer
     */
    protected $styles;

    /**
     * Construct renderer from driver to use
     *
     * @param ezcDocumentPdfDriver $driver
     * @param ezcDocumentPcssStyleInferencer $styles
     * @return void
     */
    public function __construct( ezcDocumentPdfDriver $driver, ezcDocumentPcssStyleInferencer $styles )
    {
        $this->driver = $driver;
        $this->styles = $styles;
    }

    /**
     * Evaluate available bounding box
     *
     * Returns false, if not enough space is available on current
     * page, and a bounding box otherwise.
     *
     * @param ezcDocumentPdfPage $page
     * @param array $styles
     * @param float $width
     * @return mixed
     */
    protected function evaluateAvailableBoundingBox( ezcDocumentPdfPage $page, array $styles, $width )
    {
        // Grap the maximum available vertical space
        $space = $page->testFitRectangle( $page->x, $page->y, $width, null );
        if ( $space === false )
        {
            // Could not allocate space, required for even one line
            return false;
        }

        // Apply bounding box modifications
        $space->x      +=
            $styles['padding']->value['left'] +
            $styles['border']->value['left']['width'] +
            $styles['margin']->value['left'];
        $space->width  -=
            $styles['padding']->value['left'] +
            $styles['padding']->value['right'] +
            $styles['border']->value['left']['width'] +
            $styles['border']->value['right']['width'] +
            $styles['margin']->value['left'] +
            $styles['margin']->value['right'];
        $space->y      +=
            $styles['padding']->value['top'] +
            $styles['border']->value['top']['width'] +
            $styles['margin']->value['top'];
        $space->height -=
            $styles['padding']->value['top'] +
            $styles['padding']->value['bottom'] +
            $styles['border']->value['top']['width'] +
            $styles['border']->value['bottom']['width'] +
            $styles['margin']->value['top'] +
            $styles['margin']->value['bottom'];

        return $space;
    }
}
?>

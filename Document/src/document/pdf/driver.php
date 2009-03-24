<?php
/**
 * File containing the ezcDocumentPdfDriver class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Abstract base class for verimplementations.
 *
 * Driver implement the actual creation of PDF documents. They offer a simple
 * unified API for PDF creation and proxy them to the actual PDF
 * implementation, which will create the binary data.
 *
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocumentPdfDriver
{
    /**
     * Set text formatting option
     *
     * Set a text formatting option. The names of the options are the same used
     * in the PCSS files and need to be translated by the driver to the proper
     * backend calls.
     *
       @TODO: How to handle resetting the text formatting? Does the renderer
       already knows everything relevant, or do we need to provide a method in
       the driver for explicit reset?
     *
     * @param string $type 
     * @param mixed $value 
     * @return void
     */
    abstract public function setTextFormatting( $type, $value );

    /**
     * Calculate the rendered width of the current word
     *
     * Calculate the width of the passed word, using the currently set text
     * formatting options.
     * 
     * @param string $word 
     * @return float
     */
    abstract public function calculateWordWidth( $word );

    /**
     * Draw word at given position
     *
     * Draw the given word at the given position using the currently set text
     * formatting options.
     * 
     * @param float $x 
     * @param float $y 
     * @param string $word 
     * @return void
     */
    abstract public function drawWord( $x, $y, $word );
}


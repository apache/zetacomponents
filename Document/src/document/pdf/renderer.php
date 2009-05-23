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
     * @var ezcDocumentPdfStyleInferencer
     */
    protected $styles;

    /**
     * Construct renderer from driver to use
     * 
     * @param ezcDocumentPdfDriver $driver 
     * @param ezcDocumentPdfStyleInferencer $styles 
     * @return void
     */
    public function __construct( ezcDocumentPdfDriver $driver, ezcDocumentPdfStyleInferencer $styles )
    {
        $this->driver = $driver;
        $this->styles = $styles;
    }
}
?>

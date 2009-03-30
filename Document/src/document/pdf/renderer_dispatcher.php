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
 * Main renderer class.
 *
 * The main renderer class manages page coverage, driver and style inference
 * information. It dispatches the actual rendering to its sub renderers.
 *
 * @TODO: What are the actual criterias for dispatching? Hardcoded?
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfRendererDispatcher
{
    /**
     * Used driver implementation
     * 
     * @var ezcDocumentPdfDriver
     */
    protected $driver;

    /**
     * Options, configuring how the PDF should be rendered
     * 
     * @var ezcDocumentPdfOptions
     */
    protected $options;

    /**
     * PDF document pages.
     *
     * An array of ezcDocumentPdfPage objects maintaining coverage information
     * for all pages in the document.
     * 
     * @var array
     */
    protected $pages = array();

    /**
     * Construct renderer dispatcher
     * 
     * @param ezcDocumentPdfOptions $options 
     * @param ezcDocumentPdfDriver $driver 
     * @return void
     */
    public function __construct( ezcDocumentPdfOptions $options, ezcDocumentPdfDriver $driver )
    {
        $this->driver  = $driver;
        $this->options = $options;
    }
}
?>

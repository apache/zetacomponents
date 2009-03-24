<?php
/**
 * File containing the ezcDocumentPdf class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Document handler for PDF documents.
 * 
 * @package Document
 * @version //autogen//
 * @mainclass
 */
class ezcDocumentPdf extends ezcDocument
{
    /**
     * Container for style directives.
     * 
     * @var ezcDocumentPdfStyleInferencer
     */
    protected $styles;

    /**
     * Construct RST document.
     * 
     * @ignore
     * @param ezcDocumentPdfOptions $options
     * @return void
     */
    public function __construct( ezcDocumentPdfOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentPdfOptions() :
            $options );

        $this->styles   = new ezcDocumentPdfStyleInferencer();
    }

    /**
     * Create document from input string
     * 
     * Create a document of the current type handler class and parse it into a
     * usable internal structure.
     *
     * @param string $string 
     * @return void
     */
    public function loadString( $string )
    {
        $this->contents = $string;
    }

    /**
     * Load style definition file
     *
     * Parse and load a PCSS file and use the resulting style definitions for
     * rendering.
     * 
     * @param string $file 
     * @return void
     */
    public function loadStyles( $file )
    {
        return;
    }

    /**
     * Return document compiled to the docbook format
     * 
     * The internal document structure is compiled to the docbook format and
     * the resulting docbook document is returned.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     *
     * @return ezcDocumentDocbook
     */
    public function getAsDocbook()
    {
        throw new RuntimeException( 'Reading PDF documents is not implemented.' );
    }

    /**
     * Create document from docbook document
     *
     * A document of the docbook format is provided and the internal document
     * structure should be created out of this.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     * 
     * @param ezcDocumentDocbook $document 
     * @return void
     */
    public function createFromDocbook( ezcDocumentDocbook $document )
    {
        // @TODO: Should the used renderer be configurable? ... One can still
        // just inherit from this class to change it.
        $renderer = new ezcDocumentPdfRendererDispatcher(
            $this->options,
            $this->styles
        );

        $this->content = $renderer->render();
    }

    /**
     * Return document as string
     * 
     * Serialize the document to a string an return it.
     *
     * @return string
     */
    public function save()
    {
        return $this->contents;
    }
}

?>

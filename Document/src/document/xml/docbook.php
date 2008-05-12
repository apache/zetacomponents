<?php
/**
 * File containing the ezcDocumentDocbook class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The document handler for the docbook document markup.
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcDocumentDocbook extends ezcDocumentXmlBase
{
    /**
     * Docbook document stored as a DOMDocument.
     * 
     * @var DOMDocument
     */
    protected $document;

    /**
     * Construct document xml base.
     * 
     * @ignore
     * @param ezcDocumentDocbookOptions $options
     * @return void
     */
    public function __construct( ezcDocumentDocbookOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentDocbookOptions() :
            $options );
    }

    /**
     * Set DOMDocument
     *
     * Directly set the internally stored DOMDocument object, to spare
     * additional XML parsing overhead. Setting a broken or invalid docbook
     * document is not checked here, ebcause validation would cost too much
     * performace on each set. Be careful what you set here, invalid documents
     * may lead to unpredictable errors.
     *
     * @param DOMDocument $document
     * @return void
     */
    public function setDomDocument( DOMDocument $document )
    {
        $this->document = $document;
    }

    /**
     * Get DOMDocument
     *
     * Directly return the internally stored DOMDocument object, to spare
     * additional XML parsing overhead.
     * 
     * @return DOMDocument
     */
    public function getDomDocument()
    {
        return $this->document;
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
        $this->document = new DOMDocument();
        $this->document->loadXml( $string );
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
        return $this;
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
        $this->document = $document->getDomDocument();
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
        return $this->document->saveXml();
    }
}

?>

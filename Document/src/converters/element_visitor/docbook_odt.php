<?php
/**
 * File containing the ezcDocumentDocbookToOdtConverter class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Converter for docbook to ODT with a PHP callback based mechanism, for fast
 * and easy PHP based extensible transformations.
 *
 * This converter does not support the full docbook standard, but only a subset
 * commonly used in the document component.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtConverter extends ezcDocumentElementVisitorConverter
{
    /**
     * Text node processor.
     * 
     * @var ezcDocumentOdtTextProcessor
     */
    protected $textProcessor;

    /**
     * Construct converter
     *
     * Construct converter from XSLT file, which is used for the actual
     *
     * @param ezcDocumentDocbookToOdtConverterOptions $options
     * @return void
     */
    public function __construct( ezcDocumentDocbookToOdtConverterOptions $options = null )
    {
        parent::__construct(
            $options === null ?
                new ezcDocumentDocbookToOdtConverterOptions() :
                $options
        );

        $this->textProcessor = new ezcDocumentOdtTextProcessor();

        $styler = $this->options->styler;

        // Initlize common element handlers
        $this->visitorElementHandler = array(
            'docbook' => array(
                'article'           => $ignore = new ezcDocumentDocbookToOdtIgnoreHandler( $styler ),
                'book'              => $ignore,
                // 'sect1info'         => $header = new ezcDocumentDocbookToOdtHeadHandler(),
                // 'sect2info'         => $header,
                // 'sect3info'         => $header,
                // 'sect4info'         => $header,
                // 'sect5info'         => $header,
                // 'sectioninfo'       => $header,
                // 'sect1'             => ,
                // 'sect2'             => $section,
                // 'sect3'             => $section,
                // 'sect4'             => $section,
                // 'sect5'             => $section,
                'section'           => $section = new ezcDocumentDocbookToOdtSectionHandler( $styler ),
                'title'             => $section,
                'para'              => new ezcDocumentDocbookToOdtParagraphHandler( $styler ),
                'emphasis'          => $inline = new ezcDocumentDocbookToOdtInlineHandler( $styler ),
                // 'literal'           => $mapper,
                'ulink'             => new ezcDocumentDocbookToOdtUlinkHandler( $styler ),
                // 'link'              => new ezcDocumentDocbookToOdtInternalLinkHandler(),
                // 'anchor'            => new ezcDocumentDocbookToOdtAnchorHandler(),
                'inlinemediaobject' => $media = new ezcDocumentDocbookToOdtMediaObjectHandler( $styler ),
                'mediaobject'       => $media,
                // 'blockquote'        => new ezcDocumentDocbookToOdtBlockquoteHandler(),
                'itemizedlist'      => $list = new ezcDocumentDocbookToOdtListHandler( $styler ),
                'orderedlist'       => $list,
                'listitem'          => $mapper = new ezcDocumentDocbookToOdtMappingHandler( $styler ),
                // 'note'              => $special = new ezcDocumentDocbookToOdtSpecialParagraphHandler(),
                // 'tip'               => $special,
                // 'warning'           => $special,
                // 'important'         => $special,
                // 'caution'           => $special,
                'literallayout'     => new ezcDocumentDocbookToOdtLiteralLayoutHandler( $styler ),
                'footnote'          => new ezcDocumentDocbookToOdtFootnoteHandler( $styler ),
                // 'comment'           => new ezcDocumentDocbookToOdtCommentHandler(),
                // 'beginpage'         => $mapper,
                // 'variablelist'      => $mapper,
                // 'varlistentry'      => new ezcDocumentDocbookToOdtDefinitionListEntryHandler(),
                'entry'             => $table = new ezcDocumentDocbookToOdtTableHandler( $styler ),
                'table'             => $table,
                'tbody'             => $table,
                'thead'             => $table,
                'caption'           => $table,
                'tr'                => $table,
                'td'                => $table,
                'row'               => $table,
                'tgroup'            => $ignore,
            )
        );
    }

    /**
     * Convert documents between two formats
     *
     * Convert documents of the given type to the requested type.
     *
     * @param ezcDocumentDocbook $source
     * @return ezcDocumentOdt
     */
    public function convert( $source )
    {
        $destination = $this->initializeDocument();

        $docBookDom = $this->makeLocateable( $source->getDomDocument() );

        $this->options->styler->init( $destination->ownerDocument );

        $destination = $this->visitChildren(
            $docBookDom,
            $destination
        );

        return $this->createDocument( $destination );
    }

    /**
     * Reloads the DOMDocument of the given DocBook to make its elements 
     * locateable.
     * 
     * @param DOMDocument $docBook 
     * @return DOMDocument
     */
    protected function makeLocateable( DOMDocument $docBook )
    {
        // Reload the XML document to a DOMDocument with a custom element
        // class. Just registering it on the existing document seems not to
        // work in all cases.
        $reloaded = new DOMDocument();
        $reloaded->registerNodeClass( 'DOMElement', 'ezcDocumentLocateableDomElement' );
        $reloaded->loadXml( $docBook->saveXml() );

        return $reloaded;
    }

    /**
     * Initialize destination document
     *
     * Initialize the structure which the destination document could be build
     * with. This may be an initial DOMDocument with some default elements, or
     * a string, or something else.
     *
     * @return mixed
     */
    protected function initializeDocument()
    {
        $odt = new DOMDocument();
        $odt->preserveWhiteSpace = false;
        $odt->formatOutput = true;
        $odt->load( $this->options->template );

        $rootElements = $odt->getElementsByTagNameNS(
            ezcDocumentOdt::NS_ODT_OFFICE,
            'text'
        );

        if ( $rootElements->length !== 1 )
        {
            // @TODO: Throw proper exception
            throw new RuntimeException( "Broken ODT template '{$this->options->template}'. Missing body element." );
        }
        $root = $rootElements->item( 0 );

        return $root;
    }

    /**
     * Create document from structure
     *
     * Build a ezcDocumentDocument object from the structure created during the
     * visiting process.
     *
     * @param mixed $content
     * @return ezcDocumentDocument
     */
    protected function createDocument( $content )
    {
        $document = $content->ownerDocument;

        // @TODO: Anything to do here?

        $odt = new ezcDocumentOdt();
        $odt->setDomDocument( $document );
        return $odt;
    }

    /**
     * Visit text node.
     *
     * Visit a text node in the source document and transform it to the
     * destination result
     *
     * @TODO: Needs to be revised for literallayout handling.
     * @param DOMText $node
     * @param mixed $root
     * @return mixed
     */
    protected function visitText( DOMText $node, $root )
    {
        $resNodes = $this->textProcessor->processText( $node, $root );

        foreach ( $resNodes as $resNode )
        {
            $root->appendChild( $resNode );
        }

        return $root;
    }
}

?>

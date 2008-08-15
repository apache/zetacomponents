<?php
/**
 * File containing the ezcDocumentRst class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Document handler for RST text documents.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRst extends ezcDocument implements ezcDocumentXhtmlConversion
{
    /**
     * Registered directives
     *
     * Directives are special RST element, which are documented at:
     * http://docutils.sourceforge.net/docs/ref/rst/restructuredtext.html#directives
     *
     * Directives are the best entry point for custom rules, and you may
     * register custom directive classes using the class method
     * registerDirective().
     * 
     * @var array
     */
    protected $directives = array(
        'include'   => 'ezcDocumentRstIncludeDirective',
        'contents'  => 'ezcDocumentRstContentsDirective',
        'image'     => 'ezcDocumentRstImageDirective',
        'figure'    => 'ezcDocumentRstFigureDirective',
        'attention' => 'ezcDocumentRstAttentionDirective',
        'warning'   => 'ezcDocumentRstWarningDirective',
        'danger'    => 'ezcDocumentRstDangerDirective',
        'notice'    => 'ezcDocumentRstNoticeDirective',
        'note'      => 'ezcDocumentRstNoteDirective',
    );

    /**
     * Asbtract syntax tree.
     *
     * The internal representation of RST documents.
     * 
     * @var ezcDocumentRstDocumentNode
     */
    protected $ast;

    /**
     * Construct RST document.
     * 
     * @ignore
     * @param ezcDocumentRstOptions $options
     * @return void
     */
    public function __construct( ezcDocumentRstOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentRstOptions() :
            $options );
    }

    /**
     * Register directive handler
     *
     * Register a custom directive handler for special directives or overwrite
     * existing directive handlers. The directives are specified by its
     * (lowercase) name and the class name, which should handle the directive
     * and extend from ezcDocumentRstDirective.
     * 
     * @param string $name 
     * @param string $class 
     * @return void
     */
    public function registerDirective( $name, $class )
    {
        $this->directives[strtolower( $name )] = (string) $class;
    }

    /**
     * Get directive handler
     *
     * Get directive handler class name for the specified name.
     * 
     * @param string $name 
     * @return string
     */
    public function getDirectiveHandler( $name )
    {
        $name = strtolower( $name );
        if ( !isset( $this->directives[$name] ) )
        {
            throw new Exception( $name );
        }

        return $this->directives[$name];
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
        $tokenizer = new ezcDocumentRstTokenizer();
        $parser    = new ezcDocumentRstParser();
        $parser->options->errorReporting = $this->options->errorReporting;

        $this->ast = $parser->parse( $tokenizer->tokenizeString( $string ) );
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
        $document = new ezcDocumentDocbook();

        $visitor = new ezcDocumentRstDocbookVisitor( $this, $this->path );
        $document->setDomDocument(
            $visitor->visit( $this->ast, $this->path )
        );

        return $document;
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
        // @TODO: Implement
    }

    /**
     * Return document compiled to the HTML format
     * 
     * The internal document structure is compiled to the HTML format and the
     * resulting HTML document is returned.
     *
     * This is an optional interface for document markup languages which
     * support a direct transformation to HTML as a shortcut.
     *
     * @return ezcDocumentXhtml
     */
    public function getAsXhtml()
    {
        $document = new ezcDocumentXhtml();

        $visitorClass = $this->options->xhtmlVisitor;
        $visitor = new $visitorClass( $this, $this->path );
        $visitor->options = $this->options->xhtmlVisitorOptions;

        $document->setDomDocument(
            $visitor->visit( $this->ast, $this->path )
        );

        return $document;
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
        // @TODO: Implement
    }
}

?>

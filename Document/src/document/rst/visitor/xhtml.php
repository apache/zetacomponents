<?php
/**
 * File containing the ezcDocumentRstXhtmlVisitor class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * HTML visitor for the RST AST.
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcDocumentRstXhtmlVisitor extends ezcDocumentRstVisitor
{
    /**
     * Mapping of class names to internal visitors for the respective nodes.
     * 
     * @var array
     */
    protected $complexVisitMapping = array(
        'ezcDocumentRstSectionNode'               => 'visitSection',
        'ezcDocumentRstTextLineNode'              => 'visitText',
        'ezcDocumentRstMarkupInterpretedTextNode' => 'visitChildren',
        'ezcDocumentRstExternalReferenceNode'     => 'visitExternalReference',
        'ezcDocumentRstMarkupSubstitutionNode'    => 'visitSubstitutionReference',
        'ezcDocumentRstTargetNode'                => 'visitInlineTarget',
        'ezcDocumentRstAnonymousLinkNode'         => 'visitAnonymousReference',
        'ezcDocumentRstBlockquoteNode'            => 'visitBlockquote',
        'ezcDocumentRstBulletListListNode'        => 'visitBulletList',
        'ezcDocumentRstEnumeratedListListNode'    => 'visitEnumeratedList',
        /*
        'ezcDocumentRstLiteralNode'               => 'visitText',
        'ezcDocumentRstReferenceNode'             => 'visitInternalReference',
        'ezcDocumentRstDefinitionListNode'        => 'visitDefinitionListItem',
        'ezcDocumentRstTableNode'                 => 'visitTable',
        'ezcDocumentRstTableCellNode'             => 'visitTableCell',
        'ezcDocumentRstFieldListNode'             => 'visitFieldListItem',
        'ezcDocumentRstLineBlockNode'             => 'visitLineBlock',
        'ezcDocumentRstLineBlockLineNode'         => 'visitChildren',
        */
        'ezcDocumentRstDirectiveNode'             => 'visitDirective',
    );

    /**
     * Direct mapping of AST node class names to docbook element names.
     * 
     * @var array
     */
    protected $simpleVisitMapping = array(
        'ezcDocumentRstParagraphNode'            => 'p',
        'ezcDocumentRstMarkupEmphasisNode'       => 'em',
        'ezcDocumentRstMarkupStrongEmphasisNode' => 'strong',
        'ezcDocumentRstMarkupInlineLiteralNode'  => 'code',
        'ezcDocumentRstBulletListNode'           => 'li',
        'ezcDocumentRstEnumeratedListNode'       => 'li',
        /*
        'ezcDocumentRstMarkupInlineLiteralNode' => 'literal',
        'ezcDocumentRstDefinitionListListNode'  => 'variablelist',
        'ezcDocumentRstLiteralBlockNode'        => 'literallayout',
        'ezcDocumentRstCommentNode'             => 'comment',
        'ezcDocumentRstTransitionNode'          => 'beginpage',
        'ezcDocumentRstTableHeadNode'           => 'thead',
        'ezcDocumentRstTableBodyNode'           => 'tbody',
        'ezcDocumentRstTableRowNode'            => 'row',
        */
    );

    /**
     * Array with nodes, which can be ignored during the transformation
     * process, they only provide additional information during preprocessing.
     * 
     * @var array
     */
    protected $skipNodes = array(
        'ezcDocumentRstNamedReferenceNode',
        'ezcDocumentRstAnonymousReferenceNode',
        'ezcDocumentRstSubstitutionNode',
        /*
        'ezcDocumentRstFootnoteNode',
        */
    );

    /**
     * DOM document
     * 
     * @var DOMDocument
     */
    protected $document;

    /**
     * Reference to head node
     * 
     * @var DOMElement
     */
    protected $head;

    /**
     * Current depth in document.
     * 
     * @var int
     */
    protected $depth = 0;

    /**
     * Docarate RST AST
     *
     * Visit the RST abstract syntax tree.
     * 
     * @param ezcDocumentRstDocumentNode $ast 
     * @return mixed
     */
    public function visit( ezcDocumentRstDocumentNode $ast )
    {
        parent::visit( $ast );

        // Create article from AST
        $this->document = new DOMDocument();
        $this->document->formatOutput = true;

        $root = $this->document->createElementNs( 'http://www.w3.org/1999/xhtml', 'html' );
        $this->document->appendChild( $root );

        $this->head = $this->document->createElement( 'head' );
        $root->appendChild( $this->head );

        $generator = $this->document->createElement( 'meta' );
        $generator->setAttribute( 'name', 'generator' );
        $generator->setAttribute( 'content', 'eZ Components; http://ezcomponents.org' );
        $this->head->appendChild( $generator );

        $body = $this->document->createElement( 'body' );
        $root->appendChild( $body );

        // Visit all childs of the AST root node.
        foreach ( $ast->nodes as $node )
        {
            $this->visitNode( $body, $node );
        }

        // Check that all required elements for a valid XHTML document exist
        if ( $this->head->getElementsByTagName( 'title' )->length < 1 )
        {
            $title = $this->document->createElement( 'title', 'Empty document' );
            $this->head->appendChild( $title );
        }

        return $this->document;
    }

    /**
     * Visit single AST node
     *
     * Visit a single AST node, may be called for each node found anywhere
     * as child. The current position in the DOMDocument is passed by a
     * reference to the current DOMNode, which is operated on.
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitNode( DOMNode $root, ezcDocumentRstNode $node )
    {
        // Iterate over available visitors and use them to visit the nodes.
        foreach ( $this->complexVisitMapping as $class => $method )
        {
            if ( $node instanceof $class )
            {
                return $this->$method( $root, $node );
            }
        }

        // Check if we have a simple class to element name mapping
        foreach ( $this->simpleVisitMapping as $class => $elementName )
        {
            if ( $node instanceof $class )
            {
                $element = $this->document->createElement( $elementName );
                $root->appendChild( $element );

                if ( $node->identifier !== null )
                {
//                    $element->setAttribute( 'id', $node->identifier );
                }

                foreach ( $node->nodes as $child )
                {
                    $this->visitNode( $element, $child );
                }

                return;
            }
        }

        // Check if you should just ignore the node for rendering
        foreach ( $this->skipNodes as $class )
        {
            if ( $node instanceof $class )
            {
                return;
            }
        }

        // We could not find any valid visitor.
        throw new ezcDocumentMissingVisitorException( get_class( $node ) );
    }

    /**
     * Visit section node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitSection( DOMNode $root, ezcDocumentRstNode $node )
    {
        $titleString = trim( $node->title );

        if ( $this->depth <= 0 )
        {
            // Set document title from section
            $title = $this->document->createElement( 'title', htmlspecialchars( $titleString ) );
            $this->head->appendChild( $title );
        }

        $header = $this->document->createElement( 'h' . min( 6, ++$this->depth ) );
        $root->appendChild( $header );

        if ( $this->depth >= 6 )
        {
            $header->setAttribute( 'class', 'h' . $this->depth );
        }

        $reference = $this->document->createElement( 'a', htmlspecialchars( $titleString ) );
        $reference->setAttribute( 'name', $this->calculateId( $titleString ) );
        $header->appendChild( $reference );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $root, $child );
        }

        --$this->depth;
    }

    /**
     * Visit external reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitExternalReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->getNamedExternalReference( $this->nodeToString( $node ) );

        $link = $this->document->createElement( 'a' );
        $link->setAttribute( 'href', htmlspecialchars( $target ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $link, $child );
        }
    }

    /**
     * Visit inline target node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitInlineTarget( DOMNode $root, ezcDocumentRstNode $node )
    {
        $link = $this->document->createElement( 'a' );
        $link->setAttribute( 'name', $this->calculateId( $this->nodeToString( $node ) ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $link, $child );
        }
    }

    /**
     * Visit anonomyous reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitAnonymousReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->getAnonymousReferenceTarget();

        $link = $this->document->createElement( 'a' );
        $link->setAttribute( 'href', htmlspecialchars( $target ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $link, $child );
        }
    }

    /**
     * Visit blockquotes
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitBlockquote( DOMNode $root, ezcDocumentRstNode $node )
    {
        $quote = $this->document->createElement( 'blockquote' );
        $root->appendChild( $quote );

        // Decoratre blockquote contents
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $quote, $child );
        }

        // Add blockquote annotation
        if ( !empty( $node->annotation ) )
        {
            $annotation = $this->document->createElement( 'div' );
            $annotation->setAttribute( 'class', 'annotation' );
            $quote->appendChild( $annotation );

            $cite = $this->document->createElement( 'cite' );
            $annotation->appendChild( $cite );

            $this->visitChildren( $cite, $node->annotation->nodes );
        }
    }

    /**
     * Visit bullet lists
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitBulletList( DOMNode $root, ezcDocumentRstNode $node )
    {
        $list = $this->document->createElement( 'ul' );
        $root->appendChild( $list );

        $listTypes = array(
            '*'            => 'circle',
            '+'            => 'disc',
            '-'            => 'square',
            "\xe2\x80\xa2" => 'disc',
            "\xe2\x80\xa3" => 'circle',
            "\xe2\x81\x83" => 'square',
        );
        // Not allowed in XHtml strict
        // $list->setAttribute( 'type', $listTypes[$node->token->content] );

        // Decoratre blockquote contents
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $list, $child );
        }
    }

    /**
     * Visit enumerated lists
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitEnumeratedList( DOMNode $root, ezcDocumentRstNode $node )
    {
        $list = $this->document->createElement( 'ol' );

        // Detect enumeration type
        /* Not allowed in XHtml strict
        switch ( true )
        {
            case preg_match( '(^m{0,4}d?c{0,3}l?x{0,3}v{0,3}i{0,3}v?x?l?c?d?m?$)', $node->token->content ):
                $list->setAttribute( 'type', 'i' );
                break;

            case preg_match( '(^M{0,4}D?C{0,3}L?X{0,3}V{0,3}I{0,3}V?X?L?C?D?M?$)', $node->token->content ):
                $list->setAttribute( 'type', 'I' );
                break;

            case preg_match( '(^[a-z]$)', $node->token->content ):
                $list->setAttribute( 'type', 'a' );
                break;

            case preg_match( '(^[A-Z]$)', $node->token->content ):
                $list->setAttribute( 'type', 'A' );
                break;
        }
        // */

        $root->appendChild( $list );

        // Visit list contents
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $list, $child );
        }
    }

    /**
     * Visit directive
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitDirective( DOMNode $root, ezcDocumentRstNode $node )
    {
        $handlerClass = $this->rst->getDirectiveHandler( $node->identifier );
        $directiveHandler = new $handlerClass( $this->ast, $this->path, $node );

        if ( !$directiveHandler instanceof ezcDocumentRstXhtmlDirective )
        {
            return $this->triggerError(
                E_WARNING, "Directive '$handlerClass' does not support HTML rendering.",
                null, $node->token->line, $node->token->position
            );
        }
        $directiveHandler->toXhtml( $this->document, $root );
    }
}

?>

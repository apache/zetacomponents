<?php
/**
 * File containing the ezcDocumentWikiDocbookVisitor class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Docbook visitor for the Wiki AST.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiDocbookVisitor extends ezcDocumentWikiVisitor
{
    /**
     * Mapping of class names to internal visitors for the respective nodes.
     * 
     * @var array
     */
    protected $complexVisitMapping = array(
        'ezcDocumentWikiTextNode'           => 'visitText',
        'ezcDocumentWikiBoldNode'           => 'visitEmphasisMarkup',
        'ezcDocumentWikiItalicNode'         => 'visitEmphasisMarkup',
        'ezcDocumentWikiUnderlineNode'      => 'visitEmphasisMarkup',
        'ezcDocumentWikiTitleNode'          => 'visitTitle',
        'ezcDocumentWikiLinkNode'           => 'visitLink',
        'ezcDocumentWikiExternalLinkNode'   => 'visitExternalLink',
        'ezcDocumentWikiInternalLinkNode'   => 'visitExternalLink',
        'ezcDocumentWikiBulletListNode'     => 'visitList',
        'ezcDocumentWikiEnumeratedListNode' => 'visitList',
        'ezcDocumentWikiImageNode'          => 'visitImages',
        'ezcDocumentWikiLiteralBlockNode'   => 'visitLiteralBlock',
        'ezcDocumentWikiInlineLiteralNode'  => 'visitLiteral',

        // Node markup is ignored, because there is no equivalent in docbook
        'ezcDocumentWikiDeletedNode'   => 'visitChildren',
    );

    /**
     * Direct mapping of AST node class names to docbook element names.
     * 
     * @var array
     */
    protected $simpleVisitMapping = array(
        'ezcDocumentWikiParagraphNode'          => 'para',
        'ezcDocumentWikiSectionNode'            => 'section',
        'ezcDocumentWikiInlineQuoteNode'        => 'quote',
        'ezcDocumentWikiSuperscriptNode'        => 'superscript',
        'ezcDocumentWikiSubscriptNode'          => 'subscript',
        'ezcDocumentWikiMonospaceNode'          => 'literal',
        'ezcDocumentWikiBlockquoteNode'         => 'blockquote',
        'ezcDocumentWikiBulletListItemNode'     => 'listitem',
        'ezcDocumentWikiEnumeratedListItemNode' => 'listitem',
    );

    /**
     * Array with nodes, which can be ignored during the transformation
     * process, they only provide additional information during preprocessing.
     * 
     * @var array
     */
    protected $skipNodes = array(
        'ezcDocumentWikiNamedReferenceNode',
        'ezcDocumentWikiAnonymousReferenceNode',
        'ezcDocumentWikiSubstitutionNode',
        'ezcDocumentWikiFootnoteNode',
    );

    /**
     * DOM document
     * 
     * @var DOMDocument
     */
    protected $document;

    /**
     * Docarate Wiki AST
     *
     * Visit the Wiki abstract syntax tree.
     * 
     * @param ezcDocumentWikiDocumentNode $ast 
     * @return mixed
     */
    public function visit( ezcDocumentWikiDocumentNode $ast )
    {
        parent::visit( $ast );

        // Create article from AST
        $imp = new DOMImplementation();
        $dtd = $imp->createDocumentType( 'article', '-//OASIS//DTD DocBook XML V4.5//EN', 'http://www.oasis-open.org/docbook/xml/4.5/docbookx.dtd' );
        $this->document = $imp->createDocument( 'http://docbook.org/ns/docbook', '', $dtd );
        $this->document->formatOutput = true;

//        $root = $this->document->createElement( 'article' );
        $root = $this->document->createElementNs( 'http://docbook.org/ns/docbook', 'article' );
        $this->document->appendChild( $root );

        // Visit all childs of the AST root node.
        foreach ( $ast->nodes as $node )
        {
            $this->visitNode( $root, $node );
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
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitNode( DOMNode $root, ezcDocumentWikiNode $node )
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
     * Visit emphasis markup
     * 
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitEmphasisMarkup( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $markup = $this->document->createElement( 'emphasis' );

        if ( $node instanceof ezcDocumentWikiBoldNode )
        {
            $markup->setAttribute( 'role', 'strong' );
        }
        $root->appendChild( $markup );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $markup, $child );
        }
    }

    /**
     * Visit section titles
     * 
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitTitle( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $title = $this->document->createElement( 'title' );
        $root->appendChild( $title );

        // Add id for internal references.

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $title, $child );
        }
    }

    /**
     * Visit external link node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitExternalLink( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $link = $this->document->createElement( 'ulink' );
        $link->setAttribute( 'url', $node->token->content );
        $link->appendChild( new DOMText( $node->token->content ) );
        $root->appendChild( $link );
    }

    /**
     * Visit link node
     *
     * Docbook has no support for description of links, so that the description
     * elements in the AST are omitted.
     *
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitLink( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $link = $this->document->createElement( 'ulink' );
        $link->setAttribute( 'url', $linkUrl = $this->nodeListToString( $node->link ) );
        $root->appendChild( $link );

        if ( $node->nodes === array() )
        {
            $link->appendChild( new DOMText( $linkUrl ) );
        }
        else
        {
            foreach ( $node->nodes as $child )
            {
                $this->visitNode( $link, $child );
            }
        }
    }

    /**
     * Visit list
     *
     * Ensure stacked lists are created inside another list item.
     *
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitList( DOMNode $root, ezcDocumentWikiNode $node )
    {
        if ( ( $root->tagName === 'itemizedlist' ) ||
             ( $root->tagName === 'orderedlist' ) )
        {
            $listitem = $this->document->createElement( 'listitem' );
            $root->appendChild( $listitem );
            $root = $listitem;
        }

        $list = $this->document->createElement(
            $node instanceof ezcDocumentWikiBulletListNode ? 'itemizedlist' : 'orderedlist'
        );
        $root->appendChild( $list );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $list, $child );
        }
    }

    /**
     * Visit images
     *
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitImages( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $media = $this->document->createElement( $root->tagName === 'para' ? 'inlinemediaobject' : 'mediaobject' );
        $root->appendChild( $media );

        $imageObject = $this->document->createElement( 'imageobject' );
        $media->appendChild( $imageObject );

        $image = $this->document->createElement( 'imagedata' );
        $image->setAttribute( 'fileref', $this->nodeListToString( $node->resource ) );
        $imageObject->appendChild( $image );

        // Handle optional settings on images
        if ( $node->title !== array() )
        {
            $text = $this->document->createElement( 'textobject' );
            $media->appendChild( $text );
            foreach ( $node->title as $child )
            {
                $this->visitNode( $text, $child );
            }
        }

        if ( $node->width )
        {
            $image->setAttribute( 'width', (int) $node->width );
        }

        if ( $node->height )
        {
            $image->setAttribute( 'depth', (int) $node->height );
        }

        if ( $node->alignement )
        {
            $image->setAttribute( 'align', $node->alignement );
        }

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $list, $child );
        }
    }

    /**
     * Visit literal block
     *
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitLiteralBlock( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $literal = $this->document->createElement( 'literallayout', $node->token->content );
        $root->appendChild( $literal );
    }

    /**
     * Visit literal
     *
     * @param DOMNode $root 
     * @param ezcDocumentWikiNode $node 
     * @return void
     */
    protected function visitLiteral( DOMNode $root, ezcDocumentWikiNode $node )
    {
        $literal = $this->document->createElement( 'literal', $node->token->content );
        $root->appendChild( $literal );
    }
}

?>

<?php
/**
 * File containing the ezcDocumentRstDocbookVisitor class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Docbook visitor for the RST AST.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRstDocbookVisitor extends ezcDocumentRstVisitor
{
    /**
     * Mapping of class names to internal visitors for the respective nodes.
     * 
     * @var array
     */
    protected $complexVisitMapping = array(
        'ezcDocumentRstSectionNode'               => 'visitSection',
        'ezcDocumentRstTextLineNode'              => 'visitText',
        'ezcDocumentRstLiteralNode'               => 'visitText',
        'ezcDocumentRstExternalReferenceNode'     => 'visitExternalReference',
        'ezcDocumentRstReferenceNode'             => 'visitInternalReference',
        'ezcDocumentRstAnonymousLinkNode'         => 'visitAnonymousReference',
        'ezcDocumentRstMarkupSubstitutionNode'    => 'visitSubstitutionReference',
        'ezcDocumentRstMarkupInterpretedTextNode' => 'visitChildren',
        'ezcDocumentRstMarkupStrongEmphasisNode'  => 'visitEmphasisMarkup',
        'ezcDocumentRstMarkupEmphasisNode'        => 'visitEmphasisMarkup',
        'ezcDocumentRstTargetNode'                => 'visitInlineTarget',
        'ezcDocumentRstBlockquoteNode'            => 'visitBlockquote',
        'ezcDocumentRstEnumeratedListListNode'    => 'visitEnumeratedList',
        'ezcDocumentRstDefinitionListNode'        => 'visitDefinitionListItem',
        'ezcDocumentRstTableNode'                 => 'visitTable',
        'ezcDocumentRstTableCellNode'             => 'visitTableCell',
        'ezcDocumentRstFieldListNode'             => 'visitFieldListItem',
        'ezcDocumentRstLineBlockNode'             => 'visitLineBlock',
        'ezcDocumentRstLineBlockLineNode'         => 'visitChildren',
        'ezcDocumentRstDirectiveNode'             => 'visitDirective',
    );

    /**
     * Direct mapping of AST node class names to docbook element names.
     * 
     * @var array
     */
    protected $simpleVisitMapping = array(
        'ezcDocumentRstMarkupInlineLiteralNode' => 'literal',
        'ezcDocumentRstParagraphNode'           => 'para',
        'ezcDocumentRstBulletListListNode'      => 'itemizedlist',
        'ezcDocumentRstDefinitionListListNode'  => 'variablelist',
        'ezcDocumentRstBulletListNode'          => 'listitem',
        'ezcDocumentRstEnumeratedListNode'      => 'listitem',
        'ezcDocumentRstLiteralBlockNode'        => 'literallayout',
        'ezcDocumentRstCommentNode'             => 'comment',
        'ezcDocumentRstTransitionNode'          => 'beginpage',
        'ezcDocumentRstTableHeadNode'           => 'thead',
        'ezcDocumentRstTableBodyNode'           => 'tbody',
        'ezcDocumentRstTableRowNode'            => 'row',
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
        'ezcDocumentRstFootnoteNode',
    );

    /**
     * DOM document
     * 
     * @var DOMDocument
     */
    protected $document;

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
                    $element->setAttribute( 'id', $node->identifier );
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
        $section = $this->document->createElement( 'section' );
        $section->setAttribute( 'id', $this->calculateId( $node->title ) );
        $root->appendChild( $section );

        $info = $this->document->createElement( 'sectioninfo' );
        $section->appendChild( $info );

        $title = $this->document->createElement( 'title', htmlspecialchars( trim( $node->title ) ) );
        $section->appendChild( $title );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $section, $child );
        }
    }

    /**
     * Visit text node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitText( DOMNode $root, ezcDocumentRstNode $node )
    {
        $root->appendChild(
            new DOMText( $node->token->content )
        );
    }

    /**
     * Visit children
     *
     * Just recurse into node and visit its children, ignoring the actual
     * node.
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitChildren( DOMNode $root, ezcDocumentRstNode $node )
    {
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $root, $child );
        }
    }

    /**
     * Visit emphasis markup
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitEmphasisMarkup( DOMNode $root, ezcDocumentRstNode $node )
    {
        $markup = $this->document->createElement( 'emphasis' );

        if ( $node instanceof ezcDocumentRstMarkupStrongEmphasisNode )
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
     * Visit external reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitExternalReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->getNamedExternalReference( $this->nodeToString( $node ) );

        $link = $this->document->createElement( 'ulink' );
        $link->setAttribute( 'url', htmlspecialchars( $target ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $link, $child );
        }
    }

    /**
     * Visit internal reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitInternalReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->hasReferenceTarget( $this->nodeToString( $node ) );

        if ( $target instanceof ezcDocumentRstFootnoteNode )
        {
            // The displayed label of a footnote may not be specified in
            // docbook, so we just add the footnote node.
            $this->visitFootnote( $root, $target );
        }
        else
        {
            $link = $this->document->createElement( 'link' );
            $link->setAttribute( 'linked', htmlspecialchars( $target ) );
            $root->appendChild( $link );

            foreach ( $node->nodes as $child )
            {
                $this->visitNode( $link, $child );
            }
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

        $link = $this->document->createElement( 'ulink' );
        $link->setAttribute( 'url', htmlspecialchars( $target ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $link, $child );
        }
    }

    /**
     * Visit substitution reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitSubstitutionReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        if ( ( $substitution = $this->substitute( $this->nodeToString( $node ) ) ) !== null )
        {
            foreach( $substitution as $child )
            {
                $this->visitNode( $root, $child );
            }
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
        $link = $this->document->createElement( 'anchor' );
        $link->setAttribute( 'id', $this->calculateId( $this->nodeToString( $node ) ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $root, $child );
        }
    }

    /**
     * Visit footnote
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitFootnote( DOMNode $root, ezcDocumentRstNode $node )
    {
        $footnote = $this->document->createElement( 'footnote' );
        $root->appendChild( $footnote );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $footnote, $child );
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

        // Add blockquote annotation
        if ( !empty( $node->annotation ) )
        {
            $annotation = $this->document->createElement( 'annotation' );
            $quote->appendChild( $annotation );
            $this->visitNode( $annotation, $node->annotation->nodes );
        }

        // Decoratre blockquote contents
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $quote, $child );
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
        $list = $this->document->createElement( 'orderedlist' );

        // Detect enumeration type
        switch ( true )
        {
            case is_numeric( $node->token->content ):
                $list->setAttribute( 'numeration', 'arabic' );
                break;

            case preg_match( '(^m{0,4}d?c{0,3}l?x{0,3}v{0,3}i{0,3}v?x?l?c?d?m?$)', $node->token->content ):
                $list->setAttribute( 'numeration', 'lowerroman' );
                break;

            case preg_match( '(^M{0,4}D?C{0,3}L?X{0,3}V{0,3}I{0,3}V?X?L?C?D?M?$)', $node->token->content ):
                $list->setAttribute( 'numeration', 'upperroman' );
                break;

            case preg_match( '(^[a-z]$)', $node->token->content ):
                $list->setAttribute( 'numeration', 'loweralpha' );
                break;

            case preg_match( '(^[A-Z]$)', $node->token->content ):
                $list->setAttribute( 'numeration', 'upperalpha' );
                break;
        }

        $root->appendChild( $list );

        // Visit list contents
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $list, $child );
        }
    }

    /**
     * Visit definition list item
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitDefinitionListItem( DOMNode $root, ezcDocumentRstNode $node )
    {
        $item = $this->document->createElement( 'varlistentry' );
        $root->appendChild( $item );
    
        $term = $this->document->createElement( 'term', htmlspecialchars( $this->tokenListToString( $node->name ) ) );
        $item->appendChild( $term );

        $definition = $this->document->createElement( 'listitem' );
        $item->appendChild( $definition );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $definition, $child );
        }
    }

    /**
     * Visit line block
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitLineBlock( DOMNode $root, ezcDocumentRstNode $node )
    {
        $para = $this->document->createElement( 'literallayout' );
        $para->setAttribute( 'class', 'Normal' );
        $root->appendChild( $para );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $para, $child );
        }
    }

    /**
     * Visit table
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitTable( DOMNode $root, ezcDocumentRstNode $node )
    {
        $table = $this->document->createElement( 'table' );
        $root->appendChild( $table );

        $group = $this->document->createElement( 'tgroup' );
        $table->appendChild( $group );

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $group, $child );
        }
    }

    /**
     * Visit table cell
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitTableCell( DOMNode $root, ezcDocumentRstNode $node )
    {
        $cell = $this->document->createElement( 'entry' );
        $root->appendChild( $cell );

        // @TODO: Colspans may be generated by spanspecs, like shown here:
        // http://www.oasis-open.org/docbook/documentation/reference/html/table.html
        if ( $node->rowspan > 1 )
        {
            $cell->setAttribute( 'morerows', $node->rowspan - 1 );
        }

        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $cell, $child );
        }
    }

    /**
     * Visit field list item
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitFieldListItem( DOMNode $root, ezcDocumentRstNode $node )
    {
        // Get sectioninfo node, to add the stuff there.
        $secInfo = $root->getElementsByTagName( 'sectioninfo' )->item( 0 );

        $fieldListItemMapping = array(
            'authors'     => 'author',
            'date'        => 'pubdate',
            'description' => 'abstract',
            'copyright'   => 'copyright',
        );

        $fieldName = strtolower( trim( $this->tokenListToString( $node->name ) ) );
        if ( !isset( $fieldListItemMapping[$fieldName] ) )
        {
            return $this->triggerError(
                E_NOTICE, "Unhandeled field list type '$fieldName'.",
                null, $node->token->line, $node->token->position
            );
        }

        $item = $this->document->createElement(
            $fieldListItemMapping[$fieldName],
            htmlspecialchars( $this->nodeToString( $node ) )
        );
        $secInfo->appendChild( $item );
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
        $directiveHandler->toDocbook( $this->document, $root );
    }
}

?>

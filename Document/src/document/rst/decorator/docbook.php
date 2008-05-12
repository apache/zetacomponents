<?php
/**
 * File containing the ezcDocumentRstDocbookDecorator class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Docbook decorator for the RST AST.
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcDocumentRstDocbookDecorator extends ezcDocumentRstDecorator
{
    /**
     * Mapping of class names to internal decorators for the respective nodes.
     * 
     * @var array
     */
    protected $complexDecorationMapping = array(
        'ezcDocumentRstSectionNode'               => 'decorateSection',
        'ezcDocumentRstTextLineNode'              => 'decorateText',
        'ezcDocumentRstLiteralNode'               => 'decorateText',
        'ezcDocumentRstExternalReferenceNode'     => 'decorateExternalReference',
        'ezcDocumentRstReferenceNode'             => 'decorateInternalReference',
        'ezcDocumentRstAnonymousLinkNode'         => 'decorateAnonymousReference',
        'ezcDocumentRstMarkupSubstitutionNode'    => 'decorateSubstitutionReference',
        'ezcDocumentRstMarkupInterpretedTextNode' => 'decorateChildren',
        'ezcDocumentRstMarkupStrongEmphasisNode'  => 'decorateEmphasisMarkup',
        'ezcDocumentRstMarkupEmphasisNode'        => 'decorateEmphasisMarkup',
        'ezcDocumentRstTargetNode'                => 'decorateInlineTarget',
        'ezcDocumentRstBlockquoteNode'            => 'decorateBlockquote',
        'ezcDocumentRstEnumeratedListListNode'    => 'decorateEnumeratedList',
        'ezcDocumentRstDefinitionListNode'        => 'decorateDefinitionListItem',
        'ezcDocumentRstTableNode'                 => 'decorateTable',
        'ezcDocumentRstTableCellNode'             => 'decorateTableCell',
        'ezcDocumentRstFieldListNode'             => 'decorateFieldListItem',
        'ezcDocumentRstLineBlockNode'             => 'decorateLineBlock',
        'ezcDocumentRstLineBlockLineNode'         => 'decorateChildren',
        'ezcDocumentRstDirectiveNode'             => 'decorateDirective',
    );

    /**
     * Direct mapping of AST node class names to docbook element names.
     * 
     * @var array
     */
    protected $simpleDecorationMapping = array(
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
     * Decorate the RST abstract syntax tree.
     * 
     * @param ezcDocumentRstDocumentNode $ast 
     * @return mixed
     */
    public function decorate( ezcDocumentRstDocumentNode $ast )
    {
        parent::decorate( $ast );

        // Create article from AST
        $this->document = new DOMDocument();
        $this->document->formatOutput = true;

        $root = $this->document->createElement( 'article' );
        $this->document->appendChild( $root );

        // Decorate all childs of the AST root node.
        foreach ( $ast->nodes as $node )
        {
            $this->decorateNode( $root, $node );
        }

        return $this->document;
    }

    /**
     * Decorate single AST node
     *
     * Decorate a single AST node, may be called for each node found anywhere
     * as child. The current position in the DOMDocument is passed by a
     * reference to the current DOMNode, which is operated on.
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateNode( DOMNode $root, ezcDocumentRstNode $node )
    {
        // Iterate over available decorators and use them for node decoration.
        foreach ( $this->complexDecorationMapping as $class => $method )
        {
            if ( $node instanceof $class )
            {
                return $this->$method( $root, $node );
            }
        }

        // Check if we have a simple class to element name mapping
        foreach ( $this->simpleDecorationMapping as $class => $elementName )
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
                    $this->decorateNode( $element, $child );
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

        // We could not find any valid decorator.
        throw new ezcDocumentMissingDecoratorException( get_class( $node ) );
    }

    /**
     * Decorate section node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateSection( DOMNode $root, ezcDocumentRstNode $node )
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
            $this->decorateNode( $section, $child );
        }
    }

    /**
     * Decorate text node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateText( DOMNode $root, ezcDocumentRstNode $node )
    {
        $root->appendChild(
            new DOMText( $node->token->content )
        );
    }

    /**
     * Decorate children
     *
     * Just recurse into node and decorate its children, ignoring the actual
     * node.
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateChildren( DOMNode $root, ezcDocumentRstNode $node )
    {
        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $root, $child );
        }
    }

    /**
     * Decorate emphasis markup
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateEmphasisMarkup( DOMNode $root, ezcDocumentRstNode $node )
    {
        $markup = $this->document->createElement( 'emphasis' );

        if ( $node instanceof ezcDocumentRstMarkupStrongEmphasisNode )
        {
            $markup->setAttribute( 'role', 'strong' );
        }
        $root->appendChild( $markup );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $markup, $child );
        }
    }

    /**
     * Decorate external reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateExternalReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->getNamedExternalReference( $this->nodeToString( $node ) );

        $link = $this->document->createElement( 'ulink' );
        $link->setAttribute( 'url', htmlspecialchars( $target ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $link, $child );
        }
    }

    /**
     * Decorate internal reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateInternalReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->hasReferenceTarget( $this->nodeToString( $node ) );

        if ( $target instanceof ezcDocumentRstFootnoteNode )
        {
            // The displayed label of a footnote may not be specified in
            // docbook, so we just add the footnote node.
            $this->decorateFootnote( $root, $target );
        }
        else
        {
            $link = $this->document->createElement( 'link' );
            $link->setAttribute( 'linked', htmlspecialchars( $target ) );
            $root->appendChild( $link );

            foreach ( $node->nodes as $child )
            {
                $this->decorateNode( $link, $child );
            }
        }
    }

    /**
     * Decorate anonomyous reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateAnonymousReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        $target = $this->getAnonymousReferenceTarget();

        $link = $this->document->createElement( 'ulink' );
        $link->setAttribute( 'url', htmlspecialchars( $target ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $link, $child );
        }
    }

    /**
     * Decorate substitution reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateSubstitutionReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        if ( ( $substitution = $this->substitute( $this->nodeToString( $node ) ) ) !== null )
        {
            foreach( $substitution as $child )
            {
                $this->decorateNode( $root, $child );
            }
        }
    }

    /**
     * Decorate inline target node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateInlineTarget( DOMNode $root, ezcDocumentRstNode $node )
    {
        $link = $this->document->createElement( 'anchor' );
        $link->setAttribute( 'id', $this->calculateId( $this->nodeToString( $node ) ) );
        $root->appendChild( $link );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $root, $child );
        }
    }

    /**
     * Decorate footnote
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateFootnote( DOMNode $root, ezcDocumentRstNode $node )
    {
        $footnote = $this->document->createElement( 'footnote' );
        $root->appendChild( $footnote );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $footnote, $child );
        }
    }

    /**
     * Decorate blockquotes
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateBlockquote( DOMNode $root, ezcDocumentRstNode $node )
    {
        $quote = $this->document->createElement( 'blockquote' );
        $root->appendChild( $quote );

        // Add blockquote annotation
        if ( !empty( $node->annotation ) )
        {
            $annotation = $this->document->createElement( 'annotation' );
            $quote->appendChild( $annotation );
            $this->decorateNode( $annotation, $node->annotation->nodes );
        }

        // Decoratre blockquote contents
        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $quote, $child );
        }
    }

    /**
     * Decorate enumerated lists
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateEnumeratedList( DOMNode $root, ezcDocumentRstNode $node )
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

        // Decorate list contents
        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $list, $child );
        }
    }

    /**
     * Decorate definition list item
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateDefinitionListItem( DOMNode $root, ezcDocumentRstNode $node )
    {
        $item = $this->document->createElement( 'varlistentry' );
        $root->appendChild( $item );
    
        $term = $this->document->createElement( 'term', htmlspecialchars( $this->tokenListToString( $node->name ) ) );
        $item->appendChild( $term );

        $definition = $this->document->createElement( 'listitem' );
        $item->appendChild( $definition );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $definition, $child );
        }
    }

    /**
     * Decorate line block
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateLineBlock( DOMNode $root, ezcDocumentRstNode $node )
    {
        $para = $this->document->createElement( 'literallayout' );
        $para->setAttribute( 'class', 'Normal' );
        $root->appendChild( $para );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $para, $child );
        }
    }

    /**
     * Decorate table
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateTable( DOMNode $root, ezcDocumentRstNode $node )
    {
        $table = $this->document->createElement( 'table' );
        $root->appendChild( $table );

        $group = $this->document->createElement( 'tgroup' );
        $table->appendChild( $group );

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $group, $child );
        }
    }

    /**
     * Decorate table cell
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateTableCell( DOMNode $root, ezcDocumentRstNode $node )
    {
        $cell = $this->document->createElement( 'entry' );
        $root->appendChild( $cell );

        // @TODO: Colspans may be generated by spanspecs, like shown here:
        // http://www.oasis-open.org/docbook/documentation/reference/html/table.html
        if ( $node->rowspan > 1 )
        {
            $cell->setAttribute( 'morerows', $node->rowspan );
        }

        foreach ( $node->nodes as $child )
        {
            $this->decorateNode( $cell, $child );
        }
    }

    /**
     * Decorate field list item
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateFieldListItem( DOMNode $root, ezcDocumentRstNode $node )
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
            // @TODO: Trigger error.
            return;
        }

        $item = $this->document->createElement(
            $fieldListItemMapping[$fieldName],
            htmlspecialchars( $this->nodeToString( $node ) )
        );
        $secInfo->appendChild( $item );
    }

    /**
     * Decorate directive
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function decorateDirective( DOMNode $root, ezcDocumentRstNode $node )
    {
        $handlerClass = $this->rst->getDirectiveHandler( $node->identifier );
        $directiveHandler = new $handlerClass( $this->ast, $node );
        $directiveHandler->toDocbook( $this->document, $root );
    }
}

?>

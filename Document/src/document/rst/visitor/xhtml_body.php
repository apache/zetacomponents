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
 * HTML visitor for the RST AST, which only produces contents to be embedded
 * somewhere into the body of an existing HTML document.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentRstXhtmlBodyVisitor extends ezcDocumentRstXhtmlVisitor
{
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
        // There is no parent::parent::, so this is the dublicated code from
        // ezcDocumentRstVisitor::visit() method.
        $this->ast = $ast;
        $this->preProcessAst( $ast );

        // Reset footnote counters
        foreach ( $this->footnoteCounter as $label => $counter )
        {
            $this->footnoteCounter[$label] = 0;
        }

        // Create article from AST
        $this->document = new DOMDocument();
        $this->document->formatOutput = true;

        $root = $this->document->createElement( 'div' );
        $root->setAttribute( 'class', 'article' );
        $this->document->appendChild( $root );

        $this->head = $this->document->createElement( 'dl' );
        $this->head->setAttribute( 'class', 'head' );
        $root->appendChild( $this->head );

        $body = $this->document->createElement( 'div' );
        $body->setAttribute( 'class', 'body' );
        $root->appendChild( $body );

        // Visit all childs of the AST root node.
        foreach ( $ast->nodes as $node )
        {
            $this->visitNode( $body, $node );
        }

        // Visit all footnotes at the document body
        foreach ( $this->footnotes as $footnotes )
        {
            ksort( $footnotes );
            $footnoteList = $this->document->createElement( 'ul' );
            $footnoteList->setAttribute( 'class', 'footnotes' );
            $body->appendChild( $footnoteList );

            foreach( $footnotes as $footnote )
            {
                $this->visitFootnote( $footnoteList, $footnote );
            }
        }

        return $this->document;
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
     * Visit field list item
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitFieldListItem( DOMNode $root, ezcDocumentRstNode $node )
    {
        $fieldName = strtolower( trim( $this->tokenListToString( $node->name ) ) );
        $term = $this->document->createElement( 'dt', htmlspecialchars( $fieldName ) );
        $this->head->appendChild( $term );

        $term = $this->document->createElement( 'dd', htmlspecialchars( trim( $this->nodeToString( $node ) ) ) );
        $this->head->appendChild( $term );
    }
}

?>

<?php

/**
 * File containing the ezcDocumentDocbookElementVisitorConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit docbook sectioninfo elements
 *
 * The sectioninfo elements contain metadata about the document or
 * sections, which are transformed into the respective metadata in the HTML
 * header.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToHtmlHeadHandler extends ezcDocumentDocbookToHtmlBaseHandler
{
    /**
     * Element name mapping for meta information in the docbook document to
     * HTML meta element names.
     * 
     * @var array
     */
    protected $headerMapping = array(
        'abstract'    => 'description',
        'releaseinfo' => 'version',
        'pubdate'     => 'date',
        'date'        => 'date',
        'author'      => 'author',
        'publisher'   => 'author',
    );

    /**
     * Element name mapping for meta information in the docbook document to
     * HTML meta element names, using the dublin core extensions for meta
     * elements.
     * 
     * @var array
     */
    protected $dcHeaderMapping = array(
        'abstract'  => 'dc.description',
        'pubdate'   => 'dc.date',
        'date'      => 'dc.date',
        'author'    => 'dc.creator',
        'publisher' => 'dc.publisher',
        'contrib'   => 'dc.contributor',
        'copyright' => 'dc.rights',
    );

    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     * 
     * @param ezcDocumentDocbookElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    public function handle( ezcDocumentDocbookElementVisitorConverter $converter, DOMElement $node, $root )
    {
        $headerMapping = $converter->options->dublinCoreMetadata ? $this->dcHeaderMapping : $this->headerMapping;
        $head = $this->getHead( $root );
       
        foreach ( $headerMapping as $tagName => $metaName )
        {
            if ( ( $nodes = $node->getElementsBytagName( $tagName ) ) &&
                 ( $nodes->length > 0 ) )
            {
                foreach ( $nodes as $child )
                {
                    $meta = $root->ownerDocument->createElement( 'meta' );
                    $meta->setAttribute( 'name', $metaName );
                    $meta->setAttribute( 'content', htmlspecialchars( trim( $child->textContent ) ) );
                    $head->appendChild( $meta );
                }
            }
        }

        return $root;
    }
}

?>

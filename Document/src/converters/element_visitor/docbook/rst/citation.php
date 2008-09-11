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
 * Visit citations
 *
 * Citations in docbook are emebedded at the position, the reference should
 * occur. We store the contents, to be rendered at the end of the RST
 * document, and only render a number referencing the actual citation at the
 * position of the citation in the docbook document.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToRstCitationHandler extends ezcDocumentDocbookToRstBaseHandler
{
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
        $citationContent = trim( $converter->visitChildren( $node, '' ) );
        $number = $converter->appendCitation( $citationContent );

        // Add autonumbered citation reference
        $root .= sprintf( '[CIT%03d]_ ', $number );

        return $root;
    }
}

?>

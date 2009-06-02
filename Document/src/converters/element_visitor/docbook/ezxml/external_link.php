<?php
/**
 * File containing the external link handler
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit external links
 *
 * Transform external docbook links (<ulink>) to common HTML links.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToEzXmlExternalLinkHandler extends ezcDocumentElementVisitorHandler
{
    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     *
     * @param ezcDocumentElementVisitorConverter $converter
     * @param DOMElement $node
     * @param mixed $root
     * @return mixed
     */
    public function handle( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        $link = $root->ownerDocument->createElement( 'link' );
        $root->appendChild( $link );

        $linkProperties = $converter->options->linkConverter->getUrlProperties( $node->getAttribute( 'url' ) );
        foreach ( $linkProperties as $key => $value )
        {
            $link->setAttribute( $key, $value );
        }

        $converter->visitChildren( $node, $link );
        return $root;
    }
}

?>

<?php
/**
 * File containing the ezcDocumentRstDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visitor for RST image directives
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcDocumentRstImageDirective extends ezcDocumentRstDirective
{
    /**
     * Transform directive to docbook
     *
     * Create a docbook XML structure at the directives position in the
     * document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        $media = $document->createElement( 'mediaobject' );
        $root->appendChild( $media );

        $imageObject = $document->createElement( 'imageobject' );
        $media->appendChild( $imageObject );

        $image = $document->createElement( 'imagedata' );
        $image->setAttribute( 'fileref', trim( $this->node->parameters ) );
        $imageObject->appendChild( $image );

        // Handle optional settings on images
        if ( isset( $this->node->options['alt'] ) )
        {
            $text = $document->createElement( 'textobject', htmlspecialchars( $this->node->options['alt'] ) );
            $media->appendChild( $text );
        }

        if ( isset( $this->node->options['width'] ) )
        {
            $image->setAttribute( 'width', (int) $this->node->options['width'] );
        }

        if ( isset( $this->node->options['height'] ) )
        {
            $image->setAttribute( 'depth', (int) $this->node->options['height'] );
        }

        if ( isset( $this->node->options['align'] ) )
        {
            $image->setAttribute( 'align', $this->node->options['align'] );
        }
    }
}

?>

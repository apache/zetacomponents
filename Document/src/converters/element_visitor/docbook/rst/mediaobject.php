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
 * Visit media objects
 *
 * Media objects are all kind of other media types, embedded in the
 * document, like images.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToRstMediaObjectHandler extends ezcDocumentDocbookToRstBaseHandler
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
        // Get image resource
        $resource = $node->getElementsBytagName( 'imagedata' )->item( 0 );
        
        $parameter = $resource->getAttribute( 'fileref' );
        $options = array();
        $content = null;
        
        // Transform attributes
        $attributes = array(
            'width'   => 'width',
            'depth'   => 'height',
        );
        foreach ( $attributes as $src => $dst )
        {
            if ( $resource->hasAttribute( $src ) )
            {
                $options[$dst] = $resource->getAttribute( $src );
            }
        }

        // Check if the image has a description
        if ( ( $textobject = $node->getElementsBytagName( 'textobject' ) ) &&
               ( $textobject->length > 0 ) )
        {
            $options['alt'] = trim( $textobject->item( 0 )->textContent );
        }

        // Check if the image has additional description assigned. In such a
        // case we wrap the image and the text inside another block.
        if ( ( $textobject = $node->getElementsBytagName( 'caption' ) ) &&
               ( $textobject->length > 0 ) )
        {
            $textobject = $textobject->item( 0 );

            // Decorate the childs of the caption node recursively, as it might
            // contain additional markup.
            $content = $converter->visitChildren( $textobject, '' );
        }

        // If the directive has explicit content, we render it as a figure
        // instead of an image.
        if ( $content !== null )
        {
            $root .= $this->renderDirective( 'figure', $parameter, $options, $content );
        }
        else
        {
            $root .= $this->renderDirective( 'image', $parameter, $options );
        }

        return $root;
    }
}

?>

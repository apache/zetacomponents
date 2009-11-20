<?php
/**
 * File containing the ezcDocumentDocbookToOdtMediaObjectHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Visit media objects.
 *
 * Visit docbook media objects and transform them into ODT image frames. For 
 * FODT, only PNG images may be inlined. It is checked, that no other objects 
 * are inlined here.
 *
 * @TODO: For later versions: Supporting non flat ODT, we can bundle images and 
 *        simply refer to them.
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentDocbookToOdtMediaObjectHandler extends ezcDocumentDocbookToOdtBaseHandler
{
    /**
     * Counter to generate drawing names. 
     * 
     * @var integer
     */
    protected $counter = 0;

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
        $drawingId = ++$this->counter;

        $imageData = $this->extractImageData( $node );

        $frame = $root->appendChild(
            $root->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_DRAWING,
                'draw:frame'
            )
        );
        $frame->setAttributeNS(
            ezcDocumentOdt::NS_ODT_DRAWING,
            'draw:name',
            'graphics' . $drawingId
        );

        $this->styler->applyStyles( $node, $frame );

        $anchorType = 'paragraph';
        if ( $node->localName === 'mediaobject' )
        {
            $anchorType = 'page';
            // @TODO: Usually needs a anchor-page-number.
        }
        else if ( $this->isInsideText( $node ) )
        {
            $anchorType = 'char';
        }

        $frame->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:anchor-type',
            $anchorType
        );

        if ( $imageData->hasAttribute( 'width' ) )
        {
            $frame->setAttributeNS(
                ezcDocumentOdt::NS_ODT_SVG,
                'svg:width',
                $imageData->getAttribute( 'width' )
            );
        }
        if ( $imageData->hasAttribute( 'depth' ) )
        {
            $frame->setAttributeNS(
                ezcDocumentOdt::NS_ODT_SVG,
                'svg:height',
                $imageData->getAttribute( 'depth' )
            );
        }

        $image = $frame->appendChild(
            $root->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_DRAWING,
                'draw:image'
            )
        );

        if ( !file_exists( $imgFile = $converter->getDocBaseDir() . DIRECTORY_SEPARATOR . $imageData->getAttribute( 'fileref' ) ) )
        {
            throw new ezcBaseFileNotFoundException(
                $imgFile,
                'DocBook referenced image'
            );
        }
        if ( !is_readable( $imgFile ) )
        {
            throw new ezcBaseFilePermissionException(
                $imgFile,
                ezcBaseFileException::READ
            );
        }

        $binaryData = $image->appendChild(
            $root->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_OFFICE,
                'office:binary-data',
                base64_encode(
                    file_get_contents(
                        $imgFile
                    )
                )
            )
        );

        return $root;
    }

    /**
     * Extracts the imagedata part of a media object and validates the file 
     * existence.
     * 
     * @param DOMNode $node 
     * @return DOMNode
     */
    protected function extractImageData( DOMNode $node )
    {
        $imageDataElems = $node->getElementsByTagName( 'imagedata' );
        if ( $imageDataElems->length !== 1 )
        {
            throw new RuntimeException( "Media object without imagedata element." );
        }
        $imageData = $imageDataElems->item( 0 );

        if ( !$imageData->hasAttribute( 'fileref' ) )
        {
            throw new ezcDocumentInvalidDocbookException(
                $imageData,
                'Missing "fileref" attribute.'
            );
        }

        return $imageData;
    }

    /**
     * Checks if $node occurs in between plain text.
     *
     * @param DOMNode $node 
     * @return bool
     */
    protected function isInsideText( DOMNode $node )
    {
        $currentNode = $node;

        while( $currentNode->previousSibling !== null )
        {
            $currentNode = $currentNode->previousSibling;
            switch ( true )
            {
                case ( $currentNode->nodeType === XML_TEXT_NODE && trim( $currentNode->nodeValue ) !== '' ):
                    return true;
                case ( $currentNode->nodeType === XML_ELEMENT_NODE ):
                    return true;
            }
        }

        return false;
    }
}

?>

<?php
/**
 * File containing the ezcDocumentPdfParagraphRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Paragraph renderer
 *
 * Renders a single paragraph including its inline markup.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfMediaObjectRenderer extends ezcDocumentPdfRenderer
{
    /**
     * Render a media object
     *
     *
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfInferencableDomElement $media 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return void
     */
    public function render( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfInferencableDomElement $media, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        // Inference page styles
        $styles = $this->styles->inferenceFormattingRules( $media );

        // Locate image file
        $imageData = $media->getElementsByTagName( 'imagedata' )->item( 0 );
        $imageFile = $mainRenderer->locateFile( (string) $imageData->getAttribute( 'fileref' ) );
        $image = ezcDocumentPdfImage::createFromFile( $imageFile );

        // Estimate size of image box
        $width = $this->getMediaBoxWidth( $styles, $page, $image );

        // Get available height with the estimated width
        $dimensions = $this->scaleImage( $styles, $image, $page, $width );
        $switchBack = false;
        if ( ( $space = $page->testFitRectangle( $page->x, $page->y, $dimensions[0], $dimensions[1] ) ) === false )
        {
            // Image with estimated dimensions does not fit on current page any
            // more.
            $page = $mainRenderer->getNextRenderingPosition( $width->get() );
            $switchBack = true;
        }

        // Get maximum available space
        $space = $page->testFitRectangle( $page->x, $page->y, $width->get(), null );

        // Apply margin of mediaobject
        $space->x      += $styles['margin']->value['left'];
        $space->y      += $styles['margin']->value['top'];
        $space->width  -= $styles['margin']->value['left'] + $styles['margin']->value['right'];
        $space->height -= $styles['margin']->value['top']  + $styles['margin']->value['bottom'];

        // Estimate required height of text blocks
        $captions      = $media->getElementsByTagName( 'caption' );
        $captionHeight = 0;
        $textRenderer  = new ezcDocumentPdfTextBlockRenderer( $this->driver, $this->styles );
        foreach ( $captions as $caption )
        {
            $captionHeight += $textRenderer->estimateHeight( $space->width, $hyphenator, $caption );
        }

        if ( ( $imageHeight = ( $space->height - $captionHeight ) ) < 0 )
        {
            return false;
        }

        // Reduce the image size, of it does not fit any more because of the captions
        if ( $imageHeight < $dimensions[1] )
        {
            $dimensions[0] *= $imageHeight / $dimensions[1];
            $dimensions[1]  = $imageHeight;
        }
        
        // Render image
        $this->driver->drawImage(
            $imageFile, $image->getMimeType(),
            $space->x + ( $space->width - $dimensions[0] ) / 2, $space->y,
            $dimensions[0], $dimensions[1]
        );
        $space->y += $dimensions[1];

        // Render captions
        foreach ( $captions as $caption )
        {
            $space->y += $textRenderer->renderBlock( $space, $hyphenator, $caption );
        }

        // Set covered space covered
        $page->setCovered(
            new ezcDocumentPdfBoundingBox(
                $page->x, $page->y,
                $space->width, $space->y - $page->y
            )
        );
        $page->y = $space->y;

        // Go back to previous page, if requested
        if ( $switchBack )
        {
            $this->driver->goBackOnePage();
        }

        return true;
    }

    /**
     * Calculate width of media box
     * 
     * @param array $styles 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfImage $image 
     * @return ezcDocumentPdfMeasure
     */
    public function getMediaBoxWidth( array $styles, ezcDocumentPdfPage $page, ezcDocumentPdfImage $image )
    {
        if ( $styles['text-columns']->value <= 1 )
        {
            // Just use the full inner width, we do not support floating yet.
            return new ezcDocumentPdfMeasure( $page->innerWidth );
        }

        $imageWidth  = $image->getDimensions();
        $imageWidth  = $imageWidth[0]->get();

        $columns     = $styles['text-columns']->value;
        $spacing     = $styles['text-column-spacing']->value;
        $columnWidth = ( $page->innerWidth - ( $spacing * ( $columns - 1 ) ) ) / $columns;
        
        $width       = $columnWidth;
        $spanning    = 1;
        while ( ( $imageWidth > $width ) &&
                ( $spanning < $columns ) )
        {
            $width += $columnWidth + $spacing;
            ++$spanning;
        }

        return $this->width = new ezcDocumentPdfMeasure( $width );
    }

    /**
     * Calculate scale of image
     *
     * Calculates the output size of the image, depending on the available
     * space and the image dimensions.
     * 
     * @param array $styles 
     * @param ezcDocumentPdfImage $image 
     * @param ezcDocumentPdfPage $page 
     * @param flaot $width 
     * @return array
     */
    protected function scaleImage( array $styles, ezcDocumentPdfImage $image, ezcDocumentPdfPage $page, $width )
    {
        $imageDimensions = $image->getDimensions();

        // Scale image down, if exceeds the maximum available width
        $imageSize = array( $imageDimensions[0]->get(), $imageDimensions[1]->get() );
        if ( $imageSize[0] > $width->get() )
        {
            $imageSize[1] *= $width->get() / $imageSize[0];
            $imageSize[0]  = $width->get();
        }

        // @TODO: Apply styles for image scaling.

        // Check if image would fit on a new page using its default size.
        if ( $page->innerHeight > $imageSize[1] )
        {
            return $imageSize;
        }

        // Otherwise we need to scale the image down even further
        $imageSize[0] *= $page->innerHeight / $imageSize[1];
        $imageSize[1]  = $page->innerHeight;
        return $imageSize;
    }
}
?>

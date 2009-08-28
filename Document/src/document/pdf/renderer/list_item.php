<?php
/**
 * File containing the ezcDocumentPdfTextBoxRenderer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Renders a list item
 *
 * Tries to render a list item into the available space, and aborts if
 * not possible.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfListItemRenderer extends ezcDocumentPdfBlockRenderer
{
    /**
     * Item generator used for this list
     * 
     * @var ezcDocumentListItemGenerator
     */
    protected $generator;

    /**
     * Item number of current item in list
     * 
     * @var int
     */
    protected $item;

    /**
     * Construct from item number
     * 
     * @param ezcDocumentPdfDriver $driver
     * @param ezcDocumentPdfStyleInferencer $styles
     * @param ezcDocumentListItemGenerator $generator 
     * @param int $item 
     * @return void
     */
    public function __construct( ezcDocumentPdfDriver $driver, ezcDocumentPdfStyleInferencer $styles, ezcDocumentListItemGenerator $generator, $item )
    {
        parent::__construct( $driver, $styles );
        $this->generator = $generator;
        $this->item      = $item;
    }

    /**
     * Process to render block contents
     * 
     * @param ezcDocumentPdfPage $page 
     * @param ezcDocumentPdfHyphenator $hyphenator 
     * @param ezcDocumentPdfTokenizer $tokenizer 
     * @param ezcDocumentPdfInferencableDomElement $block 
     * @param ezcDocumentPdfMainRenderer $mainRenderer 
     * @return void
     */
    protected function process( ezcDocumentPdfPage $page, ezcDocumentPdfHyphenator $hyphenator, ezcDocumentPdfTokenizer $tokenizer, ezcDocumentPdfInferencableDomElement $block, ezcDocumentPdfMainRenderer $mainRenderer )
    {
        // Render list item
        $styles = $this->styles->inferenceFormattingRules( $block );
        $this->driver->drawWord(
            $page->x + $page->xOffset - $styles['padding']->value['left'],
            $page->y + $styles['font-size']->value,
            $this->generator->getListItem( $this->item )
        );

        // Render list contents
        $mainRenderer->process( $block );
    }

    /**
     * Get list item generator
     *
     * Get list item generator for the list generator.
     * 
     * @param ezcDocumentPdfInferencableDomElement $block 
     * @return void
     */
    protected function getListItemGenerator( ezcDocumentPdfInferencableDomElement $block )
    {

    }
}

?>

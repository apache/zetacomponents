<?php
/**
 * File containing the ezcDocumentPdfRendererWrappable class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Interface for PDF renderer, which can maintain page wrapping knowledge.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
interface ezcDocumentPdfRendererWrappable
{
    /**
     * Get next rendering position
     *
     * If the current space has been exceeded this method calculates
     * a new rendering position, optionally creates a new page for
     * this, or switches to the next column. The new rendering
     * position is set on the returned page object.
     *
     * As the parameter you need to pass the required width for the object to
     * place on the page.
     *
     * @param float $move
     * @param float $width
     * @return ezcDocumentPdfPage
     */
    public function getNextRenderingPosition( $move, $width );
}

?>

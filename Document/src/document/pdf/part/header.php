<?php
/**
 * File containing the ezcDocumentPdfHeaderPdfPart class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Just an alias for the footer class
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfHeaderPdfPart extends ezcDocumentPdfFooterPdfPart
{
    /**
     * Create a new footer PDF part
     * 
     * @return void
     */
    public function __construct( ezcDocumentPdfFooterOptions $options = null )
    {
        $this->options = ( $options === null ?
            new ezcDocumentPdfFooterOptions() :
            $options );
        $this->options->footer = false;
    }
}
?>

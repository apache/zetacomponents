<?php
/**
 * File containing the ezcDocumentPdfStyleLineBoxValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Style directive line box value representation
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfStyleLineBoxValue extends ezcDocumentPdfStyleBoxValue
{
    /**
     * Get sub value handler
     * 
     * @return ezcDocumentPdfStyleValue
     */
    protected function getSubValue()
    {
        return 'ezcDocumentPdfStyleLineValue';
    }
}

?>

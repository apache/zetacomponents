<?php
/**
 * File containing the ezcDocumentPcssStyleColorBoxValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Style directive color box value representation
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPcssStyleColorBoxValue extends ezcDocumentPcssStyleBoxValue
{
    /**
     * Get sub value handler
     * 
     * @return ezcDocumentPcssStyleValue
     */
    protected function getSubValue()
    {
        return 'ezcDocumentPcssStyleColorValue';
    }
}

?>

<?php
/**
 * File containing the ezcDocumentPdfStyleIntValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Style directive integer value representation
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfStyleIntValue extends ezcDocumentPdfStyleValue
{
    /**
     * Construct value handler from string representation
     *
     * @param mixed $value
     * @return void
     */
    public function __construct( $value )
    {
        $this->value = (int) $value;
    }

    /**
     * Convert value to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $value;
    }
}
?>

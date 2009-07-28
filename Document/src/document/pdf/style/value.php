<?php
/**
 * File containing the ezcDocumentPdfStyleStringValue class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Style directive value representation
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentPdfStyleValue extends ezcBaseStruct
{
    /**
     * Directive value
     *
     * @var mixed
     */
    public $value;

    /**
     * Construct value handler from string representation
     *
     * @param string $value
     * @return void
     */
    abstract public function __construct( $value );

    /**
     * Convert value to string
     *
     * @return string
     */
    abstract public function __toString();
}
?>

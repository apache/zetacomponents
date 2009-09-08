<?php
/**
 * File containing the ezcDocumentPdfCssDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Pdf CSS layout directive.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfCssDeclarationDirective extends ezcDocumentPdfCssDirective
{
    /**
     * Return the type of the directive
     *
     * @return string
     */
    public function getType()
    {
        return strtolower( substr( $this->address, 1 ) );
    }

    /**
     * Recreate directive from var_export
     *
     * @param array $properties
     * @return ezcDocumentPdfCssDirective
     */
    public static function __set_state( $properties )
    {
        return new ezcDocumentPdfCssDeclarationDirective(
            $properties['address'],
            $properties['formats'],
            $properties['file'],
            $properties['line'],
            $properties['position']
        );
    }
}
?>

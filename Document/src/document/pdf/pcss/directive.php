<?php
/**
 * File containing the ezcDocumentPdfCssDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Pdf CSS layout directive.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentPdfCssDirective extends ezcBaseStruct
{
    /**
     * Address string
     * 
     * @var string
     */
    public $address;

    /**
     * Array of formatting rules
     * 
     * @var array
     */
    public $formats;

    /**
     * Construct directive from address and formats 
     * 
     * @param string $address 
     * @param array $formats 
     * @return void
     */
    public function __construct( $address, array $formats )
    {
        $this->address = $address;
        $this->formats = $formats;
    }

    /**
     * Recreate directive from var_export
     * 
     * @param array $properties 
     * @return ezcDocumentPdfCssDirective
     */
    public static function __set_state( $properties )
    {
        return new ezcDocumentPdfCssDirective(
            $properties['address'],
            $properties['formats']
        );
    }
}


<?php
/**
 * File containing the ezcDocumentListItemGenerator class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * List item generator
 *
 * Generator for list items, like bullet list items, and more important
 * enumerated lists.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentAlnumListItemGenerator
{
    /**
     * Constant forcing uppercase alphanumeric list items
     */
    const UPPER = 1;

    /**
     * Constant forcing lowercase alphanumeric list items
     */
    const LOWER = 2;

    /**
     * Style defining if the alphanumeric list items should be
     * lower or upper case.
     * 
     * @var int
     */
    protected $style;

    /**
     * Constructn for upper/lower output
     * 
     * @param int $style 
     * @return void
     */
    public function __construct( $style = self::LOWER )
    {
        $this->style = $style === self::LOWER ? self::LOWER : self::UPPER;
    }

    /**
     * Apply upper/lower-case style to return value.
     * 
     * @param string $string 
     * @return string
     */
    protected function applyStyle( $string )
    {
        switch ( $this->style )
        {
            case self::LOWER:
                return strtolower( $string );

            case self::UPPER:
                return strtoupper( $string );
        }
    }
}

?>

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
 * Numbered list item generator
 *
 * Generator for list items, like bullet list items, and more important
 * enumerated lists.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentRomanListItemGenerator extends ezcDocumentAlnumListItemGenerator
{
    protected $numbers = array(
        1000 => 'M',
        900  => 'CM',
        500  => 'D',
        400  => 'CD',
        100  => 'C',
        90   => 'XC',
        50   => 'L',
        40   => 'XL',
        10   => 'X',
        9    => 'IX',
        5    => 'V',
        4    => 'IV',
        1    => 'I',
    );

    /**
     * Get list item
     *
     * Get the n-th list item. The index of the list item is specified by the
     * number parameter.
     * 
     * @param int $number 
     * @return string
     */
    public function getListItem( $number )
    {
        $item = '';
        foreach ( $this->numbers as $value => $char )
        {
            while ( $number >= $value )
            {
                $item   .= $char;
                $number -= $value;
            }
        }

        return $this->applyStyle( $item );
    }
}

?>

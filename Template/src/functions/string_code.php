<?php
/**
 * File containing the ezcTemplateString class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateString
{
    public static function str_paragraph_count( $string )
    {
        $pos = 0;
        $count = 0;

        while ( preg_match( "/\n\n+/", $string, $m, PREG_OFFSET_CAPTURE, $pos ) )
        {
            ++$count;
            $pos = $m[0][1] + 1;
        }

        return $count;
    }
}


?>

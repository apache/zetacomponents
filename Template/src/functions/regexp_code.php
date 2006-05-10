<?php
/**
 * File containing the ezcTemplateRegExp class
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
class ezcTemplateRegExp
{
    //preg_match( $reg, $s, $matches, $flags [, $offset] )
    //return $matches;
    public static function preg_match( $reg, $string )
    {
        preg_match( $reg, $string, $matches );
        return $matches;
    }
}


?>

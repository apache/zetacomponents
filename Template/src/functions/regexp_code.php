<?php

/**
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

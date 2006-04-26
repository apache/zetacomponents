<?php

/**
 * @access private
*/
class ezcTemplateDebug
{
    public static function debug_dump( $var )
    {
        return print_r( $var, true );
    }
}


?>

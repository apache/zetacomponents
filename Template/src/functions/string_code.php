<?php

/*
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

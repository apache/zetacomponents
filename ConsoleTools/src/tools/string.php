<?php

/**
 * String tool class.
 *
 * Tool class for the ConsoleTools package. Contains binary save string
 * methods.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @access private
 */
class ezcConsoleToolsStringTools
{
    /**
     * Binary safe wordwrap() replacement.
     *
     * This method is a binary safe replacement for the PHP function
     * wordwrap(). It mimics exactly the behavior of wordwrap(), but uses
     * iconv_* functions with UTF-8 encoding, to be binary safe. The parameters
     * received by this method equal the parameters of {@link
     * http://php.net/wordwrap wordwrap()}.
     * 
     * @param string $str 
     * @param int $width 
     * @param string $break 
     * @param bool $cut 
     * @return string|false
     */
    public function wordWrap( $str, $width = 75, $break = "\n", $cut = false )
    {
        $strlen   = iconv_strlen( $str, 'UTF-8' );
        $breaklen = iconv_strlen( $break, 'UTF-8' );
        $newtext  = '';

        if ( $strlen === 0 )
        {
            return '';
        }
    
        if ( $breaklen === 0 )
        {
            return false;
        }

        if ( $width === 0 && $cut )
        {
            return false;
        }

        $laststart  = $lastspace = 0;
        $breakstart = iconv_substr( $break, 0, 1, 'UTF-8' );

        for ( $current = 0; $current < $strlen; $current++ )
        {
            $char = iconv_substr( $str, $current, 1, 'UTF-8' );

            // Existing line break, copy line and  start a new one
            if ( $char === $breakstart
                 && $current + $breaklen < $strlen
                 && iconv_substr( $str, $current, $breaklen, 'UTF-8' ) === $break
               )
            {
                $newtext .= iconv_substr( $str, $laststart, $current - $laststart + $breaklen, 'UTF-8' );
                $current += $breaklen - 1;
                $laststart = $lastspace = $current + 1;
            }

            // Keep track of spaces, if line break is necessary, do it
            else if ( $char === ' ' )
            {
                if ( $current - $laststart >= $width )
                {
                    $newtext .= iconv_substr( $str, $laststart, $current - $laststart, 'UTF-8' )
                        . $break;
                    $laststart = $current + 1;
                }
                $lastspace = $current;
            }

            // Special cut case, if no space has been seen
            else if ( $current - $laststart >= $width
                      && $cut && $laststart >= $lastspace
                    )
            {
                $newtext .= iconv_substr( $str, $laststart, $current - $laststart, 'UTF-8' )
                    . $break;
                $laststart = $lastspace = $current;
            }


            // Usual case that line got longer than expected
            else if ( $current - $laststart >= $width
                      && $laststart < $lastspace
                    )
            {
                $newtext .= iconv_substr( $str, $laststart, $lastspace - $laststart, 'UTF-8' )
                    . $break;
                // $laststart = $lastspace = $lastspace + 1;
                $laststart = ++$lastspace;
            }
        }

		// Rest of the string
        if ( $laststart !== $current )
        {
            $newtext .= iconv_substr( $str, $laststart, $current - $laststart, 'UTF-8' );
        }

        return $newtext;
    }
}

?>

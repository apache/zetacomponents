<?php
/**
 * File containing the ezcTemplateString class
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Template
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * This class contains a bundle of static functions, each implementing a specific
 * function used inside the template language.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateString
{
    /**
     *  Stores the charset used for iconv
     */
    const CHARSET = 'utf-8';

    /**
     * Lower to upper case conversion table.
     *
     * Included on demand when mbstring functions are not available.
     * Generated from http://www.unicode.org/Public/UNIDATA/UnicodeData.txt.
     *
     * @var array(string=>string)
     */
    private static $lowerToUpper = null;

    /**
     * Upper to lower case conversion table.
     *
     * Included on demand when mbstring functions are not available.
     * Generated from http://www.unicode.org/Public/UNIDATA/UnicodeData.txt.
     *
     * @var array(string=>string)
     */
    private static $upperToLower = null;

    /**
     * Escapes all special chars within the given $charlist for using it within
     * a regular expression character class definition (i.e []^-\ and the
     * pattern delimiter). By default the pattern delimiter is '/'.
     *
     * @param string $charlist
     * @param string $patternDelimiter
     * @return string
     */
    private static function escapeCharacterClassCharlist( $charlist, $patternDelimiter = '/' )
    {
        return preg_replace( '!([\\\\\\-\\]\\[^'. $patternDelimiter .'])!', '\\\${1}', $charlist );
    }

    /**
     * Multibyte safe ltrim().
     *
     * Based on http://de.php.net/manual/en/function.trim.php#72562.
     * Added the charlist to the regexp. rtrim seems to be safe for whitespaces.
     *
     * @param string $str
     * @param string $charlist
     * @return string
     */
    public static function ltrim( $str, $charlist = null )
    {
        if ( is_null( $charlist ) )
        {
            return ltrim( $str );
        }
        $charlist = self::escapeCharacterClassCharlist( $charlist );
        return preg_replace( '/^['.$charlist.']+/u', '', $str );
    }

    /**
     * Multibyte safe rtrim().
     *
     * Based on http://de.php.net/manual/en/function.trim.php#72562.
     * Added the charlist to the regexp. rtrim seems to be safe for whitespaces.
     *
     * @param string $str
     * @param string $charlist
     * @return string
     */
    public static function rtrim( $str, $charlist = null )
    {
        if ( is_null( $charlist ) )
        {
            return rtrim( $str );
        }
        $charlist = self::escapeCharacterClassCharlist( $charlist );
        return preg_replace( '/['.$charlist.']+$/u', '', $str );
    }

    /**
     * Multibyte safe str_pad().
     *
     * @param string $input
     * @param int $pad_length
     * @param string $pad_string
     * @param mixed $pad_type
     * @return string
     */
    public static function str_pad( $input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT )
    {
        $diff = strlen( $input ) - iconv_strlen( $input, self::CHARSET );
        return str_pad( $input, $pad_length + $diff, $pad_string, $pad_type );
    }

    /**
     * Returns the number of paragraphs found in the given string.
     *
     * @param string $string
     * @return int
     */
    public static function str_paragraph_count( $string )
    {
        if ( iconv_strlen( $string, self::CHARSET ) == 0 )
        {
            return 0;
        }

        $pos = 0;
        $count = 1;

        while ( preg_match( "/\n\n+/u", $string, $m, PREG_OFFSET_CAPTURE, $pos ) )
        {
            ++$count;
            $pos = $m[0][1] + 1;
        }

        return $count;
    }

    /**
     * Multibyte safe str_word_count().
     *
     * Based on http://de.php.net/manual/en/function.str-word-count.php#85592.
     * Added the $charlist parameter and fixed the offsets for $format=2.
     *
     * @param string $string
     * @param int $format
     * 		0 - returns the number of words found
     * 		1 - returns an array containing all the words found inside the string
     * 		2 - returns an associative array, where the key is the numeric position of the word inside the string and the value is the actual word itself
     * @param string $charlist
     * @return mixed
     */
    public static function str_word_count( $string, $format = 0, $charlist = null )
    {
        if ( !is_null( $charlist ) )
        {
            $charlist = self::escapeCharacterClassCharlist( $charlist );
        }
        else
        {
            $charlist = '';
        }

        $pattern = "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}".$charlist."]*/u";
        $matches = array();
        switch ( $format )
        {
            case 1:
                preg_match_all( $pattern, $string, $matches );
                return $matches[0];
            case 2:
                preg_match_all( $pattern, $string, $matches, PREG_OFFSET_CAPTURE );
                $result = array();
                $diff = 0;
                foreach ( $matches[0] as $match )
                {
                    // reduce wrong offset by multibyte difference
                    $offset = $match[1] - $diff;
                    $result[$offset] = $match[0];
                    // add multibyte offset difference of current word
                    $diff += strlen( $match[0] ) - iconv_strlen( $match[0], self::CHARSET );
                }
                return $result;
            default:
                return preg_match_all( $pattern, $string, $matches );
         }
    }

    /**
     * Multibyte safe strpos().
     *
     * @param string $haystack
     * @param mixed $needle
     * @param int $offset
     * @return int|bool
     */
    public static function strpos( $haystack, $needle, $offset = 0 )
    {
        return iconv_strpos( $haystack, $needle, $offset, self::CHARSET );
    }

    /**
     * Multibyte safe strrpos().
     *
     * @param string $haystack
     * @param mixed $needle
     * @param int $offset
     * @param bool $useMbString
     * @return string
     */
    public static function strrpos( $haystack, $needle, $offset = 0, $useMbString = true )
    {
        if ( $useMbString === true && function_exists( 'mb_strrpos' ) )
        {
            return mb_strrpos( $haystack, $needle, $offset, self::CHARSET );
        }
        else
        {
            $addOffset = 0;
            if ( $offset > 0 )
            {
                $haystack = iconv_substr( $haystack, $offset, iconv_strlen( $haystack, self::CHARSET ), self::CHARSET );
                $addOffset = $offset;
            }
            elseif( $offset < 0 )
            {
                $haystack = iconv_substr( $haystack, 0, $offset, self::CHARSET );
            }
            $result = iconv_strrpos( $haystack, $needle, self::CHARSET );
            return ( $result === false ) ? $result : $result + $addOffset;
        }
    }

    /**
     * Multibyte safe strrev().
     *
     * Based on http://de.php.net/manual/en/function.strrev.php#62422.
     *
     * @param string $str
     * @return string
     */
    public static function strrev( $string )
    {
        if ( empty( $string ) )
        {
            return $string;
        }
        $matches = array();
        preg_match_all( '/./us', $string, $matches );
        return implode( '', array_reverse( $matches[0] ) );
    }

    /**
     * Multibyte safe strtolower().
     * Uses mb_strtolower() if available otherwise falls back to own conversion
     * table.
     *
     * @param string $str
     * @param bool $useMbString
     * @return string
     */
    public static function strtolower( $str, $useMbString = true )
    {
        if ( empty( $str ) )
        {
            return $str;
        }
        if ( $useMbString === true && function_exists( 'mb_strtolower' ) )
        {
            return mb_strtolower( $str, self::CHARSET );
        }
        if ( is_null( self::$upperToLower ) )
        {
            self::$upperToLower = new ezcTemplateStringUpperToLowerUnicodeMap();
        }
        return strtr( $str, self::$upperToLower->unicodeTable );
    }

    /**
     * Multibyte safe strtoupper().
     * Uses mb_strtoupper() if available otherwise falls back to own conversion
     * table.
     *
     * @param string $str
     * @param bool $useMbString
     * @return string
     */
    public static function strtoupper( $str, $useMbString = true )
    {
        if ( empty( $str ) )
        {
            return $str;
        }
        if ( $useMbString === true && function_exists( 'mb_strtoupper' ) )
        {
            return mb_strtoupper( $str, self::CHARSET );
        }
        if ( is_null( self::$lowerToUpper ) )
        {
            self::$lowerToUpper = new ezcTemplateStringLowerToUpperUnicodeMap();
        }
        return strtr( $str, self::$lowerToUpper->unicodeTable );
    }

    /**
     * Multibyte safe trim().
     *
     * @param string $str
     * @param string $charlist
     * @return string
     */
    public static function trim( $str, $charlist = null )
    {
        if ( is_null( $charlist ) )
        {
            return trim( $str );
        }
        return self::ltrim( self::rtrim( $str, $charlist ), $charlist );
    }

    /**
     * Multibyte safe ucfirst().
     *
     * @param string $string
     * @return string
     */
    public static function ucfirst( $string )
    {
        $strlen = iconv_strlen( $string, self::CHARSET );
        if ( $strlen == 0 )
        {
            return '';
        }
        elseif ( $strlen == 1 )
        {
            return self::strtoupper( $string );
        }
        else
        {
            $matches = array();
            preg_match( '/^(.{1})(.*)$/us', $string, $matches );
            return self::strtoupper( $matches[1] ) . $matches[2];
        }
    }

    /**
     * Multibyte safe wordwrap().
     *
     * @param string $str
     * @param int $width
     * @param string $break
     * @param bool $cut
     * @return string
     */
    public static function wordwrap( $str, $width = 75, $break = "\n", $cut = false )
    {
        if ( empty( $str ) )
        {
            return $str;
        }
        $lines = explode( $break, $str );
        $return = '';
        foreach ( $lines as $line )
        {
            $line = trim( $line );
            $length = iconv_strlen( $line, self::CHARSET );
            if ( $length > $width )
            {
                if ( $cut )
                {
                    while ( $length > $width )
                    {
                        $return .= iconv_substr( $line, 0, $width, self::CHARSET ) . $break;
                        $line = iconv_substr( $line, $width, iconv_strlen( $line, self::CHARSET ) - $width, self::CHARSET );
                        $length = iconv_strlen( $line, self::CHARSET );
                    }
                    $return .= $line;
                }
                else
                {
                    $words = explode( ' ', $line );
                    $tmp = '';
                    foreach ( $words as $word )
                    {
                        $word = trim( $word );
                        if ( iconv_strlen( $tmp . $word, self::CHARSET ) <= $width )
                        {
                            $tmp .= $word . ' ';
                        }
                        else
                        {
                            $return .= trim( $tmp ) . $break;
                            $tmp = $word . ' ';
                        }
                    }
                    $return .= trim( $tmp );
                }
            }
            else
            {
                $return .= $line. $break;
            }
        }
        return $return;
    }
}

?>
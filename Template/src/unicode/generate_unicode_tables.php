<?php
$licenseHeader = <<<LICENSE_HEADER
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
 * THIS FILE IS MACHINE GENERATED. USE THE FOLLOWING SCRIPT TO REBUILD IT:
 * - Template/src/unicode/generate_unicode_tables.php
 *
LICENSE_HEADER;

$lowerToUpper = <<<END
<?php
/**
 * File containing a mapping from unicode lowercase to uppercase letters.
 *

END
.$licenseHeader;

$lowerToUpper .= <<<END

 * @package Template
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

class ezcTemplateStringLowerToUpperUnicodeMap extends ezcBaseStruct
{
    public \$unicodeTable = array(

END;

$upperToLower = <<<END
<?php
/**
 * File containing a mapping from unicode uppercase to lowercase letters.

END
.$licenseHeader;

$upperToLower .= <<<END

 * @package Template
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

class ezcTemplateStringUpperToLowerUnicodeMap extends ezcBaseStruct
{
    public \$unicodeTable = array(

END;


$fp = fopen( 'http://www.unicode.org/Public/UNIDATA/UnicodeData.txt', 'r' );

if ( $fp !== false )
{
    while ( ( $line = fgets( $fp ) ) !== false )
    {
        $columns = explode( ';', $line );
        $source = getHexStringFromCodepoint( $columns[0] );
        if ( !empty( $columns[12] ) )
        {
            $lowerToUpper .= '    "' . $source . '" => "' . getHexStringFromCodepoint( $columns[12] ) . '", // ' . $columns[1] . PHP_EOL;
        }
        if ( !empty( $columns[13] ) )
        {
            $upperToLower .= '    "' . $source . '" => "' . getHexStringFromCodepoint( $columns[13] ) . '", // ' . $columns[1] . PHP_EOL;
        }
    }
    fclose( $fp );

    $lowerToUpper .= ');' . PHP_EOL . '}';
    $upperToLower .= ');' . PHP_EOL . '}';

    file_put_contents(
        'Template/src/structs/lower_to_upper.php',
        $lowerToUpper
    );
    file_put_contents(
        'Template/src/structs/upper_to_lower.php',
        $upperToLower
    );
}

/**
 * Get the hex representation of a unicode codepoint.
 *
 * What is going on:
 * http://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&item_id=IWS-AppendixA
 * http://developers.sun.com/dev/gadc/technicalpublications/articles/utf8.html
 *
 * @param int $codepoint
 * @return string
 */
function getHexStringFromCodepoint( $codepoint )
{
    // the comments below explain whats done with the bitwise calculations
    $codepoint = hexdec( $codepoint );
    $result = '';
    if ( $codepoint < 0x80 )
    {
        // C1 = U
        $result = "\\x" . dechex( $codepoint );
    }
    elseif ( $codepoint < 0x800 )
    {
        // C1 = U \ 64 + 192
        // C2 = U mod 64 + 128
        $result = "\\x" . dechex( $codepoint >> 6 | 0xc0 ) .
            "\\x" . dechex( $codepoint & 0x3f | 0x80 );
    }
    elseif ( $codepoint < 0x10000 )
    {
        // C1 = U \ 4096 + 224
        // C2 = (U mod 4096) \ 64 + 128
        // C3 = U mod 64 + 128
        $result = "\\x" . dechex( $codepoint >> 12 | 0xe0 ) .
            "\\x" . dechex( $codepoint >> 6 & 0x3f | 0x80 ) .
            "\\x" . dechex( $codepoint & 0x3f | 0x80 );
    }
    elseif ( $codepoint < 0x110000 )
    {
        // C1 = U \ 262144 + 240
        // C2 = (U mod 262144) \ 4096 + 128
        // C3 = (U mod 4096) \ 64 + 128
        // C4 = U mod 64 + 128
        $result = "\\x" . dechex( $codepoint >> 18 | 0xf0 ) .
            "\\x" . dechex( $codepoint >> 12 & 0x3f | 0x80 ) .
            "\\x" . dechex( $codepoint >> 6 & 0x3f | 0x80 ) .
            "\\x" . dechex( $codepoint & 0x3f | 0x80 );
    }
    return $result;
}
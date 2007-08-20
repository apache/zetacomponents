<?php
/**
 * File containing the ezcUrlTools class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Url
 */

/**
 * Class providing methods for URL parsing.
 *
 * @package Url
 * @version //autogen//
 */
class ezcUrlTools
{
    /**
     * Parses the provided string and returns an associative array structure.
     *
     * It implements the functionality of the PHP function parse_str(), but
     * without converting dots to underscores in parameter names.
     *
     * Example:
     * <code>
     * $str = 'foo[]=bar&openid.nonce=123456';
     *
     * parse_str( $str, $params );
     * $params = ezcUrlTools::parseQuery( $str );
     * </code>
     *
     * In the first case (parse_str()), $params will be:
     * <code>
     * array( 'foo' => array( 'bar' ), 'openid_nonce' => '123456' );
     * </code>
     *
     * In the second case (ezcUrlTools::parseQueryString()), $params will be:
     * <code>
     * array( 'foo' => array( 'bar' ), 'openid.nonce' => '123456' );
     * </code>
     *
     * @param array(string=>mixed) $str The string to parse
     * @return array(string=>mixed)
     */
    public static function parseQueryString( $str )
    {
        $result = array();

        // $params will be returned, but first we have to ensure that the dots
        // are not converted to underscores
        parse_str( $str, $params );

        $separator = ini_get( 'arg_separator.input' );
        if ( empty( $separator ) )
        {
            $separator = '&';
        }

        // go through $params and ensure that the dots are not converted to underscores
        $args = explode( $separator, $str );
        foreach ( $args as $arg )
        {
            $parts = explode( '=', $arg, 2 );
            if ( !isset( $parts[1] ) )
            {
                $parts[1] = null;
            }

            if ( substr_count( $parts[0], '[' ) === 0 )
            {
                $key = $parts[0];
            }
            else
            {
                $key = substr( $parts[0], 0, strpos( $parts[0], '[' ) );
            }

            $paramKey = str_replace( '.', '_', $key );
            if ( isset( $params[$paramKey] ) && strpos( $paramKey, '_' ) !== false )
            {
                $newKey = '';
                for ( $i = 0; $i < strlen( $paramKey ); $i++ )
                {
                    $newKey .= ( $paramKey{$i} === '_' && $key{$i} === '.' ) ? '.' : $paramKey{$i};
                }

                $keys = array_keys( $params );
                if ( ( $pos = array_search( $paramKey, $keys ) ) !== false )
                {
                    $keys[$pos] = $newKey;
                }
                $values = array_values( $params );
                $params = array_combine( $keys, $values );
            }
        }

        return $params;
    }
}
?>

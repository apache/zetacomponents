<?php
/**
 * File containing the ezcAuthenticationUrl class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Class which provides a methods for handling URLs.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationUrl
{
    /**
     * Normalizes the provided URL.
     *
     * The operations performed on the provided URL:
     *  - trim
     *  - add 'http://' in front if it is missing
     *
     * @param string $url The URL to normalize
     * @return string
     */
    public static function normalize( $url )
    {
        $url = trim( $url );
        if ( strpos( $url, '://' ) === false )
        {
            $url = 'http://' . $url;
        }

        return $url;
    }

    /**
     * Appends a query value to the provided URL and returns the complete URL.
     *
     * @param string $url The URL to append a query value to
     * @param string $key The query key to append to the URL
     * @param string $value The query value to append to the URL
     * @return string
     */
    public static function appendQuery( $url, $key, $value )
    {
        $parts = parse_url( $url );
        if ( isset( $parts['query'] ) )
        {
            parse_str( $parts['query'] , $parts['query'] );
        }

        $parts['query'][$key] = $value;
        return self::buildUrl( $parts );
    }

    /**
     * Fetches the value of key $key from the query of the provided URL.
     *
     * @param string $url The URL from which to fetch the query value
     * @param string $key The query key for which to get the value
     * @return true
     */
    public static function fetchQuery( $url, $key )
    {
        $parts = parse_url( $url );
        if ( isset( $parts['query'] ) )
        {
            parse_str( $parts['query'] , $parts['query'] );
            return ( isset( $parts['query'][$key] ) ) ? $parts['query'][$key] : null;
        }
        return null;
    }

    /**
     * Creates a string URL from the provided $parts array.
     *
     * The format of the $parts array is similar to the one returned by
     * parse_url(), with the 'query' part as an array(key=>value) (obtained with
     * the function parse_str()).
     *
     * @param array(string=>mixed) $parts The parts of the URL
     * @return string
     */
    public static function buildUrl( array $parts )
    {
        $path = ( isset( $parts['path'] ) ) ? $parts['path'] : '/';
        $query = ( isset( $parts['query'] ) ) ? '?' . http_build_query( $parts['query'] ) : '';
        $fragment = ( isset( $parts['fragment'] ) ) ? '#' . $parts['fragment'] : '';

        if ( isset( $parts['host'] ) )
        {
            $host = $parts['host'];
            $scheme = ( isset( $parts['scheme'] ) ) ? $parts['scheme'] . '://' : 'http://';
            $port = ( isset( $parts['port'] ) ) ? ':' . $parts['port'] : '';
            $result = "{$scheme}{$host}{$port}{$path}{$query}{$fragment}";
        }
        else
        {
            $result = "{$path}{$query}{$fragment}";
        }

        return $result;
    }
}
?>

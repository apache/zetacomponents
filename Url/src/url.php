<?php
/**
 * File containing the ezcUrl class.
 *
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 */

/**
 * ezcUrl stores a URL both absolute and relative and contains methods to
 * retrieve the various parts of the URL and to manipulate them.
 *
 * EXAMPLES HERE!
 *
 * ezcUrl also provides static methods to store prefixes that you can add
 * to your URL's. This is useful when you have some files in special
 * directories and you don't want to hardcode these paths.
 *
 * Example with a dynamic image path location:
 * <code>
 * ezcUrl::registerPrefix( 'images', 'var/images' );
 *
 * $url = new ezcUrl( "http://www.example.com/image.jpg", 'images' );
 * echo $url->toString();
 * </code>
 *
 * This code outputs:
 *
 * <code>
 * http://www.example.com/var/images/image.jpg
 * </code>
 *
 * The same functionality can also be used to prepare relative URLs:
 * <code>
 *  ezcUrl::addPrefix( 'site', '/mysite/' );
 *  ezcUrl::addPrefix( 'image', '/mysite/images/' );
 *
 *  ezcUrl::prepend( 'image', 'icons/arrow.png' ); // returns '/mysite/images/icons/arrow.png'
 *  ezcUrl::prepend( 'image', 'home.png' );        // returns '/mysite/images/home.png'
 *  ezcUrl::prepend( 'site', 'company/about' );    // returns '/mysite/company/about'
 * </code>
 *
 * The ezcUrl class has the following properties:
 * <b>host</b> - hostname or null
 * <b>path<b> - complete path as an array
 * <b>user</b> - user or null
 * <b>pass</b> - password or null
 * <b>port</b> - port or null
 * <b>scheme</b> - protocol or null
 * <b>query</b> - complete query string as an associative array
 * <b>fragment</b> - anchor or null
 *
 * @package Url
 * @version //autogen//
 */
class ezcUrl
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Holds the URL prefixes for the URL.
     *
     * @var array(string=>mixed)
     */
    private static $prefixes = array();

    /**
     * Constructs a new ezcUrl object from the URL $url.
     *
     * The url is prefixed with the registered prefix $prefix
     * if provided.
     *
     * @throws ezcUrlNoSuchPrefixException if the prefix does not exist
     * @param string $url
     * @param string $prefix
     */
    public function __construct( $url = "", $prefix = null )
    {
        $this->properties['host'] = null;
        $this->properties['path'] = array();
        $this->properties['user'] = null;
        $this->properties['pass'] = null;
        $this->properties['port'] = null;
        $this->properties['scheme'] = null;
        $this->properties['fragment'] = null;
        $this->properties['query'] = array();

        $urlArray = parse_url( $url );

        if ( isset( $urlArray['scheme'] ) )
        {
            $this->properties['scheme'] =  $urlArray['scheme'];
        }

        if ( isset( $urlArray['host'] ) )
        {
            $this->properties['host'] =  $urlArray['host'];
        }

        if ( isset( $urlArray['user'] ) )
        {
            $this->properties['user'] =  $urlArray['user'];
        }

        if ( isset( $urlArray['pass'] ) )
        {
            $this->properties['pass'] =  $urlArray['pass'];
        }

        if ( isset( $urlArray['port'] ) )
        {
            $this->properties['port'] = $urlArray['port'];
        }

        // should this be delayed?
        if ( isset( $urlArray['path'] ) )
        {
            $this->properties['path'] = explode( '/', trim( $urlArray['path'], '/' ) );
        }

        if ( isset( $urlArray['fragment'] ) )
        {
            $this->properties['fragment'] = $urlArray['fragment'];
        }

        if ( isset( $urlArray['query'] ) )
        {
            $elements = array();
            parse_str( $urlArray['query'] , $this->properties['query'] );
        }

        // add the prefix if applicable
        if( $prefix !== null )
        {
            $this->prefix( $prefix );
        }
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'host':
            case 'path':  // as an array
            case 'user':
            case 'pass':
            case 'port':
            case 'scheme': // protocol
            case 'fragment': // anchor, after the #
            case 'query':    // after the ? mark as an array
                $this->properties[$name] = $value;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    /**
     * Returns the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'host':
            case 'path':  // as an array
            case 'user':
            case 'pass':
            case 'port':
            case 'scheme': // protocol
            case 'fragment': // anchor, after the #
            case 'query':    // after the ? mark as an array
                return $this->properties[$name];
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    /**
     * Returns the number of path elements.
     *
     * @return int
     */
    public function getPathElementsCount()
    {
        return count( $this->path );
    }

    /**
     * Names a path element.
     *
     * The named can be used directly on the path array to both
     * set and retrieve the path element:
     * <code>
     * $url = new ezcUrl( 'http://www.example.com/one/two' );
     * $url->namePathElement( 0, 'first' );
     * echo $url->path['first']; // yields 'one'
     *
     * $url->path['first'] = 'new_value';
     * echo $url->path[0]; // yields 'new_value'
     * </code>
     *
     * @param int $index
     * @param string $name
     * @return void
     */
    public function namePathElement( $index, $name )
    {
        if( array_key_exists( $index, $this->path ) )
        {
            $this->path[$name] =& $this->path[$index];
        }
    }

    /**
     * Returns true if this URL is relative.
     *
     * This method returns false if the URL is absolute.
     *
     * @return bool
     */
    public function isRelative()
    {
        if( $this->host === null || $this->host == '' )
        {
            return true;
        }
        return false;
    }

    /**
     * Returns this URL as a string.
     *
     * @return string
     */
    public function toString() // build it
    {
        $url = '';

        if ( $this->scheme )
        {
            $url .= $this->scheme . '://';
        }

        // hostname with user, password and port if found
        if ( $this->host )
        {
            // user
            if( $this->user )
            {
                $url .= $this->user;
                // password
                if( $this->pass )
                {
                    $url .= ':' . $this->pass;
                }
                $url .= '@';
            }

            // hostname and port
            $url .= $this->host;
            if ( $this->port )
            {
                $url .= ':' . $this->port;
            }
        }

        // path
        if ( $this->path )
        {
            $url .= '/' . implode( '/', $this->path );
        }

        // query
        if ( $this->query )
        {
            $url .= '?' . http_build_query( $this->query );
        }

        // fragment
        if ( $this->fragment )
        {
            $url .= '#' . $this->fragment;
        }

        return $url;
    }

    /**
     * Returns this URL as a string by calling toString().
     *
     * @see toString()
     * @return string
     */
    public function __toString() // call toString()
    {
        $this->toString();
    }

    /**
     * Registers a path prefix that can be inserted into URL's later.
     *
     * @param string $name
     * @param string $prefix
     * @return void
     */
    public static function registerPrefix( $name, $prefix )
    {
        self::$prefixes[$name] = $prefix;
    }

    /**
     * Returns the pathstring $path prepended with the prefix named $name.
     *
     * @param string $name
     * @param string $path
     * @return string
     */
    public static function prefixPathString( $name, $path )
    {
        if( !array_key_exists( $name, self::$prefixes ) )
        {
            throw new ezcUrlPrefixNotFoundException( $name );
        }
        return self::$prefixes[$name] . $path;
    }

    /**
     * Prefixes this URL with the prefix named $name.
     *
     * @param string $name
     * @param string $path
     * @return string
     */
    public function prefix( $name )
    {
        if( !array_key_exists( $name, self::$prefixes ) )
        {
            throw new ezcUrlPrefixNotFoundException( $name );
        }
        $newElements = explode( '/', trim( self::$prefixes[$name], '/' ) );
        $this->properties['path'] = array_merge( $newElements, $this->properties['path'] );
    }
}

?>

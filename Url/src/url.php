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
 * @property string $host
 *           Hostname or null
 * @property string $path
 *           Complete path as an array.
 * @property string $user
 *           User or null.
 * @property string $pass
 *           Password or null.
 * @property string $port
 *           Port or null.
 * @property string $scheme
 *           Protocol or null.
 * @property string $query
 *           Complete query string as an associative array.
 * @property string $fragment
 *           Anchor or null.
 * @property string $basedir
 *           Base directory or null.
 * @property string $script
 *           Script name or null.
 * @property string $params
 *           Complete ordered parameters as array.
 * @property string $uparams
 *           Complete unordered parameters as associative array.
 *
 * @package Url
 * @version //autogen//
 * @mainclass
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
     * Holds the url configuration for this url.
     *
     * @var ezcUrlConfiguration
     */
    public $urlCfg = null;

    /**
     * Constructs a new ezcUrl object from the string $url.
     *
     * @param string $url
     * @param ezcUrlConfiguration $urlCfg
     */
    public function __construct( $url = null, $urlCfg = null )
    {
        $this->parseUrl( $url );
        if ( $urlCfg != null )
        {
            $this->applyConfiguration( $urlCfg );
        }
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'host':
            case 'path':
            case 'user':
            case 'pass':
            case 'port':
            case 'scheme':
            case 'fragment':
            case 'query':
            case 'basedir':
            case 'script':
            case 'params':
            case 'uparams':
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
     * @throws ezcBasePropertyNotFoundException
     *         if the property does not exist.
     * @param string $name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'host':
            case 'path':
            case 'user':
            case 'pass':
            case 'port':
            case 'scheme':
            case 'fragment':
            case 'query':
            case 'basedir':
            case 'script':
            case 'params':
            case 'uparams':
                return $this->properties[$name];
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    /**
     * Returns this URL as a string by calling {@link buildUrl()}.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->buildUrl();
    }

    /**
     * Parses the string $url and sets the class properties.
     *
     * @param string $url
     */
    private function parseUrl( $url = null )
    {
        $urlArray = parse_url( $url );

        $this->properties['host'] = isset( $urlArray['host'] ) ? $urlArray['host'] : null;
        $this->properties['user'] = isset( $urlArray['user'] ) ? $urlArray['user'] : null;
        $this->properties['pass'] = isset( $urlArray['pass'] ) ? $urlArray['pass'] : null;
        $this->properties['port'] = isset( $urlArray['port'] ) ? $urlArray['port'] : null;
        $this->properties['scheme'] = isset( $urlArray['scheme'] ) ? $urlArray['scheme'] : null;
        $this->properties['fragment'] = isset( $urlArray['fragment'] ) ? $urlArray['fragment'] : null;
        $this->properties['path'] = isset( $urlArray['path'] ) ? explode( '/', trim( $urlArray['path'], '/' ) ) : array();

        $this->properties['basedir'] = array();
        $this->properties['script'] = array();
        $this->properties['params'] = array();
        $this->properties['uparams'] = array();

        if ( isset( $urlArray['query'] ) )
        {
            parse_str( $urlArray['query'] , $this->properties['query'] );
        }
        else
        {
            $this->properties['query'] = array();
        }
    }

    /**
     * Applies the configuration $urlCfg to the current url.
     *
     * @param ezcUrlConfiguration $urlCfg
     */
    public function applyConfiguration( $urlCfg )
    {
        $this->urlCfg = $urlCfg;
        $this->basedir = $this->parseElement( $urlCfg->basedir, 0 );
        $this->script = $this->parseElement( $urlCfg->script, count( $this->basedir ) );
        $this->uparams = $this->parseUnorderedParameters();
        if ( count( $this->uparams ) != 0 )
        {
            $this->params = array_slice( $this->path, count( $this->basedir ) + count( $this->script ), count( $this->path ) - count( $this->uparams, COUNT_RECURSIVE ) );
        }
        else
        {
            $this->params = array_slice( $this->path, count( $this->basedir ) + count( $this->script ) );
        }
    }

    /**
     * Parses start of $this->path based on the configuration provided.
     *
     * Returns the first few elements of $this->path matching $config,
     * starting from $index.
     *
     * @param string $config
     * @param int $index
     * @return array
     */
    private function parseElement( $config, $index )
    {
        $paramParts = explode( '/', $config );
        $pathElement = array();
        foreach ( $paramParts as $part )
        {
            if ( isset( $this->path[$index] ) && $part == $this->path[$index] )
            {
                $pathElement[] = $part;
            }
            $index++;
        }
        return $pathElement;
    }

    /**
     * Parses the $path array.
     *
     * @return array(string=>mixed)
     */
    private function parseUnorderedParameters()
    {
        $result = array();
        $path = $this->path;
        $pathCount = count( $path );
        if ( $pathCount == 0 || ( $pathCount == 1 && trim( $path[0] ) === "" ) )
        {
            // special case: a bug? in parse_url() which makes $this->path
            // be array( "" ) if the provided url is null or empty
            return $result;
        }
        for ( $i = 0; $i < $pathCount; $i++ )
        {
            $param = $path[$i];
            if ( $param{0} == $this->urlCfg->unorderedDelimiters[0] )
            {
                $param = trim( trim( $param, $this->urlCfg->unorderedDelimiters[0] ),
                    $this->urlCfg->unorderedDelimiters[1] );
                $result[$param] = array();
                $j = 1;
                while ( ( $i + $j ) < $pathCount && $path[$i + $j]{0} != $this->urlCfg->unorderedDelimiters[0] )
                {
                    $result[$param][] = trim( trim( $path[$i + $j], $this->urlCfg->unorderedDelimiters[0] ),
                        $this->urlCfg->unorderedDelimiters[1]  );
                    $j++;
                }
            }
        }
        return $result;
    }

    /**
     * Returns this URL as a string.
     *
     * The query part of the URL is build with http_build_query() which
     * encodes the query in a similar way to urlencode().
     *
     * @return string
     */
    public function buildUrl()
    {
        $url = '';

        if ( $this->scheme )
        {
            $url .= $this->scheme . '://';
        }

        if ( $this->host )
        {
            if ( $this->user )
            {
                $url .= $this->user;
                if ( $this->pass )
                {
                    $url .= ':' . $this->pass;
                }
                $url .= '@';
            }

            $url .= $this->host;
            if ( $this->port )
            {
                $url .= ':' . $this->port;
            }
        }

        if ( $this->urlCfg != null )
        {
            if ( $this->basedir )
            {
                if ( !( count( $this->basedir ) == 0 || trim( $this->basedir[0] ) === "" ) )
                {
                    $url .= '/' . implode( '/', $this->basedir );
                }
            }

            if ( $this->params && count( $this->params ) != 0 )
            {
                $url .= '/' . implode( '/', $this->params );
            }

            if ( $this->uparams && count( $this->uparams ) != 0 )
            {
                foreach ( $this->properties['uparams'] as $key => $values )
                {
                    $url .= '/(' . $key . ')/' . implode( '/', $values );
                }
            }
        }
        else
        {
            if ( $this->path )
            {
                $url .= '/' . implode( '/', $this->path );
            }
        }

        if ( $this->query )
        {
            $url .= '?' . http_build_query( $this->query );
        }

        if ( $this->fragment )
        {
            $url .= '#' . $this->fragment;
        }

        return $url;
    }


    /**
     * Returns true if this URL is relative and false if the URL is absolute.
     *
     * @return bool
     */
    public function isRelative()
    {
        if ( $this->host === null || $this->host == '' )
        {
            return true;
        }
        return false;
    }

    /**
     * Returns the specified parameter from the url based on $urlCfg.
     *
     * @throws ezcUrlNoConfigurationException
     *         if an url configuration was not defined.
     * @throws ezcUrlInvalidParameterException
     *         if the specified parameter is not defined in the configuration.
     * @param string $name
     * @return mixed
     */
    public function getParam( $name )
    {
        if ( $this->urlCfg != null )
        {
            if ( !( isset( $this->urlCfg->orderedParameters[$name] ) ||
                    isset( $this->urlCfg->unorderedParameters[$name] ) ) )
            {
                throw new ezcUrlInvalidParameterException( $name );
            }

            $params = $this->params;
            $uparams = $this->uparams;
            if ( isset( $this->urlCfg->orderedParameters[$name] ) &&
                 isset( $params[$this->urlCfg->orderedParameters[$name]] ) )
            {
                return $params[$this->urlCfg->orderedParameters[$name]];
            }

            if ( isset( $this->urlCfg->unorderedParameters[$name] ) &&
                 isset( $uparams[$name] ) )
            {
                if ( $this->urlCfg->unorderedParameters[$name] == ezcUrlConfiguration::SINGLE_ARGUMENT )
                {
                    if ( count( $uparams[$name] ) > 0 )
                    {
                        return $uparams[$name][0];
                    }
                }
                else
                {
                    return $uparams[$name];
                }
            }
            return null;
        }
        throw new ezcUrlNoConfigurationException( $name );
    }

    /**
     * Sets the specified parameter in the url based on $urlCfg.
     *
     * @throws ezcUrlNoConfigurationException
     *         if an url configuration was not defined.
     * @throws ezcUrlInvalidParameterException
     *         if the specified parameter is not defined in the configuration.
     * @param string $name
     * @param string $value
     */
    public function setParam( $name, $value )
    {
        if ( $this->urlCfg != null )
        {
            if ( !( isset( $this->urlCfg->orderedParameters[$name] ) ||
                    isset( $this->urlCfg->unorderedParameters[$name] ) ) )
            {
                throw new ezcUrlInvalidParameterException( $name );
            }

            if ( isset( $this->urlCfg->orderedParameters[$name] ) )
            {
                $this->properties['params'][$this->urlCfg->orderedParameters[$name]] = $value;
                return;
            }
            if ( isset( $this->urlCfg->unorderedParameters[$name] ) )
            {
                if ( is_array( $value ) )
                {
                    $this->properties['uparams'][$name] = $value;
                }
                else
                {
                    $this->properties['uparams'][$name] = array( $value );
                }
            }
            return;
        }
        throw new ezcUrlNoConfigurationException( $name );
    }

    /**
     * Returns the query elements as an associative array.
     *
     * Example:
     * for 'http://www.example.com/mydir/shop?content=view&products=10'
     * returns array( 'content' => 'view', 'products' => '10' )
     *
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the query elements using the associative array provided.
     *
     * Example:
     * for 'http://www.example.com/mydir/shop'
     * and $query = array( 'content' => 'view', 'products' => '10' )
     * then 'http://www.example.com/mydir/shop?content=view&products=10'
     *
     * @param string $query
     */
    public function setQuery( $query )
    {
        $this->query = $query;
    }
}
?>

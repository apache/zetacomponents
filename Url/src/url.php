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
 * ezcUrl stores an URL both absolute and relative and contains methods to
 * retrieve the various parts of the URL and to manipulate them.
 *
 * Example of use:
 * <code>
 * // create an ezcUrlConfiguration object
 * $urlCfg = new ezcUrlConfiguration();
 * // set the basedir and script values
 * $urlCfg->basedir = 'mydir';
 * $urlCfg->script = 'index.php';
 *
 * // define delimiters for unordered parameter names
 * $urlCfg->unorderedDelimiters = array( '(', ')' );
 *
 * // define ordered parameters
 * $urlCfg->addOrderedParameter( 'section' );
 * $urlCfg->addOrderedParameter( 'group' );
 * $urlCfg->addOrderedParameter( 'category' );
 * $urlCfg->addOrderedParameter( 'subcategory' );
 *
 * // define unordered parameters
 * $urlCfg->addUnorderedParameter( 'game', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );
 *
 * // create a new ezcUrl object from a string url and use the above $urlCfg
 * $url = new ezcUrl( 'http://www.example.com/mydir/index.php/groups/Games/Adventure/Adult/(game)/Larry/7', $urlCfg );
 *
 * // to get the parameter values from the url use $url->getParam():
 * $section =  $url->getParam( 'section' ); // will be "groups"
 * $group = $url->getParam( 'group' ); // will be "Games"
 * $category = $url->getParam( 'category' ); // will be "Adventure"
 * $subcategory = $url->getParam( 'subcategory' ); // will be "Adult"
 * $game = $url->getParam( 'game' ); // will be array( "Larry", "7" )
 * </code>
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
    private $urlCfg = null;

    /**
     * Constructs a new ezcUrl object from the string $url.
     *
     * @param string $url
     * @param ezcUrlConfiguration $urlCfg
     */
    public function __construct( $url = null, ezcUrlConfiguration $urlCfg = null )
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
     *         if the property does not exist
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
     *         if the property does not exist
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

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param $name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
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
                return isset( $this->properties[$name] );

            default:
                return false;
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
     * It fills the arrays $basedir, $script, $params and $uparams with values
     * from $path.
     *
     * @param ezcUrlConfiguration $urlCfg
     */
    public function applyConfiguration( ezcUrlConfiguration $urlCfg )
    {
        $this->urlCfg = $urlCfg;
        $this->basedir = $this->parsePathElement( $urlCfg->basedir, 0 );
        $this->script = $this->parsePathElement( $urlCfg->script, count( $this->basedir ) );
        $this->params = $this->parseOrderedParameters( $urlCfg->orderedParameters, count( $this->basedir ) + count( $this->script ) );
        $this->uparams = $this->parseUnorderedParameters( $urlCfg->unorderedParameters, count( $this->basedir ) + count( $this->script ) + count( $this->params ) );
    }

    /**
     * Parses $path based on the configuration $config, starting from $index.
     *
     * Returns the first few elements of $this->path matching $config,
     * starting from $index.
     *
     * @param string $config
     * @param int $index
     * @return array(string=>mixed)
     */
    private function parsePathElement( $config, $index )
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
     * Returns ordered parameters from the $path array.
     *
     * @param array(int=>string) $config
     * @param int $index
     * @return array(string=>mixed)
     */
    public function parseOrderedParameters( $config, $index )
    {
        $result = array();
        $pathCount = count( $this->path );
        for ( $i = 0; $i < count( $config ); $i++ )
        {
            if ( isset( $this->path[$index + $i] ) )
            {
                $result[] = $this->path[$index + $i];
            }
            else
            {
                $result[] = null;
            }
        }
        return $result;
    }

    /**
     * Returns unordered parameters from the $path array.
     *
     * @param array(int=>string) $config
     * @param int $index
     * @return array(string=>mixed)
     */
    public function parseUnorderedParameters( $config, $index )
    {
        $result = array();
        $pathCount = count( $this->path );
        if ( $pathCount == 0 || ( $pathCount == 1 && trim( $this->path[0] ) === "" ) )
        {
            // special case: a bug? in parse_url() which makes $this->path
            // be array( "" ) if the provided url is null or empty
            return $result;
        }
        for ( $i = $index; $i < $pathCount; $i++ )
        {
            $param = $this->path[$i];
            if ( $param{0} == $this->urlCfg->unorderedDelimiters[0] )
            {
                $param = trim( trim( $param, $this->urlCfg->unorderedDelimiters[0] ), $this->urlCfg->unorderedDelimiters[1] );
                $result[$param] = array();
                $j = 1;
                while ( ( $i + $j ) < $pathCount && $this->path[$i + $j]{0} != $this->urlCfg->unorderedDelimiters[0] )
                {
                    $result[$param][] = trim( trim( $this->path[$i + $j], $this->urlCfg->unorderedDelimiters[0] ), $this->urlCfg->unorderedDelimiters[1] );
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
     *         if an $urlCfg is not defined
     * @throws ezcUrlInvalidParameterException
     *         if the specified parameter is not defined in $urlCfg
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
     *         if an $urlCfg is not defined
     * @throws ezcUrlInvalidParameterException
     *         if the specified parameter is not defined in $urlCfg
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
     * @return array(string=>mixed)
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

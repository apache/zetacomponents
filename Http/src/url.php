<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package Http
 */

/**
 * URL handling class.
 *
 * ezcHttpUrl serves two needs:
 * - URL parsing.
 * - Prepending specified URIs with previously set prefix.
 *
 * The URL parsing functionality basically provides functions
 * for fetching host, port, uri, script path, script name,
 * script parameters, anchor  from the given URL.
 *
 * Example of usage:
 * <code>
 * $url = new ezcHttpUrl( 'http://site.com/path/to/script.php' );
 * echo "Host: {$url->host}\n";
 * echo "Path: {$url->path}\n";
 * </code>
 *
 *
 * It's often needed to have internal links on your pages without
 * depending on a specific directory structure.
 * For example, you would like to display a link to internal URI '/company/contacts'.
 * If your site is located under '/mysite', the link would be '/mysite/company/contants'.
 * If you don't want to hardcode these prefixes in your links, you can set it with
 * {@link ezcHttpUrl::addPrefix()} and then easily prepend it to any link with
 * {@link ezcHttpUrl::prepend()}.
 *
 * You can choose quoting style for links returned by {@link prepend()}:
 * it can either add no quotes, single or double quote.
 * Quoting style may be specified per prefix and overriden in call to {@link prepend()}.
 *
 * Properties
 * property string protocol - The protocol used, e.g http.
 * property string host - the hostname part of the url.
 * property int port - a port or false if not set.
 * property string path - the complete path until the scriptname.
 * property string scriptName - the name of the script that has been run.
 * property scriptParameters - everything behind the questionmark.
 * property anchor - everything behind the # except for parameters.
 *
 * Example:
 * <code>
 *  ezcHttpUrl::addPrefix( 'site', '/mysite/' );
 *  ezcHttpUrl::addPrefix( 'image', '/mysite/images/' );
 *
 *  ezcHttpUrl::prepend( 'image', 'icons/arrow.png' ); // returns '/mysite/images/icons/arrow.png'
 *  ezcHttpUrl::prepend( 'image', 'home.png' );        // returns '/mysite/images/home.png'
 *  ezcHttpUrl::prepend( 'site', 'company/about' );    // returns '/mysite/company/about'
 * </code>
 *
 * @package Http
 */
class ezcHttpUrl
{
    /**
     * Quoting style: no quotes.
     * The resulting URL returned by {@link prepend()} will not be enclosed with any quotes.
     */
    const NO_QUOTES     = 1;

    /**
     * Quoting style: single quotes.
     * The resulting URL returned by {@link prepend()} will be enclosed with single quotes.
     */
    const SINGLE_QUOTES = 2;

    /**
     * Quoting style: double quotes.
     * The resulting URL returned by {@link prepend()} will be enclosed with double quotes.
     */
    const DOUBLE_QUOTES = 3;

    /**
     * A structure containing all the prefixes.
     *
     * @var array(array)
     */
    private static $prefixes;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties;

    /**
     * Constructs a new ezcHttpUrl with the url $url.
     *
     * @param string
     */
    public function __construct( $url )
    {
        $urlArray = parse_url( $url );

        // Initialize all the properties.
        $this->protocol = false;
        $this->host = false;
        $this->port = false;
        $this->path = false;
        $this->scriptName = false;
        $this->scriptParameters = false;
        $this->anchor = false;

        // Set some properties if the appropriate URL parts exist.
        if ( isset( $urlArray['scheme'] ) )
            $this->protocol =  $urlArray['scheme'];

        if ( isset( $urlArray['host'] ) )
            $this->host =  $urlArray['host'];

        if ( isset( $urlArray['port'] ) )
            $this->port = $urlArray['port'];

        if ( isset( $urlArray['path'] ) )
        {
            $this->path = $urlArray['path'];
            $this->scriptName = basename( $urlArray['path'] );
        }

        if ( isset( $urlArray['query'] ) )
            $this->scriptParameters = $urlArray['query'];

        if ( isset( $urlArray['fragment'] ) )
            $this->anchor = $urlArray['fragment'];
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
            case 'protocol':
            case 'host':
            case 'port':
            case 'path':
            case 'scriptName':
            case 'scriptParameters':
            case 'anchor':
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
            case 'protocol':
            case 'host':
            case 'port':
            case 'path':
            case 'scriptName':
            case 'scriptParameters':
            case 'anchor':
                return $this->properties[$name];
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }

    /**
     * Returns the URL constructed by the properties of this class.
     *
     * @return string
     */
    public function build()
    {
        $url = '';

        if ( $this->protocol )
            $url .= $this->protocol . '://';

        if ( $this->host )
            $url .= $this->host;

        if ( $this->port )
            $url .= ':' . $this->port;

        if ( $this->path )
            $url .= $this->path;

        if ( $this->scriptParameters )
            $url .= '?' . $this->scriptParameters;

        if ( $this->anchor )
            $url .= '#' . $this->anchor;

        return $url;
    }

    /**
     * Adds the prefix $prefix with the identifier $prefixName to the list of avaliable prefixes.
     *
     * $defaultQuotingStyle can be used to set the default quoting style for this prefix.
     * The default is not to add any quotes.
     *
     * You can prepend a URI with this prefix later using {@link prepend}.
     *
     * @param string $prefixName
     * @param string $prefix
     * @param string $defaultQuotingStyle
     * @return void
     */
    static public function addPrefix( $prefixName, $prefix, $defaultQuotingStyle = false )
    {
        self::$prefixes[$prefixName] = array( $prefix, $defaultQuotingStyle );
    }

    /**
     * Prepends the prefix identified by $prefixName to the URI $uri.
     *
     * You can override the default quoting style set for the given prefix
     * with $quotingStyleOverride.
     *
     * @param string $prefixName
     * @param string $uri
     * @param int $quotingStyleOveride
     * @return string
     */
    static public function prepend( $prefixName, $uri, $quotingStyleOverride = false )
    {
        // Look up specified prefix in the table.
        if ( !isset( self::$prefixes[$prefixName] ) )
        {
            throw new ezcHttpException(
                ezcHttpException::INVALID_ARGUMENT,
                "Unknown URL prefix name specified: '$prefixName'." );
        }

        // Do the main work :-), actually prepending the URI prefix.
        $uri = self::$prefixes[$prefixName][0] . $uri;

        // Choose quoting style.
        $quotingStyle = self::NO_QUOTES;
        if ( self::$prefixes[$prefixName][1] )
            $quotingStyle = self::$prefixes[$prefixName][1];
        if ( $quotingStyleOverride !== false )
            $quotingStyle = $quotingStyleOverride;

        // Add quotes if needed.
        switch ( $quotingStyle )
        {
            case self::NO_QUOTES:
                return $uri;
            case self::SINGLE_QUOTES:
                return "'$uri'";
            case self::DOUBLE_QUOTES:
                return '"' . $uri . '"';
            default:
                throw new ezcHttpException(
                        ezcHttpException::INVALID_ARGUMENT,
                        "Unknown quoting style specified." );
        }
    }
}
?>

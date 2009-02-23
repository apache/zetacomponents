<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * Request parser that uses HTTP headers to populate an ezcMvcRequest object.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
class ezcMvcHttpResponseWriter extends ezcMvcResponseWriter
{
    /**
     * Contains the response struct
     *
     * @var ezcMvcResponse
     */
    protected $response;

    /**
     * Contains an array of header name to value mappings
     *
     * @var array(string=>string)
     */
    public $headers;

    /**
     * Creates a new ezcMvcHttpResponseWriter class to write $response
     *
     * @param ezcMvcResponse $response
     */
    public function __construct( ezcMvcResponse $response )
    {
        $this->response = $response;
        $this->headers = array();
    }

    /**
     * Takes the raw protocol depending response body, and the protocol
     * abstract response headers and forges a response to the client. Then it sends
     * the assembled response to the client.
     */
    public function handleResponse()
    {
        // process all headers
        $this->processStandardHeaders();
        if ( $this->response->cache instanceof ezcMvcResultCache )
        {
            $this->processCacheHeaders();
        }
        if ( $this->response->content instanceof ezcMvcResultContent )
        {
            $this->processContentHeaders();
        }

        // process the status headers through objects
        if ( $this->response->status instanceof ezcMvcResultStatusObject )
        {
            $this->response->status->process( $this );
        }

        // automatically add content-length header
        $this->headers['Content-Length'] = strlen( $this->response->body );

        // write output
        foreach ( $this->headers as $header => $value )
        {
            header( "$header: $value" );
        }
        // do cookies
        foreach ( $this->response->cookies as $cookie )
        {
            $this->processCookie( $cookie );
        }
        echo $this->response->body;
    }

    /**
     * Takes a $cookie and uses PHP's setcookie() function to add cookies to the output stream.
     *
     * @param ezcMvcResultCookie $cookie
     */
    private function processCookie( ezcMvcResultCookie $cookie )
    {
        $args = array();
        $args[] = $cookie->name;
        $args[] = $cookie->value;
        if ( $cookie->expire instanceof DateTime )
        {
            $args[] = $cookie->expire->format( 'U' );
        }
        else
        {
            $args[] = null;
        }
        $args[] = $cookie->domain;
        $args[] = $cookie->path;
        $args[] = $cookie->secure;
        $args[] = $cookie->httpOnly;
        call_user_func_array( 'setcookie', $args );
    }

    /**
     * Checks whether there is a DateTime object in $obj->$prop and sets a header accordingly.
     *
     * @param Object $obj
     * @param string $prop
     * @param string $headerName
     * @param bool   $default
     */
    private function doDate( $obj, $prop, $headerName, $default = false )
    {
        if ( $obj->$prop instanceof DateTime )
        {
            $headerDate = clone $obj->$prop;
            $headerDate->setTimezone( new DateTimeZone( "UTC" ) );
            $this->headers[$headerName] = $headerDate->format( 'D, d M Y H:i:s \G\M\T' );
            return;
        }

        if ( $default )
        {
            $headerDate = new DateTime( "UTC" );
            $this->headers[$headerName] = $headerDate->format( 'D, d M Y H:i:s \G\M\T' );
        }
    }

    /**
     * Processes the standard headers that are not subdivided into other structs.
     */
    protected function processStandardHeaders()
    {
        $res = $this->response;

        // generator
        $this->headers['X-Powered-By'] = $res->generator !== ''
            ? $res->generator
            : "eZ Components MvcTools";

        $this->doDate( $res, 'date', 'Date', true );
    }

    /**
     * Processes the caching related headers.
     */
    protected function processCacheHeaders()
    {
        $cache = $this->response->cache;

        if ( $cache->vary )
        {
            $this->headers['Vary'] = $cache->vary;
        }
        $this->doDate( $cache, 'expire', 'Expires' );
        if ( count( $cache->controls ) )
        {
            $this->headers['Cache-Control'] = join( ', ', $cache->controls );
        }
        if ( $cache->pragma )
        {
            $this->headers['Pragma'] = $cache->pragma;
        }
        $this->doDate( $cache, 'lastModified', 'Last-Modified' );
    }

    /**
     * Processes the content type related headers.
     */
    protected function processContentHeaders()
    {
        $content = $this->response->content;
        $defaultContentType = 'text/html';

        if ( $content->language )
        {
            $this->headers['Content-Language'] = $content->language;
        }
        if ( $content->type || $content->charset )
        {
            $contentType = $content->type ? $content->type : $defaultContentType;
            if ( $content->charset )
            {
                $contentType .= '; charset=' . $content->charset;
            }
            $this->headers['Content-Type'] = $contentType;
        }
        if ( $content->encoding )
        {
            $this->headers['Content-Encoding'] = $content->encoding;
        }
    }
}
?>

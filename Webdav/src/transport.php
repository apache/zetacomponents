<?php
/**
 * File containing the basic standard compliant transport mecanism.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * The transport handler parses the request and echos the response depending on
 * the client it has been written for.
 *
 * This basic implementation handles requests and responses as defined in RFC
 * 2518 and should be extended for misbehaving clients.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavTransport
{
    /**
     * Parses the webserver environment variables to create a proper request
     * object from then containing all relevant information to handle the
     * request by the backend.
     *
     * @return ezcWebdavRequest
     */
    public function parseRequest( $uri )
    {
        $body = '';
        $in   = fopen( 'php://input', 'r' );

        while ( $data = fread( $in ) )
        {
            $body .= $data;
        }

        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'PROPFIND':
                return $this->parsePropFindRequest( $body );
            default:
                throw new ezcWebdavInvalidRequestMethodException(
                    $_SERVER['REQUEST_METHOD']
                );
        }
    }

    protected function parsePropFindRequest( $uri, $body )
    {
        $request = new ezcWebdavPropFindRequest( $uri );

        $dom = DOMDocument::loadXML( $body );
        if ( $dom->documentElement->tagName !== 'propfind' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPFIND',
                "Expected XML element <propfind />, received <{$dom->documentElement->tagName} />."
            );
        }
        if ( $dom->documentElement->firstChild === null )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'PROPFIND',
                "Element <propfind /> does not have a child element."
            );
        }
        switch ( $dom->documentElement->firstChild->tagName )
        {
            case 'allprop':
                $request->allProp = true;
                break;
            case 'propname':
                $request->propName = true;
                break;
            case 'prop':
                $request->prop = $this->extractProperties(
                    $dom->documentElement->getElementsByTagNameNS( 'DAV:', 'prop' )
                );
                break;
            default:
                throw new ezcWebdavInvalidRequestBodyException(
                    'PROPFIND',
                    "XML element <{$dom->documentElement->firstChild->tagName} /> is not a valid child element for <propfind />."
                );
        }
        return $request;
    }

    /**
     * Handle a response from the backend and output it depending on the
     * current transport mechanism.
     * 
     * @param ezcWebdavResponse $response
     * @return void
     */
    public function handleResponse( ezcWebdavResponse $response )
    {
        // @TODO: Implement
    }
}

?>

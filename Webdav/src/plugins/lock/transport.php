<?php
/**
 * File containing the ezcWebdavLockPluginRequestParser class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Transport layer extension class of the lock plugin.
 *
 * This class contains methods that extend the transport layer of the Webdav
 * component, by providing methods that parse requests and process responses.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockPluginTransport
{
    /**
     * Map for request parsers.
     *
     * Maps request method names as provided by $_SERVER to methods of this
     * class.
     *
     * @array(string=>string)
     */
    protected static $parsingMap = array(
        'LOCK'   => 'parseLockRequest',
        'UNLOCK' => 'parseUnlockRequest',
    ):

    /**
     * Callback for the hook ezcWebdavTransport::parseUnknownRequest().
     *
     * Reacts on the LOCK and UNLOCK request methods.
     * 
     * @param string $method
     * @param string $path
     * @param string $body
     * @return ezcWebdavRequest
     */
    public function parseRequest( $method, $path, $body )
    {
        if ( isset( self::$parsingMap[$params['requestUri']] ) )
        {
            return call_user_func(
                array( $this, self::$parsingMap[$params['requestUri']] ),
                $params['path'],
                $params['body']
            );
        }
        // return null;
    }

    /**
     * Handles responses of the LOCK plugin.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavDisplayInformation
     */
    public function handleResponse( ezcWebdavResponse $response )
    {
        throw new RuntimeException( 'Not implemented.' );
    }

    /**
     * Parses the LOCK request and returns a request object.
     *
     * This method is responsible for parsing the LOCK request. It retrieves
     * the current request URI in $path and the request body as $body.  The
     * return value, if no exception is thrown, is a valid {@link
     * ezcWebdavLockRequest} object.
     *
     * This method may be overwritten to adjust it to special client behaviour.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavLockRequest
     */
    public function parseLockRequest( $path, $body )
    {
        $request = new ezcWebdavLockRequest( $path );

        $request->setHeaders(
            ezcWebdavServer::getInstance()->headerHandler->parseHeaders(
                array( 'Depth', 'Timeout' )
            )
        );

        if ( trim( $body ) === '' )
        {
            return $request;
        }

        if ( ( $dom = ezcWebdavServer::getInstance()->xmlTool->createDomDocument( $body ) ) === false )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Could not open XML as DOMDocument: '{$body}'."
            );
        }
        
        if ( $dom->documentElement->localName !== 'lockinfo' )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Expected XML element <lockinfo />, received <{$dom->documentElement->localName} />."
            );
        }

        $lockTypeElements  = $dom->documentElement->getElementsByTagnameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'locktype' );
        $lockScopeElements = $dom->documentElement->getElementsByTagnameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'lockscope' );
        $ownerElements     = $dom->documentElement->getElementsByTagnameNS( ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE, 'owner' );

        if ( $lockTypeElements->length === 0 )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Expected XML element <locktype /> as child of <lockinfo /> in namespace DAV: which was not found."
            );
        }
        if ( $lockScopeElements->length === 0 )
        {
            throw new ezcWebdavInvalidRequestBodyException(
                'LOCK',
                "Expected XML element <lockscope /> as child of <lockinfo /> in namespace DAV: which was not found."
            );
        }

        // @todo is the following not restrictive enough?
        $request->lockInfo = new ezcWebdavRequestLockInfoContent(
            ( $lockScopeElements->item( 0 )->firstChild->localName === 'exclusive'
                ? ezcWebdavLockRequest::SCOPE_EXCLUSIVE
                : ezcWebdavLockRequest::SCOPE_SHARED ),
            ( $lockTypeElements->item( 0 )->firstChild->localName === 'read'
                ? ezcWebdavLockRequest::TYPE_READ
                : ezcWebdavLockRequest::TYPE_WRITE ),
            ( $ownerElements->length > 0 
                ? $ownerElements->item( 0 )->textContent
                : null )
        );

        return $request;
    }
    
    /**
     * Parses the UNLOCK request and returns a request object.
     *
     * This method is responsible for parsing the UNLOCK request. It retrieves
     * the current request URI in $path and the request body as $body.  The
     * return value, if no exception is thrown, is a valid {@link
     * ezcWebdavUnlockRequest} object.
     *
     * This method may be overwritten to adjust it to special client behaviour.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavUnlockRequest
     */
    public function parseUnlockRequest( $path, $body )
    {
        $request = new ezcWebdavUnlockRequest( $path );

        $request->setHeaders(
            ezcWebdavServer::getInstance()->headerHandler->parseHeaders(
                array( 'Lock-Token' )
            )
        );

        return $request;
    }
}

?>

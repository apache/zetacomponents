<?php

class ezcWebdavTransportTestMock extends ezcWebdavTransport
{
    protected function retreiveBody()
    {
        return isset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] ) ? $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] : '';
    }

    protected function sendResponse( ezcWebdavDisplayInformation $info )
    {
        $headers = array();

        switch ( true )
        {
            case ( $info->body instanceof DOMDocument ):
                $info->body->formatOutput = true;
                $result = $info->body->saveXML( $info->body );
                break;
            case ( is_string( $info->body ) ):
                $result = $info->body;
                break;
            case ( $info->body === null ):
            default:
                $result = '';
                break;
        }
        
        // Sends HTTP response code and description
        $headers[] = (string) $info->response;

        // Send headers defined by response
        $responseHeaders = $info->response->getHeaders();
        foreach ( $responseHeaders as $name => $value )
        {
            $headers[$name] = $value;
        }

        // Do we need to explictly send the Content-Length header here?
        
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY']    = $result;
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'] = $headers;
        // All done
    }
}

?>

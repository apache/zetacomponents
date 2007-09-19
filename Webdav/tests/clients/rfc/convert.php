<?php

$files = glob( './*.txt' );

foreach ( $files as $testDataFile )
{
    $content = array_map( 'rtrim', file( $testDataFile ) );

    $request = array(
        'server' => array(),
        'body'   => '',
        'uri'    => '',
    );

    $response = array(
        'headers' => array(),
        'body'    => '',
        'code'    => null,
        'name'    => '',
    );

    $mode = 'start';
    $lastHeader = '';
    foreach ( $content as $no => $line )
    {
        switch ( $mode )
        {
            case 'start':
                if ( $line == '' )
                {
                    $mode = 'read_request_head';
                }
                break;
            case 'read_request_head':
                if ( preg_match( '(^(\w+)\s+(\S+)\s+(\S+)$)', $line, $matches ) < 1 )
                {
                    throw new RuntimeException( "Could not match '$mode' on line $no '$line' of file $testDataFile." );
                }
                $request['server']['REQUEST_METHOD']  = $matches[1];
                $request['server']['REQUEST_URI']     = $matches[2];
                $request['server']['SERVER_PROTOCOL'] = $matches[3];
                $mode = 'read_blank_before_request_headers';
                break;
            case 'read_blank_before_request_headers':
                $mode = 'read_request_headers';
                // break; 
            case 'read_request_headers':
                if ( preg_match( '(^(\S+):\s+(.+)$)', $line, $matches ) > 0 )
                {
                    switch( strtolower( $matches[1] ) )
                    {
                        case 'host':
                            $request['server']['HTTP_HOST'] = $matches[2];
                            $lastHeader = 'HTTP_HOST';
                            break;
                        case 'content-type':
                            $request['server']['CONTENT_TYPE'] = $matches[2];
                            $lastHeader = 'CONTENT_TYPE';
                            break;
                        case 'content-length':
                            // Workaround for RFC dummy
                            $request['server']['HTTP_CONTENT_LENGTH'] = ( $matches[2] === 'xxxx' ? "1234" : $matches[2] );
                            $lastHeader = 'HTTP_CONTENT_LENGTH';
                            break;
                        case 'depth':
                            $request['server']['HTTP_DEPTH'] = $matches[2];
                            $lastHeader = 'HTTP_DEPTH';
                            break;
                        // @TODO Guessed from here, need validation!
                        case 'destination':
                            $request['server']['HTTP_DESTINATION'] = $matches[2];
                            $lastHeader = 'HTTP_DESTINATION';
                            break;
                        case 'overwrite':
                            $request['server']['HTTP_OVERWRITE'] = $matches[2];
                            $lastHeader = 'HTTP_OVERWRITE';
                            break;
                        case 'timeout':
                            $request['server']['HTTP_TIMEOUT'] = $matches[2];
                            $lastHeader = 'HTTP_TIMEOUT';
                            break;
                        case 'authorization':
                            $request['server']['HTTP_AUTH'] = $matches[2];
                            $lastHeader = 'HTTP_AUTH';
                            break;
                        case 'if':
                            $request['server']['HTTP_IF'] = $matches[2];
                            $lastHeader = 'HTTP_IF';
                            break;
                        case 'if':
                            $request['server']['HTTP_IF'] = $matches[2];
                            $lastHeader = 'HTTP_IF';
                            break;
                        case 'lock-token':
                            $request['server']['HTTP_LOCK_TOKEN'] = $matches[2];
                            $lastHeader = 'HTTP_LOCK_TOKEN';
                            break;

                        default:
                            echo "Unknown Header: '$matches[1]' = '$matches[2]'\n";
                            $lastHeader = $matches[1];
                    }
                }
                else if ( preg_match( '(^   (.*)$)', $line, $matches ) > 0 )
                {
                    $request['server'][$lastHeader] .= ' ' . $matches[1];
                }
                else
                {
                    $mode = 'read_request_body';
                }
                break;
            case 'read_request_body':
                if ( $line !== '' && $line !== '>>Response'  )
                {
                    $request['body'] .= $line . "\n";
                }
                else
                {
                    $mode = 'start_response';
                }
                break;
            case 'start_response':
                if ( $line === '' )
                {
                    $mode = 'read_response_head';
                }
                break;
            case 'read_blank_before_response':
                $mode = 'read_response_head';
                break; 
            case 'read_response_head':
                if ( preg_match( '(^(\S+)\s+([0-9]+)\s+(.*)$)', $line, $matches ) < 1 )
                {
                    var_dump( $request );
                    throw new RuntimeException( "Could not match '$mode' on $no '$line' of file '$testDataFile'." );
                }
                $response['code'] = $matches[2];
                $response['name'] = $matches[3];
                $mode = 'read_blank_before_response_headers';
            case 'read_blank_before_response_headers':
                $mode = 'read_response_headers';
                break; 
            case 'read_response_headers':
                if ( preg_match( '(^(\S+):\s+(.+)$)', $line, $matches ) > 0 )
                {
                    $response['headers'][$matches[1]] = ( $matches[2] === 'xxxx' ? 1234 : $matches[2] );
                }
                else
                {
                    $mode = 'read_response_body';
                }
                break;
            case 'read_response_body':
                $response['body'] .= $line . "\n";
        }
    }

    $fileInfo = pathinfo( $testDataFile );

    if ( file_exists( ( $testSetBase  = "{$fileInfo['dirname']}/{$fileInfo['filename']}" ) ) === false )
    {
        mkdir( $testSetBase );
    }
    if ( file_exists( ( $requestBase  = "{$testSetBase}/request" ) ) === false )
    {
        mkdir( $requestBase );
    }
    if ( file_exists( ( $responseBase = "{$testSetBase}/response" ) ) === false )
    {
        mkdir( $responseBase );
    }

    $templates = array();
    $templates['php'] = <<<EOT
<?php

return %s;

?>
EOT;
    
    file_put_contents(
        "{$requestBase}/server.php",
        sprintf( $templates['php'], var_export( $request['server'], true ) )
    );
    file_put_contents(
        "{$requestBase}/body.xml",
        $request['body']
    );
    file_put_contents(
        "{$requestBase}/uri.txt",
        ( $request['uri'] === '' 
              ? ( 'http://' . ( isset( $request['server']['HTTP_HOST'] ) ? $request['server']['HTTP_HOST'] : 'localhost' ) . ( isset( $request['server']['REQUEST_URI'] ) ? $request['server']['REQUEST_URI'] : '/' ) )
              : $request['uri'] )
    );

    file_put_contents(
        "{$responseBase}/headers.php",
        sprintf( $templates['php'], var_export( $response['headers'], true ) )
    );
    file_put_contents(
        "{$responseBase}/body.xml",
        $response['body']
    );
    file_put_contents(
        "{$responseBase}/code.txt",
        $response['code'] 
    );
    file_put_contents(
        "{$responseBase}/name.txt",
        $response['name'] 
    );
    
    $response = array(
        'headers' => array(),
        'body'    => '',
        'code'    => null,
        'name'    => '',
    );

}

?>

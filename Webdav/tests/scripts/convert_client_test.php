<?php

if ( count( $argv ) < 2 )
{
    die( "Missing input directory.\n" );
}

if ( count( $argv ) < 3 )
{
    die( "Missing output file.\n" );
}

$inDir = $argv[1];
$outFile = $argv[2];

if ( !is_dir( $inDir ) || !is_readable( $inDir ) )
{
    die( "Could not open '$inDir'." );
}

$fileMap = array(
    '_request_body.xml'     => array( 'request', 'body' ),
    '_request_server.php'   => array( 'request', 'server' ),
    '_response_body.xml'    => array( 'response', 'body' ),
    '_response_headers.php' => array( 'response', 'headers' ),
    '_response_status.txt'  => array( 'response', 'status' ),
);

$data = array();

foreach ( glob( "$inDir/*_request_body.xml" ) as $file )
{
    $fileName = basename( $file );
    if ( !preg_match( '(^(([0-9]+)_[A-Z]+)_.*$)', $fileName, $matches ) )
    {
        die( "Could not parse file name '$fileName'.\n" );
    }

    $prefix = $matches[1];
    $no     = (int) $matches[2];

    $data[$no] = array();
    
    foreach ( $fileMap as $fileTemplate => $keys )
    {
        if ( !file_exists( ( $dataFile = "{$inDir}/{$prefix}{$fileTemplate}" ) ) )
        {
            die( "Missing data file '$dataFile'\n" );
        }
        switch ( pathinfo( $dataFile, PATHINFO_EXTENSION ) )
        {
            case 'php':
                $inData = require $dataFile;
                break;
            case 'xml':
            case 'txt':
                $inData = file_get_contents( $dataFile );
                break;
            default:
                die( "Unknwon file extension for file '$dataFile'.\n" );
        }
        
        $data[$no][$keys[0]][$keys[1]] = $inData;
    }
}

file_put_contents(
    $outFile,
    "<?php\n\nreturn " . var_export( $data, true ) . ";\n\n?>"
);

?>

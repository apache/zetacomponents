<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package Http
 */

/**
 * ezcHttpPassthrough contains static functions to pass a file through PHP
 * to the client through HTTP.
 *
 * Normally, the calling script should immediately exit after using this class.
 *
 * Usage example:
 * <code>
 * ezcHttpPassthrough::run( '/path/to/file.txt', 'text/plain', 'helloWorld.txt' );
 * </code>
 *
 * @package Http
 * @throws ezcHttpException::FILE_NOT_FOUND IF the file does not exist.
 */
class ezcHttpPassthrough
{
    /**
     * Application identifier.
     *
     * Used in X-Powered-By: header.
     * @see setApplication()
     * @var string
     */
    private static $application;

    /**
     * Set application identifier to expose in HTTP headers.
     *
     * The identifier is used in the X-Powered-By header and
     * usually simply contains the name of the application sending
     * the data.
     *
     * @param string $app Application identifier.
     * @see $application
     */
    public static function setApplication( $app )
    {
        self::$application = $app;
    }

    /**
     * Pass the file $filePath with the mime type $mimeType through
     * HTTP to the browser.
     *
     * This method generates and sends the appropriate headers before
     * the file contents are sent. If the file should be stored with a
     * different name than the file on disk set $originalFileName with
     * the real name of the file.
     *
     * Applications should not send any further data through the connection after
     * calling this method.
     *
     * @param string $filePath
     * @param string $mimeType
     * @param string $originalFileName
     */
    public static function run( $filePath, $mimeType, $originalFileName = false )
    {
        if ( !$filePath || !file_exists( $filePath ) )
        {
            throw new ezcHttpException( ezcHttpException::FILE_NOT_FOUND );
        }

        $fileSize = filesize( $filePath );
        $contentLength = $fileSize;
        $fileOffset = false;
        $fileLength = false;
        if ( isset( $_SERVER['HTTP_RANGE'] ) )
        {
            $httpRange = trim( $_SERVER['HTTP_RANGE'] );
            if ( preg_match( "/^bytes=([0-9]+)-$/", $httpRange, $matches ) )
            {
                $fileOffset = $matches[1];
                header( "Content-Range: bytes $fileOffset-" . $fileSize - 1 . "/$fileSize" );
                header( "HTTP/1.1 206 Partial content" );
                $contentLength -= $fileOffset;
            }
        }

        header( "Pragma: " );
        header( "Cache-Control: " );
        /* Set cache time out to 10 minutes, this should be good enough to work around an IE bug */
        header( "Expires: ". gmdate('D, d M Y H:i:s', time() + 600) . 'GMT');
        header( "Content-Length: $contentLength" );
        header( "Content-Type: $mimeType" );
        if ( isset( self::$application ) )
            header( 'X-Powered-By: ' . self::$application );
        header( "Content-disposition: attachment; filename=\"$originalFileName\"" );
        header( "Content-Transfer-Encoding: binary" );
        header( "Accept-Ranges: bytes" );

        $fh = fopen( $filePath, "rb" );
        if ( $fileOffset )
            fseek( $fh, $fileOffset );

        fpassthru( $fh );
        fflush( $fh );
        fclose( $fh );
    }
}
?>
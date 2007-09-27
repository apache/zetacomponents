<?php

class ezcWebdavRfcPathFactory extends ezcWebdavBasicPathFactory
{
    public static function parsePath( $requestPath, $base = null )
    {
        $path = parse_url( $requestPath, PHP_URL_PATH );
        if ( substr( $path, -1, 1 ) === '/' )
        {
            $path  = substr( $path, 0, -1 );
        }
        return $path;
    }
}

?>

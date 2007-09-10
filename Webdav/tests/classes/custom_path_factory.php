<?php

/**
 * Just a stupid test class
 */
class myTestPathFactory extends ezcWebdavPathFactory
{
    public static function parsePath( $requestPath, $base = null )
    {
        return 'This is only a test.';
    }
}
?>

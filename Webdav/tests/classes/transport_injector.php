<?php

class ezcWebdavTestTransportInjector
{
    public static $requestBody;

    public static $responseStatus;

    public static $responseHeaders;

    public static $responseBody;

    public static function reset()
    {
        self::$requestBody     = null;
        self::$responseStatus  = null;
        self::$responseHeaders = null;
        self::$responseBody    = null;
    }
}

?>

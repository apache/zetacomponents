<?php
/**
 * Class that encapsulates a semi-parsed HTTP request by using PHP's super
 * globals to extract information.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcHttpRawRequest extends ezcMvcRawRequest
{
    /**
     * Contains an array of headers, where the key is the original HTTP
     * header name, and the value extracted from the $_SERVER superglobal.
     *
     * @var array(string=>string);
     */
    public $headers;

    /**
     * Contains the request body (read from php://stdin if available).
     *
     * @var string
     */
    public $body;
}
?>

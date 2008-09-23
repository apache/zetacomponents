<?php
/**
 * Struct which holds the request authentication parameters.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResponse extends ezcBaseStruct
{    
    /**
     * Server headers.
     * 
     * @var array
     */
    public $headers;

    /**
     * Server body.
     * 
     * @var string
     */
    public $body;

    /**
     * Constructs a new ezcMvcResponse with headers $headers and body $body.
     * 
     * @param array $headers Client headers.
     * @param string $bodye Client body.
     * @return void
     */
    public function __construct( $headers, $body )
    {
        $this->headers = $headers;
        $this->body    = $body;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array
     * @return ezcMvcResponse
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcResponse( $array['headers'], $array['body'] );
    }
}
?>

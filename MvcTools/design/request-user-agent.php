<?php
/**
 * Struct which defines a request user agent.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRequestUserAgent extends ezcBaseStruct
{
    /**
     * Request user agent.
     *
     * @var string
     */
    public $agent;

    /**
     * Constructs a new ezcMvcRequestUserAgent with user agent $agent.
     * 
     * @param mixed $agent Request user agent.
     * @return void
     */
    public function __construct( $agent )
    {
        $this->agent = $agent;
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
     * @return ezcMvcRequestUserAgent
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRequestUserAgent( $array['agent'] );
    }
}
?>

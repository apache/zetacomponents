<?php
/**
 *  Struct which defines client-acceptable contents.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRequestAccept extends ezcBaseStruct
{
    /**
     * Request content types.
     *
     * @var array
     */
    public $types;

    /**
     * Acceptable charsets.
     *
     * @var array
     */
    public $charsets;

    /**
     * Request languages.
     *
     * @var array
     */
    public $languages;

    /**
     * Acceptable encodings.
     * 
     * @var array
     */
    public $encodings;

    /**
     * Constructs a new ezcMvcRequestAccept with request type $type, charset $charset, language $language, and compressions $compressions.
     * 
     * @param array $type Request content type.
     * @param array $charset Request charset.
     * @param array $language Request language.
     * @param array $compressions Request compressions.
     * @return void
     */
    public function __construct( $type, $charset, $language, $compressions )
    {
        $this->type = $type;
        $this->charset = $charset;
        $this->language = $language;
        $this->compressions = $compressions;
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
     * @return ezcMvcRequestAccept
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRequestAccept( $array['type'], $array['charset'], $array['language'], $array['compressions'] );
    }
}
?>

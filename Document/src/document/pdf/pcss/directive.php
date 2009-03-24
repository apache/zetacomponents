<?php
/**
 * File containing the ezcDocumentPdfCssDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Pdf CSS layout directive.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentPdfCssDirective extends ezcBaseStruct
{
    /**
     * Directive address
     * 
     * @var array
     */
    public $address;

    /**
     * Array of formatting rules
     * 
     * @var array
     */
    public $formats;

    /**
     * Regular expression compiled from directive address
     * 
     * @var string
     */
    protected $regularExpression = null;

    /**
     * Construct directive from address and formats 
     * 
     * @param string $address 
     * @param array $formats 
     * @return void
     */
    public function __construct( array $address, array $formats )
    {
        $this->address = $address;
        $this->formats = $formats;
    }

    /**
     * Compile regular expression
     *
     * Compiles the address of this style directive into a PCRE regular
     * expression, which then can be matched against location IDs.
     * 
     * @return void
     */
    protected function compileRegularExpression()
    {
        $regexp  = '(';

        $address = $this->address;
        while ( $token = array_shift( $address ) )
        {
            // Check for direct descendants
            if ( strpos( $token, '>' ) === 0 )
            {
                $token   = preg_replace( '(>[\\t\\x20]+)', '', $token );
                $regexp .= '/' . preg_quote( $token );
            }
            else
            {
                $regexp .= '.*/' . preg_quote( $token );
            }

            // Append optional class and ID restrictions
            $restrictions = array();
            while ( isset( $address[0] ) &&
                    ( ( strpos( $address[0], '.' ) === 0 ) ||
                      ( strpos( $address[0], '#' ) === 0 ) ) )
            {
                $token = array_shift( $address );
                $restrictions[$token[0]] = substr( $token, 1 );
            }

            // Append optional restrictions
            if ( isset( $restrictions['.'] ) )
            {
                $regexp .= '\\.' . preg_quote( $restrictions['.'] );
            }

            // Append optional restrictions
            if ( isset( $restrictions['#'] ) )
            {
                $regexp .= '[^/]*#' . preg_quote( $restrictions['#'] );
            }

            $regexp .= '[^/]*';
        }

        $regexp .= ')S';
        $this->regularExpression = $regexp;
    }

    /**
     * Return a PCRE regular expression for directive address
     *
     * Return a PCRE regular expression representing the address of
     * the directive, intended to match location IDs representing
     * the docbook element nodes.
     *
     * @param string $locationId 
     * @return string
     */
    public function getRegularExpression()
    {
        if ( $this->regularExpression === null )
        {
            $this->compileRegularExpression();
        }

        return $this->regularExpression;
    }

    /**
     * Recreate directive from var_export
     * 
     * @param array $properties 
     * @return ezcDocumentPdfCssDirective
     */
    public static function __set_state( $properties )
    {
        return new ezcDocumentPdfCssDirective(
            $properties['address'],
            $properties['formats']
        );
    }
}


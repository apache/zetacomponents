<?php
/**
 * File containing the ezcDocumentOdtStyleConverterManager class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Manager for ezcDocumentOdtStyleConverter instances.
 *
 * An instance of this class is used to handle style converters. It uses the 
 * {@link ArrayAccess} interface to access style converters by the name of 
 * the CSS style attribute they handle.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtStyleConverterManager extends ArrayObject
{
    /**
     * Creates a new style converter manager.
     */
    public function __construct()
    {
        parent::__construct( array(), ArrayObject::STD_PROP_LIST );
        $this->init();
    }

    /**
     * Initialize default converters.
     */
    protected function init()
    {
        $this['text-decoration']  = new ezcDocumentOdtTextDecorationStyleConverter();
        $this['font-size']        = new ezcDocumentOdtFontSizeStyleConverter();
        $this['font-name']        = ( $font = new ezcDocumentOdtFontStyleConverter() );
        $this['font-weight']      = $font;
        $this['color']            = ( $color = new ezcDocumentOdtColorStyleConverter() );
        $this['background-color'] = $color;
        $this['text-align']       = ( $default = new ezcDocumentOdtDefaultStyleConverter() );
        $this['widows']           = $default;
        $this['orphans']          = $default;
        $this['text-indent']      = $default;
        $this['margin']           = new ezcDocumentOdtMarginStyleConverter();
        $this['border']           = new ezcDocumentOdtBorderStyleConverter();
    }

    /**
     * Sets a new style converter.
     *
     * The key must be the CSS style property this converter handles, the 
     * $value must be the style converter itself.
     * 
     * @param string $key 
     * @param ezcDocumentOdtStyleConverter $value 
     */
    public function offsetSet( $key, $value )
    {
        if ( !is_string( $key ) )
        {
            throw new ezcBaseValueException( 'key', $key, 'string' );
        }
        if ( !is_object( $value ) || !( $value instanceof ezcDocumentOdtStyleConverter ) )
        {
            throw new ezcBaseValueException(
                'value',
                $key,
                'ezcDocumentOdtStyleConverter'
            );
        }
        parent::offsetSet( $key, $value );
    }

    /**
     * Appending elements is not allowed.
     *
     * Appending a style is not allowed. Please use the array access with the 
     * style name to set a new style converter.
     * 
     * @param mixed $value 
     * @throws RuntimeException
     */
    public function append( $value )
    {
        throw new RuntimeException( 'Appending values is not allowed.' );
    }
}

?>

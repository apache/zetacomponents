<?php
/**
 * File containing ezcDocumentBBCodeOptions class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the basic options for the ezcDocumentBBCode.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentBBCodeOptions extends ezcDocumentOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['tags'] = new ArrayObject();
        $this->properties['tags']['b'] = new ezcDocumentBBCodeEmphasisPlugin();
        $this->properties['tags']['i'] = new ezcDocumentBBCodeEmphasisPlugin();
        $this->properties['tags']['u'] = new ezcDocumentBBCodeEmphasisPlugin();

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            /*
            case 'tokenizer':
                if ( !is_object( $value ) ||
                     !( $value instanceof ezcDocumentBBCodeTokenizer ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'instanceof ezcDocumentBBCodeTokenizer' );
                }

                $this->properties[$name] = $value;
                break;
            */

            default:
                parent::__set( $name, $value );
        }
    }
}

?>

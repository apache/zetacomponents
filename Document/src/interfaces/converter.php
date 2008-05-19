<?php

/**
 * File containing the ezcDocument class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * A base class for document type converters.
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcDocumentConverter
{
    /**
     * XML document base options.
     * 
     * @var ezcDocumentXmlBaseOptions
     */
    protected $options;

    /**
     * Construct new document
     *
     * @param ezcDocumentConverterBaseOptions $options
     */
    public function __construct( ezcDocumentConverterBaseOptions $options = null )
    {
        $this->options = ( $options === null ?
            new ezcDocumentConverterBaseOptions() :
            $options );
    }

    /**
     * Convert documents between two formats
     * 
     * Convert documents of the given type to the requested type.
     *
     * @param ezcDocument $doc 
     * @return ezcDocument
     */
    abstract public function convert( $doc );

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name does not exist
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'options':
                return $this->options;
        }

        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name does not exist
     * @throws ezcBaseValueException
     *         if $value is not accepted for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'options':
                if ( !( $value instanceof ezcDocumentConverterOptions ) )
                {
                    throw new ezcBaseValueException( 'options', $value, 'instanceof ezcDocumentConverterOptions' );
                }

                $this->options = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param string $name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        switch ( $name )
        {
            case 'options':
                return true;

            default:
                return false;
        }
    }
}

?>

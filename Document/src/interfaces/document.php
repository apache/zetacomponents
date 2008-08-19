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
 * A base class for document type handlers.
 * 
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocument
{
    /**
     * XML document base options.
     * 
     * @var ezcDocumentXmlOptions
     */
    protected $options;

    /**
     * Current document path, where the operations happen.
     * 
     * @var string
     */
    protected $path = './';

    /**
     * Construct new document
     *
     * @param ezcDocumentOptions $options
     */
    public function __construct( ezcDocumentOptions $options = null )
    {
        $this->options = ( $options === null ?
            new ezcDocumentOptions() :
            $options );
    }   

    /**
     * Create document from input string
     * 
     * Create a document of the current type handler class and parse it into a
     * usable internal structure.
     *
     * @param string $string 
     * @return void
     */
    abstract public function loadString( $string );

    /**
     * Create document from file
     *
     * Create a document of the current type handler class and parse it into a
     * usable internal structure. The default implementation just calls
     * loadString(), but you may want to provide an optimized implementation.
     * 
     * @param string $file 
     * @return void
     */
    public function loadFile( $file )
    {
        if ( !file_exists( $file ) || !is_readable( $file ) )
        {
            throw new ezcBaseFileNotFoundException( $file );
        }

        $this->path = realpath( dirname( $file ) ) . '/';
        $this->loadString(
            file_get_contents( $file )
        );
    }

    /**
     * Return document compiled to the docbook format
     * 
     * The internal document structure is compiled to the docbook format and
     * the resulting docbook document is returned.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     *
     * @return ezcDocumentDocbook
     */
    abstract public function getAsDocbook();

    /**
     * Create document from docbook document
     *
     * A document of the docbook format is provided and the internal document
     * structure should be created out of this.
     *
     * This method is required for all formats to have one central format, so
     * that each format can be compiled into each other format using docbook as
     * an intermediate format.
     *
     * You may of course just call an existing converter for this conversion.
     * 
     * @param ezcDocumentDocbook $document 
     * @return void
     */
    abstract public function createFromDocbook( ezcDocumentDocbook $document );

    /**
     * Return document as string
     * 
     * Serialize the document to a string an return it.
     *
     * @return string
     */
    abstract public function save();

    /**
     * Magic wrapper for save()
     * 
     * @ignore
     * @return string
     */
    public function __toString()
    {
        return $this->save();
    }

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
                if ( !( $value instanceof ezcDocumentOptions ) )
                {
                    throw new ezcBaseValueException( 'options', $value, 'instanceof ezcDocumentOptions' );
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

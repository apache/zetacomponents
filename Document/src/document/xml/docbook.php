<?php
/**
 * File containing the ezcDocumentDocbook class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The document handler for the docbook document markup.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbook extends ezcDocumentXmlBase
{
    /**
     * Construct document xml base.
     * 
     * @ignore
     * @param ezcDocumentDocbookOptions $options
     * @return void
     */
    public function __construct( ezcDocumentDocbookOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentDocbookOptions() :
            $options );
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
    public function getAsDocbook()
    {
        return $this;
    }

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
    public function createFromDocbook( ezcDocumentDocbook $document )
    {
        $this->document = $document->getDomDocument();
    }

    /**
     * Return document as string
     * 
     * Serialize the document to a string an return it.
     *
     * @return string
     */
    public function save()
    {
        return $this->document->saveXml();
    }

    /**
     * Validate the input file
     *
     * Validate the input file against the specification of the current
     * document format.
     *
     * Returns true, if the validation succeded, and an array with
     * ezcDocumentValidationError objects otherwise.
     * 
     * @param string $file
     * @return mixed
     */
    public function validateFile( $file )
    {
        // @TODO: We need a working docbook schema, which we can embed, until
        // then we just can't really validate docbook files.
        return false;
    }

    /**
     * Validate the input string
     *
     * Validate the input string against the specification of the current
     * document format.
     *
     * Returns true, if the validation succeded, and an array with
     * ezcDocumentValidationError objects otherwise.
     * 
     * @param string $string
     * @return mixed
     */
    public function validateString( $string )
    {
        // @TODO: We need a working docbook schema, which we can embed, until
        // then we just can't really validate docbook files.
        return false;
    }
}

?>

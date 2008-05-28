<?php
/**
 * File containing the ezcDocumentEzp3Xml class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The document handler for the eZ Publish 3 XML document markup.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentEzp3Xml extends ezcDocumentXmlBase
{
    /**
     * Construct document xml base.
     * 
     * @ignore
     * @param ezcDocumentEzp3XmlOptions $options
     * @return void
     */
    public function __construct( ezcDocumentEzp3XmlOptions $options = null )
    {
        parent::__construct( $options === null ?
            new ezcDocumentEzp3XmlOptions() :
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
        // @TODO: Implement
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
        // @TODO: Implement
    }
}

?>

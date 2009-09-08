<?php
/**
 * File containing the ezcDocumentOdtTableFilter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Filter for ODT <text:p> elements.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentOdtElementTableFilter extends ezcDocumentOdtElementBaseFilter
{
    /**
     * Mapping for table elements. 
     *
     * Maps ODT table tags to a method in this class to convert them.
     * 
     * @var array
     */
    protected $methodMap = array(
        'table'             => 'convertTable',
        'table-column'      => 'convertColumn',
        'table-header-rows' => 'convertHeader',
        'table-row'         => 'convertRow',
        'table-cell'        => 'convertCell',
        // covered-table-cell is left alone, will be ignored
    );

    /**
     * Filter a single element
     *
     * @param ezcDocumentOdtDomElement $element
     * @return void
     */
    public function filterElement( DOMElement $element )
    {
        $method = $this->methodMap[$element->localName];
        $this->$method( $element );
    }

    /**
     * Check if filter handles the current element
     *
     * Returns a boolean value, indicating weather this filter can handle
     * the current element.
     *
     * @param ezcDocumentOdtDomElement $element
     * @return void
     */
    public function handles( DOMElement $element )
    {
        return ( $element->namespaceURI === ezcDocumentOdt::NS_ODT_TABLE
            && isset( $this->methodMap[$element->localName] ) );
    }

    /**
     * Converts the <table:table/> element.
     * 
     * @param ezcDocumentOdtDomElement $element 
     * @return void
     */
    protected function convertTable( ezcDocumentOdtDomElement $element )
    {
        $element->setProperty( 'type', 'table' );
        if ( $element->hasAttributeNS( ezcDocumentOdt::NS_ODT_TABLE, 'name' ) )
        {
            $caption = $element->insertBefore(
                new ezcDocumentOdtDomElement(
                    'caption',
                    $element->getAttributeNS( ezcDocumentOdt::NS_ODT_TABLE, 'name' ),
                    ezcDocumentOdt::NS_EZC
                ),
                $element->firstChild
            );
            $caption->setProperty( 'type', 'caption' );
        }
        $this->aggregateRows( $element );
    }

    protected function aggregateRows( ezcDocumentOdtDomElement $element )
    {
        // @TODO: Does ODT support multiple heads? Does DocBook support that?
        $body = $element->ownerDocument->createElementNS( ezcDocumentOdt::NS_EZC, 'tbody' );
        $body->setProperty( 'type', 'tbody' );

        // Aggregate all <table:table-row/> into a <tbody/> element.
        for ( $i = ( $element->childNodes->length - 1 ); $i >= 0; --$i )
        {
            $child = $element->childNodes->item( $i );

            // Collect table row and remove it
            if ( $child->nodeType === XML_ELEMENT_NODE
                 && $child->localName === 'table-row'
               )
            {
                $body->insertBefore(
                    $child->cloneNode( true ),
                    $body->firstChild
                );
                $element->removeChild( $child );
            }
            // Break is something else is found
            // @TODO: What about multiple head rows?
            else if ( $child->nodeType === XML_ELEMENT_NODE )
            {
                break;
            }
        }

        $element->appendChild( $body );
    }

    /**
     * Convert the <table:table-column/> element.
     * 
     * @param ezcDocumentOdtDomElement $element 
     * @return void
     */
    protected function convertColumn( ezcDocumentOdtDomElement $element )
    {
        // @TODO: Not supported by our DocBook sub-set. Should we?
        // $element->setProperty( 'type', 'col' );
    }

    /**
     * Convert the <table:table-header-rows/> element.
     * 
     * @param ezcDocumentOdtDomElement $element 
     * @return void
     */
    protected function convertHeader( ezcDocumentOdtDomElement $element )
    {
        $element->setProperty( 'type', 'thead' );
    }

    /**
     * Convert the <table:table-row/> element.
     * 
     * @param ezcDocumentOdtDomElement $element 
     * @return void
     */
    protected function convertRow( ezcDocumentOdtDomElement $element )
    {
        $element->setProperty( 'type', 'tr' );
    }

    /**
     * Convert the <table:table-cell/> element.
     * 
     * @param ezcDocumentOdtDomElement $element 
     * @return void
     */
    protected function convertCell( ezcDocumentOdtDomElement $element )
    {
        $element->setProperty( 'type', 'td' );
        $attrs = $element->getProperty( 'attributes' );
        if ( !is_array( $attrs ) )
        {
            $attrs = array();
        }

        if ( $element->hasAttributeNS(
             ezcDocumentOdt::NS_ODT_TABLE,
             'number-columns-spanned'
         ) )
        {
            $attrs['colspan'] = $element->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TABLE,
                'number-columns-spanned'
            );
        }

        if ( $element->hasAttributeNS(
             ezcDocumentOdt::NS_ODT_TABLE,
             'number-rows-spanned'
         ) )
        {
            $attrs['rowspan'] = $element->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TABLE,
                'number-rows-spanned'
            );
        }

        $element->setProperty( 'attributes', $attrs );
    }
}

?>

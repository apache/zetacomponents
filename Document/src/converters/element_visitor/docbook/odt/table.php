<?php
/**
 * File containing the ezcDocumentDocbookToOdtTableHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visit tables.
 *
 * Visit docbook tables and transform them into ODT tables.
 *
 * @TODO: Old DocBook table style should be supported.
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtTableHandler extends ezcDocumentDocbookToOdtBaseHandler
{
    /**
     * Maps table element to handling methods in this class.
     * 
     * @var array(string=>string)
     */
    protected $methodMap = array(
        'table'   => 'handleTable',
        'caption' => 'handleCaption',
        'thead'   => 'handleThead',
        'tbody'   => 'handleTbody',
        'tr'      => 'handleTr',
        'td'      => 'handleTd',
    );

    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     *
     * @param ezcDocumentElementVisitorConverter $converter
     * @param DOMElement $node
     * @param mixed $root
     * @return mixed
     */
    public function handle( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        if ( !isset( $this->methodMap[$node->localName] ) )
        {
            // @TODO: Correct exception
            throw new RuntimeException( "Table element {$node->localName} cannot be handled." );
        }

        $method = $this->methodMap[$node->localName];

        return $this->$method( $converter, $node, $root );
    }

    /**
     * Handles the table base element.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function handleTable( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        // @TODO: Determine style.
        $table = $root->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table'
        );
        $root->appendChild( $table );

        $converter->visitChildren( $node, $table );
        return $root;
    }

    /**
     * Handles table captions.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function handleCaption( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        $root->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table:name',
            $node->nodeValue
        );
        return $root;
    }

    /**
     * Handles table headers.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function handleThead( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        $tableHeaderRows = $root->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table-header-rows'
        );
        $root->appendChild( $tableHeaderRows );

        $converter->visitChildren( $node, $tableHeaderRows );
        return $root;
    }

    /**
     * Handles table bodies.
     *
     * Simply ignores the tag, since ODT does not have table body marked up.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function handleTbody( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        // Skip
        $converter->visitChildren( $node, $root );
        return $root;
    }

    /**
     * Handles table rows.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function handleTr( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        $tableRow = $root->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table-row'
        );
        $root->appendChild( $tableRow );

        $converter->visitChildren( $node, $tableRow );
        return $root;
    }

    /**
     * Handles table cells.
     * 
     * @param ezcDocumentElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    protected function handleTd( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
    {
        // @TODO: Determine style
        $tableCell = $root->ownerDocument->createElementNS(
            ezcDocumentOdt::NS_ODT_TABLE,
            'table-cell'
        );
        // @TODO: Can we make this configurable somehow?
        $tableCell->setAttributeNS(
            ezcDocumentOdt::NS_ODT_OFFICE,
            'office:value-type',
            'string'
        );
        $root->appendChild( $tableCell );

        $converter->visitChildren( $node, $tableCell );
        return $root;
    }
}

?>

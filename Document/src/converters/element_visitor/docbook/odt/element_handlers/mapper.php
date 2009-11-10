<?php
/**
 * File containing the ezcDocumentDocbookToOdtMappingHandler class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Simple mapping handler
 *
 * Performs a simple 1 to 1 mapping between DocBook elements and ODT elements.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentDocbookToOdtMappingHandler extends ezcDocumentDocbookToOdtBaseHandler
{
    /**
     * Mapping of element names.
     *
     * Mapping from DocBook to ODT elements. The local name of a DocBook 
     * element is used as the key to look up a corresponding element in ODT.  
     * Since ODT utilizes multiple namespaces, an array of namespace and local 
     * name for the target element is returned.
     *
     * @var array(string=>array(string))
     */
    protected $mapping = array(
        'listitem' => array( ezcDocumentOdt::NS_ODT_TEXT, 'text:list-item' )
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
        if ( !isset( $this->mapping[$node->localName] ) )
        {
            // @TODO: Throw proper exception
            throw new RuntimeException( "Unhandled DocBook element '{$node->localName}'." );
        }
        $targetElementData = $this->mapping[$node->localName];

        $targetElement = $root->appendChild(
            $root->ownerDocument->createElementNS(
                $targetElementData[0],
                $targetElementData[1]
            )
        );

        $this->styler->applyStyles( $node, $targetElement );

        $converter->visitChildren( $node, $targetElement );
        return $root;
    }
}

?>

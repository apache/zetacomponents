<?php
/**
 * File containing the base class von visitor handler classes
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Abstract base handler class for conversions done by converters extending
 * from ezcDocumentDocbookElementVisitorConverter.
 * 
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocumentElementVisitorHandler
{
    /**
     * Handle a node
     *
     * Handle / transform a given node, and return the result of the
     * conversion.
     * 
     * @param ezcDocumentDocbookElementVisitorConverter $converter 
     * @param DOMElement $node 
     * @param mixed $root 
     * @return mixed
     */
    abstract public function handle( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root );
}

?>

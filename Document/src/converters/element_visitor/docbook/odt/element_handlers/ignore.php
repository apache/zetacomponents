<?php
/**
 * File containing the recursing handler ignoring the current nodes markup
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Handler for elements, which are safe to be ignored.
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentDocbookToOdtIgnoreHandler extends ezcDocumentDocbookToOdtBaseHandler
{
    /**
     * If child elements should also be ignored. 
     * 
     * @var bool
     */
    protected $deepIgnore;

    /**
     * Creates a new ignore handler.
     *
     * If $deepIgnore is set to true, child elements of the ignored element 
     * will also not be visited. 
     * 
     * @param ezcDocumentOdtStyler $styler
     * @param bool $deepIgnore 
     */
    public function __construct( ezcDocumentOdtStyler $styler, $deepIgnore = false )
    {
        parent::__construct( $styler );
        $this->deepIgnore = $deepIgnore;
    }

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
        if ( !$this->deepIgnore )
        {
            return $converter->visitChildren( $node, $root );
        }
        return $root;
    }
}

?>

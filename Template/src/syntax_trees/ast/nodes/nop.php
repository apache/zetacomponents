<?php
/**
 * File containing the ezcTemplateNopAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a PHP code which does nothing.
 * This is typically used to null out existing PHP code.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateNopAstNode extends ezcTemplateAstNode
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns an empty array.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array();
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "nop";
    }

    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
    }

}
?>

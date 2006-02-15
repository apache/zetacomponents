<?php
/**
 * File containing the ezcTemplateDynamicStringAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a dynamic PHP string.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateDynamicStringAstNode extends ezcTemplateParameterizedAstNode
{
    /**
     * Initialize dynamic string with parameter constraints.
     */
    public function __construct()
    {
        parent::__construct( 0, false );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "dynamic-string";
    }

    /**
     * @inheritdocs
     * Calls visitDynamicStringControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitDynamicString( $this );
    }
}
?>

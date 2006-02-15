<?php
/**
 * File containing the ezcTemplateDefaultAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a default case control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateDefaultAstNode extends ezcTemplateCaseAstNode
{
    /**
     * The body element for the default case.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateBodyAstNode $body = null )
    {
        ezcTemplateStatementAstNode::__construct();
        $this->body = $body;
    }

    /**
     * Returns the body element for this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->body );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "default";
    }

    /**
     * @inheritdocs
     * Calls visitDefaultControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->body === null )
        {
            throw new Exception( "Case control element does not have the \$body variable set." );
        }
        $visitor->visitDefaultControl( $this );
    }
}
?>

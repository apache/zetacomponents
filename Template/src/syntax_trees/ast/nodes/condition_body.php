<?php
/**
 * File containing the ezcTemplateConditionBodyAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a condition entry in an if construct.
 * The entry consists of a condition and a body.
 *
 * The condition entry is used to represent an if, else or elseif construct.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateConditionBodyAstNode extends ezcTemplateAstNode
{
    /**
     * The expression holding the condition element.
     * @var ezcTemplateAstNode
     */
    public $condition;

    /**
     * The body element.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with condition and body statement.
     */
    public function __construct( ezcTemplateAstNode $condition = null, ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->condition = $condition;
        $this->body = $body;
    }

    /**
     * Returns the condition and body for this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->condition, $this->body );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "condition body";
    }

    /**
     * @inheritdocs
     * Calls visitConditionBody() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->body === null )
        {
            throw new Exception( "If-condition control element does not have the \$body variable set." );
        }
        $visitor->visitConditionBody( $this );
    }
}
?>

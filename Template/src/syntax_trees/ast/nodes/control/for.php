<?php
/**
 * File containing the ezcTemplateForAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a for control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateForAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will return set the initial values
     * for iterator variables.
     * Set this to null to skip initial elements.
     * @var ezcTemplateAstNode
     */
    public $initial;

    /**
     * The expression which has the condition for each iteration.
     * @var ezcTemplateAstNode
     */
    public $condition;

    /**
     * The expression which, when evaluated, will increase the iterator
     * variables.
     * Set this to null to skip iteration.
     * @var ezcTemplateAstNode
     */
    public $iteration;

    /**
     * The body element for the for control structure.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $initial = null, ezcTemplateAstNode $condition = null, ezcTemplateAstNode $iteration = null,
                                 ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->initial = $initial;
        $this->condition = $condition;
        $this->iteration = $iteration;
        $this->body = $body;
    }

    /**
     * Returns the initial, condition and iteration elements as well as the
     * body element for this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->initial, $this->condition, $this->iteration, $this->body );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "for";
    }

    /**
     * @inheritdocs
     * Calls visitForControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->condition === null )
        {
            throw new Exception( "For control element does not have the \$condition variable set." );
        }
        if ( $this->body === null )
        {
            throw new Exception( "For control element does not have the \$body variable set." );
        }
        $visitor->visitForControl( $this );
    }
}
?>

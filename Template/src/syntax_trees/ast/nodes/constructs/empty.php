<?php
/**
 * File containing the ezcTemplateEmptyAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents an empty construct.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateEmptyAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression to output when evaluated.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }

    /**
     * Returns the expression of this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->expression );
    }

    /**
     * Validates the expression against its constraints.
     *
     * @throw Exception if the constraints are not met.
     * @todo Fix exception class
     */
    public function validate()
    {
        if ( $this->expression === null )
        {
            throw new Exception( "Missing expression for class <" . get_class( $this ) . ">." );
        }
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "empty";
    }

    /**
     * @inheritdocs
     * Calls visitEmptyControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->expression === null )
        {
            throw new Exception( "Empty construct element does not have the \$expression variable set." );
        }
        $visitor->visitEmptyControl( $this );
    }
}
?>

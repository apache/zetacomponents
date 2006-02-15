<?php
/**
 * File containing the ezcTemplateWhileAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a while control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateWhileAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which makes up the condition and body of the while
     * statement.
     * @var ezcTemplateConditionBodyAstNode
     */
    public $conditionBody;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateConditionBodyAstNode $conditionBody = null )
    {
        parent::__construct();
        $this->conditionBody = $conditionBody;
    }

    /**
     * Returns the condition element for this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->conditionBody );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "while";
    }

    /**
     * @inheritdocs
     * Calls visitWhileControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->conditionBody === null )
        {
            throw new Exception( "While control element does not have the \$conditionBody variable set." );
        }
        $visitor->visitWhileControl( $this );
    }
}
?>

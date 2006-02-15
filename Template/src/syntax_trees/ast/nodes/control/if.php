<?php
/**
 * File containing the ezcTemplateIfAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents an if control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateIfAstNode extends ezcTemplateStatementAstNode
{
    /**
     * Array of expressions which represents the conditions for the if, elseif
     * and else entries. The first entry is used for the if, the last for the
     * else and the one in between for elseif.
     * @var array(ezcTemplateConditionBodyAstNode)
     */
    public $conditions;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateConditionBodyAstNode $conditionBody = null )
    {
        parent::__construct();
        if ( $conditionBody !== null )
        {
            $this->conditions[] = $conditionBody;
        }
    }

    /**
     * Appends the condition object to the current list of conditions.
     *
     * @param ezcTemplateConditionBodyAstNode $condition Append an extra condition block.
     */
    public function appendCondition( ezcTemplateConditionBodyAstNode $condition )
    {
        $this->conditions[] = $condition;
    }

    /**
     * Returns the last condition object from the body.
     * If there are no conditions in the body it returns null.
     *
     * @return ezcTemplateConditionBodyAstNode
     */
    public function getLastCondition()
    {
        $count = count( $this->conditions );
        if ( $count === 0 )
        {
            return null;
        }
        return $this->conditions[$count - 1];
    }

    /**
     * Returns the conditions of this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return $this->conditions;
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "if/else/elseif";
    }

    /**
     * @inheritdocs
     * Calls visitIfControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( count( $this->conditions ) == 0 )
        {
            throw new Exception( "If structure must have at least 1 condition but this has none" );
        }
        $visitor->visitIfControl( $this );
    }
}
?>

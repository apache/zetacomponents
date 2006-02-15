<?php
/**
 * File containing the ezcTemplateSwitchAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a switch control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateSwitchAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression which, when evaluated, will be used for matching
     * against the cases.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Array of case statements which are placed inside switch body.
     * @var array(ezcTemplateCaseAstNode)
     */
    public $cases;

    /**
     * Is set to true if the case list contains a default entry.
     * @var bool
     */
    public $hasDefaultCase;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $expression = null, Array $cases = null )
    {
        parent::__construct();
        $this->expression = $expression;
        $this->cases = array();
        $this->hasDefaultCase = false;

        if ( $cases !== null )
        {
            $hasDefault = false;
            foreach ( $cases as $case )
            {
                if ( !$case instanceof ezcTemplateCaseAstNode )
                {
                    throw new Exception( "Array in case list \$cases must consist of object which are instances of ezcTemplateCaseAstNode, not <" . get_class( $case ) . ">." );
                }
                if ( $case instanceof ezcTemplateDefaultAstNode )
                {
                    if ( $hasDefault )
                    {
                        throw new Exception( "The default case is already present as a case entry." );
                    }
                    $hasDefault = true;
                }
                $this->cases[] = $case;
            }
            $this->hasDefaultCase = $hasDefault;
        }
    }

    /**
     * Returns the expression and the case entries of this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array_merge( array( $this->expression ), $this->cases );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "switch";
    }

    /**
     * @inheritdocs
     * Calls visitSwitchControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->expression === null )
        {
            throw new Exception( "Switch control element does not have the \$expression variable set." );
        }
        if ( count( $this->cases ) === 0 )
        {
            throw new Exception( "Switch control element does not have any case entries set, need at least one." );
        }
        $visitor->visitSwitchControl( $this );
    }
}
?>

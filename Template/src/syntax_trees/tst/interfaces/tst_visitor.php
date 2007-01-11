<?php
/**
 * File containing the ezcTemplateTstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Visitor interface for the TST nodes.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
interface ezcTemplateTstNodeVisitor
{
    /**
     * @return void
     */
    public function visitBlockTstNode( ezcTemplateBlockTstNode $node ); 


    /**
     * @return void
     */
    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $node );


    /**
     * @return void
     */
    public function visitProgramTstNode( ezcTemplateProgramTstNode $node );


    /**
     * @return void
     */
    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $node );


    /**
     * @return void
     */
    public function visitEmptyBlockTstNode( ezcTemplateEmptyBlockTstNode $node );


    /**
     * @return void
     */
    public function visitParenthesisTstNode( ezcTemplateParenthesisTstNode $node );


    /**
     * @return void
     */
    public function visitOutputBlockTstNode( ezcTemplateOutputBlockTstNode $node );


    /**
     * @return void
     */
    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $node );


    /**
     * @return void
     */
    public function visitLiteralTstNode( ezcTemplateLiteralTstNode $node );


    /**
     * @return void
     */
    public function visitVariableTstNode( ezcTemplateVariableTstNode $node );


    /**
     * @return void
     */
    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $node );


    /**
     * @return void
     */
    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $node );


    /**
     * @return void
     */
    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $node );


    /**
     * @return void
     */
    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $node );


    /**
     * @return void
     */
    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $node );


    /**
     * @return void
     */
    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $node );


    /**
     * @return void
     */
    public function visitDelimiterTstNode( ezcTemplateDelimiterTstNode $node );


    /**
     * @return void
     */
    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $node );


    /**
     * @return void
     */
    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $node );


    /**
     * @return void
     */
    public function visitConditionBodyTstNode( ezcTemplateConditionBodyTstNode $node );


    /**
     * @return void
     */
    public function visitLoopTstNode( ezcTemplateLoopTstNode $node );


    /**
     * @return void
     */
    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $node );


    /**
     * @return void
     */
    public function visitDynamicBlockTstNode( ezcTemplateDynamicBlockTstNode $node );


    /**
     * @return void
     */
    public function visitCacheTstNode( ezcTemplateCacheTstNode $node);

    /**
     * @return void
     */
    public function visitDeclarationTstNode( ezcTemplateDeclarationTstNode $node );

    /**
     * @return void
     */
    public function visitCycleControlTstNode( ezcTemplateCycleControlTstNode $node );

    /**
     * @return void
     */
    public function visitIncludeTstNode( ezcTemplateIncludeTstNode $node );

    /**
     * @return void
     */
    public function visitReturnTstNode( ezcTemplateReturnTstNode $node );

    /**
     * @return void
     */
    public function visitSwitchTstNode( ezcTemplateSwitchTstNode $node );

    /**
     * @return void
     */
    public function visitCaseTstNode( ezcTemplateCaseTstNode $node );

    /**
     * @return void
     */
    public function visitLiteralArrayTstNode( ezcTemplateLiteralArrayTstNode $node );

    /**
     * @return void
     */
    public function visitArrayRangeOperatorTstNode( ezcTemplateArrayRangeOperatorTstNode $node );


}
?>

<?php
/**
 * File containing the ezcTemplateTstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
     * visitBlockTstNode
     *
     * @param ezcTemplateBlockTstNode $node
     * @return void
     */
    public function visitBlockTstNode( ezcTemplateBlockTstNode $node ); 


    /**
     * visitCustomBlockTstNode
     *
     * @param  ezcTemplateCustomBlockTstNode $node
     * @return void
     */
    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $node );


    /**
     * visitProgramTstNode
     *
     * @param ezcTemplateProgramTstNode $node
     * @return void
     */
    public function visitProgramTstNode( ezcTemplateProgramTstNode $node );


    /**
     * visitLiteralBlockTstNode
     *
     * @param ezcTemplateLiteralBlockTstNode $node
     * @return void
     */
    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $node );


    /**
     * visitEmptyBlockTstNode
     *
     * @param ezcTemplateEmptyBlockTstNode $node
     * @return void
     */
    public function visitEmptyBlockTstNode( ezcTemplateEmptyBlockTstNode $node );


    /**
     * visitParenthesisTstNode
     *
     * @param ezcTemplateParenthesisTstNode $node
     * @return void
     */
    public function visitParenthesisTstNode( ezcTemplateParenthesisTstNode $node );


    /**
     * visitOutputBlockTstNode
     *
     * @param ezcTemplateOutputBlockTstNode $node
     * @return void
     */
    public function visitOutputBlockTstNode( ezcTemplateOutputBlockTstNode $node );


    /**
     * visitModifyingBlockTstNode
     *
     * @param ezcTemplateModifyingBlockTstNode $node
     * @return void
     */
    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $node );


    /**
     * visitLiteralTstNode
     *
     * @param ezcTemplateLiteralTstNode $node
     * @return void
     */
    public function visitLiteralTstNode( ezcTemplateLiteralTstNode $node );


    /**
     * visitVariableTstNode
     *
     * @param ezcTemplateVariableTstNode $node
     * @return void
     */
    public function visitVariableTstNode( ezcTemplateVariableTstNode $node );


    /**
     * visitTextBlockTstNode
     *
     * @param ezcTemplateTextBlockTstNode $node
     * @return void
     */
    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $node );


    /**
     * visitFunctionCallTstNode
     *
     * @param ezcTemplateFunctionCallTstNode $node
     * @return void
     */
    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $node );


    /**
     * visitDocCommentTstNode
     *
     * @param ezcTemplateDocCommentTstNode $node
     * @return void
     */
    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $node );


    /**
     * visitBlockCommentTstNode
     *
     * @param ezcTemplateBlockCommentTstNode $node
     * @return void
     */
    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $node );


    /**
     * visitEolCommentTstNode
     *
     * @param ezcTemplateEolCommentTstNode $node
     * @return void
     */
    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $node );


    /**
     * visitForeachLoopTstNode
     *
     * @param ezcTemplateForeachLoopTstNode $node
     * @return void
     */
    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $node );


    /**
     * visitDelimiterTstNode
     *
     * @param ezcTemplateDelimiterTstNode $node
     * @return void
     */
    public function visitDelimiterTstNode( ezcTemplateDelimiterTstNode $node );


    /**
     * visitWhileLoopTstNode
     *
     * @param ezcTemplateWhileLoopTstNode $node
     * @return void
     */
    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $node );


    /**
     * visitIfConditionTstNode
     *
     * @param ezcTemplateIfConditionTstNode $node
     * @return void
     */
    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $node );


    /**
     * visitConditionBodyTstNode
     *
     * @param ezcTemplateConditionBodyTstNode $node
     * @return void
     */
    public function visitConditionBodyTstNode( ezcTemplateConditionBodyTstNode $node );


    /**
     * visitLoopTstNode
     *
     * @param ezcTemplateLoopTstNode $node
     * @return void
     */
    public function visitLoopTstNode( ezcTemplateLoopTstNode $node );


    /**
     * visitPropertyFetchOperatorTstNode
     *
     * @param ezcTemplatePropertyFetchOperatorTstNode $node
     * @return void
     */
    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $node );


    /**
     * visitArrayFetchOperatorTstNode
     *
     * @param ezcTemplateArrayFetchOperatorTstNode $node
     * @return void
     */
    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $node );


    /**
     * visitPlusOperatorTstNode
     *
     * @param ezcTemplatePlusOperatorTstNode $node
     * @return void
     */
    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $node );


    /**
     * visitMinusOperatorTstNode
     *
     * @param ezcTemplateMinusOperatorTstNode $node
     * @return void
     */
    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $node );


    /**
     * visitConcatOperatorTstNode
     *
     * @param ezcTemplateConcatOperatorTstNode $node
     * @return void
     */
    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $node );


    /**
     * visitMultiplicationOperatorTstNode
     *
     * @param ezcTemplateMultiplicationOperatorTstNode $node
     * @return void
     */
    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $node );


    /**
     * visitDivisionOperatorTstNode
     *
     * @param ezcTemplateDivisionOperatorTstNode $node
     * @return void
     */
    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $node );


    /**
     * visitModuloOperatorTstNode
     *
     * @param ezcTemplateModuloOperatorTstNode $node
     * @return void
     */
    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $node );


    /**
     * visitEqualOperatorTstNode
     *
     * @param ezcTemplateEqualOperatorTstNode $node
     * @return void
     */
    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $node );


    /**
     * visitNotEqualOperatorTstNode
     *
     * @param ezcTemplateNotEqualOperatorTstNode $node
     * @return void
     */
    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $node );


    /**
     * visitIdenticalOperatorTstNode
     *
     * @param ezcTemplateIdenticalOperatorTstNode $node
     * @return void
     */
    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $node );


    /**
     * visitNotIdenticalOperatorTstNode
     *
     * @param ezcTemplateNotIdenticalOperatorTstNode $node
     * @return void
     */
    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $node );


    /**
     * visitLessThanOperatorTstNode
     *
     * @param ezcTemplateLessThanOperatorTstNode $node
     * @return void
     */
    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $node );


    /**
     * visitGreaterThanOperatorTstNode
     *
     * @param ezcTemplateGreaterThanOperatorTstNode $node
     * @return void
     */
    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $node );


    /**
     * visitLessEqualOperatorTstNode
     *
     * @param ezcTemplateLessEqualOperatorTstNode $node
     * @return void
     */
    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $node );


    /**
     * visitGreaterEqualOperatorTstNode
     *
     * @param ezcTemplateGreaterEqualOperatorTstNode $node
     * @return void
     */
    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $node );


    /**
     * visitLogicalAndOperatorTstNode
     *
     * @param ezcTemplateLogicalAndOperatorTstNode $node
     * @return void
     */
    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $node );


    /**
     * visitLogicalOrOperatorTstNode
     *
     * @param ezcTemplateLogicalOrOperatorTstNode $node
     * @return void
     */
    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $node );


    /**
     * visitAssignmentOperatorTstNode
     *
     * @param ezcTemplateAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $node );


    /**
     * visitPlusAssignmentOperatorTstNode
     *
     * @param ezcTemplatePlusAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $node );


    /**
     * visitMinusAssignmentOperatorTstNode
     *
     * @param ezcTemplateMinusAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $node );


    /**
     * visitMultiplicationAssignmentOperatorTstNode
     *
     * @param ezcTemplateMultiplicationAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $node );


    /**
     * visitDivisionAssignmentOperatorTstNode
     *
     * @param ezcTemplateDivisionAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $node );


    /**
     * visitConcatAssignmentOperatorTstNode
     *
     * @param ezcTemplateConcatAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $node );


    /**
     * visitModuloAssignmentOperatorTstNode
     *
     * @param ezcTemplateModuloAssignmentOperatorTstNode $node
     * @return void
     */
    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $node );


    /**
     * visitPreIncrementOperatorTstNode
     *
     * @param ezcTemplatePreIncrementOperatorTstNode $node
     * @return void
     */
    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $node );


    /**
     * visitPreDecrementOperatorTstNode
     *
     * @param ezcTemplatePreDecrementOperatorTstNode $node
     * @return void
     */
    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $node );


    /**
     * visitPostIncrementOperatorTstNode
     *
     * @param ezcTemplatePostIncrementOperatorTstNode $node
     * @return void
     */
    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $node );


    /**
     * visitPostDecrementOperatorTstNode
     *
     * @param ezcTemplatePostDecrementOperatorTstNode $node
     * @return void
     */
    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $node );


    /**
     * visitNegateOperatorTstNode
     *
     * @param ezcTemplateNegateOperatorTstNode $node
     * @return void
     */
    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $node );


    /**
     * visitLogicalNegateOperatorTstNode
     *
     * @param ezcTemplateLogicalNegateOperatorTstNode $node
     * @return void
     */
    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $node );


    /**
     * visitDynamicBlockTstNode
     *
     * @param ezcTemplateDynamicBlockTstNode $node
     * @return void
     */
    public function visitDynamicBlockTstNode( ezcTemplateDynamicBlockTstNode $node );


    /**
     * visitCacheTstNode
     *
     * @param ezcTemplateCacheTstNode $node
     * @return void
     */
    public function visitCacheTstNode( ezcTemplateCacheTstNode $node);

    /**
     * visitDeclarationTstNode
     *
     * @param ezcTemplateDeclarationTstNode $node
     * @return void
     */
    public function visitDeclarationTstNode( ezcTemplateDeclarationTstNode $node );

    /**
     * visitCycleControlTstNode
     *
     * @param ezcTemplateCycleControlTstNode $node
     * @return void
     */
    public function visitCycleControlTstNode( ezcTemplateCycleControlTstNode $node );

    /**
     * visitIncludeTstNode
     *
     * @param ezcTemplateIncludeTstNode $node
     * @return void
     */
    public function visitIncludeTstNode( ezcTemplateIncludeTstNode $node );

    /**
     * visitReturnTstNode
     *
     * @param ezcTemplateReturnTstNode $node
     * @return void
     */
    public function visitReturnTstNode( ezcTemplateReturnTstNode $node );

    /**
     * visitSwitchTstNode
     *
     * @param ezcTemplateSwitchTstNode $node
     * @return void
     */
    public function visitSwitchTstNode( ezcTemplateSwitchTstNode $node );

    /**
     * visitCaseTstNode
     *
     * @param ezcTemplateCaseTstNode $node
     * @return void
     */
    public function visitCaseTstNode( ezcTemplateCaseTstNode $node );

    /**
     * visitLiteralArrayTstNode
     *
     * @param ezcTemplateLiteralArrayTstNode $node
     * @return void
     */
    public function visitLiteralArrayTstNode( ezcTemplateLiteralArrayTstNode $node );

    /**
     * visitArrayRangeOperatorTstNode
     *
     * @param ezcTemplateArrayRangeOperatorTstNode $node
     * @return void
     */
    public function visitArrayRangeOperatorTstNode( ezcTemplateArrayRangeOperatorTstNode $node );


}
?>

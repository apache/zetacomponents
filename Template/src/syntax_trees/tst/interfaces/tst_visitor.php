<?php
/**
 * File containing the ezcTemplateTstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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

    public function visitBlockTstNode( ezcTemplateBlockTstNode $node ); 


    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $node );


    public function visitProgramTstNode( ezcTemplateProgramTstNode $node );


    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $node );


    public function visitEmptyBlockTstNode( ezcTemplateEmptyBlockTstNode $node );


    public function visitParenthesisTstNode( ezcTemplateParenthesisTstNode $node );


    public function visitOutputBlockTstNode( ezcTemplateOutputBlockTstNode $node );


    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $node );


    public function visitLiteralTstNode( ezcTemplateLiteralTstNode $node );


    public function visitVariableTstNode( ezcTemplateVariableTstNode $node );


    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $node );


    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $node );


    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $node );


    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $node );


    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $node );


    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $node );


    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $node );


    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $node );


    public function visitLoopTstNode( ezcTemplateLoopTstNode $node );


    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $node );


    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $node );


    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $node );


    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $node );


    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $node );


    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $node );


    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $node );


    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $node );


    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $node );


    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $node );


    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $node );


    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $node );


    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $node );


    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $node );


    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $node );


    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $node );


    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $node );


    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $node );


    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $node );


    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $node );


    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $node );


    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $node );


    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $node );


    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $node );


    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $node );


    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $node );


    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $node );


    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $node );


    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $node );


    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $node );


    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $node );


    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $node );


    public function visitDynamicBlockTstNode( ezcTemplateDynamicBlockTstNode $node );



}
?>

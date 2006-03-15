<?php
/**
 * File containing the ezcTemplateTstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Visitor interface for the TST nodes.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
interface ezcTemplateTstNodeVisitor
{

    public function visitBlockTstNode( ezcTemplateBlockTstNode $type ); 


    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $type );


    public function visitProgramTstNode( ezcTemplateProgramTstNode $type );


    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $type );


    public function visitExpressionBlockTstNode( ezcTemplateExpressionBlockTstNode $type );


    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $type );


    public function visitTypeTstNode( ezcTemplateTypeTstNode $type );


    public function visitIntegerTstNode( ezcTemplateIntegerTstNode $type );


    public function visitVariableTstNode( ezcTemplateVariableTstNode $type );


    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $type );


    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $type );


    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $type );


    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $type );


    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $type );


    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $type );


    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $type );


    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $type );


    public function visitLoopTstNode( ezcTemplateLoopTstNode $type );


    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $type );


    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $type );


    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $type );


    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $type );


    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $type );


    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $type );


    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $type );


    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $type );


    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $type );


    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $type );


    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $type );


    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $type );


    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $type );


    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $type );


    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $type );


    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $type );


    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $type );


    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $type );


    public function visitConditionalOperatorTstNode( ezcTemplateConditionalOperatorTstNode $type );


    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $type );


    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $type );


    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $type );


    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $type );


    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $type );


    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $type );


    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $type );


    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $type );


    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $type );


    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $type );


    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $type );


    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $type );


    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $type );


    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $type );



}
?>

<?php
/**
 * File containing the ezcTemplateTstTreeOutput class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Iterates the TST tree and outputs the result as text.
 *
 * Implements the ezcTemplateTstNodeVisitor interface for visiting the nodes
 * and generating the appropriate ast nodes for them.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTstTreeOutput extends ezcTemplateTreeOutput implements ezcTemplateTstNodeVisitor
{
    public function __construct()
    {
        parent::__construct( 'ezcTemplateTstNode' );
    }

    /**
     * Convenience function for outputting a node.
     * Instantiates the ezcTemplateTstTreeOutput class and calls accept() on
     * $node, the resulting text is returned.
     *
     * @param ezcTemplateAstNode $node
     * @return string
     */
    static public function output( ezcTemplateTstNode $node )
    {
        $treeOutput = new ezcTemplateTstTreeOutput();
        $node->accept( $treeOutput );
        return $treeOutput->text . "\n";
    }

    public function visitProgramTstNode( ezcTemplateProgramTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitCustomBlockTstNode( ezcTemplateCustomBlockTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLiteralBlockTstNode( ezcTemplateLiteralBlockTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitOutputBlockTstNode( ezcTemplateOutputBlockTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitModifyingBlockTstNode( ezcTemplateModifyingBlockTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLiteralTstNode( ezcTemplateLiteralTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitIntegerTstNode( ezcTemplateIntegerTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitVariableTstNode( ezcTemplateVariableTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitTextBlockTstNode( ezcTemplateTextBlockTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitFunctionCallTstNode( ezcTemplateFunctionCallTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitDocCommentTstNode( ezcTemplateDocCommentTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitForeachLoopTstNode( ezcTemplateForeachLoopTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitWhileLoopTstNode( ezcTemplateWhileLoopTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitIfConditionTstNode( ezcTemplateIfConditionTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLoopTstNode( ezcTemplateLoopTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPropertyFetchOperatorTstNode( ezcTemplatePropertyFetchOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitArrayFetchOperatorTstNode( ezcTemplateArrayFetchOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPlusOperatorTstNode( ezcTemplatePlusOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitMinusOperatorTstNode( ezcTemplateMinusOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitConcatOperatorTstNode( ezcTemplateConcatOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitMultiplicationOperatorTstNode( ezcTemplateMultiplicationOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitDivisionOperatorTstNode( ezcTemplateDivisionOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitModuloOperatorTstNode( ezcTemplateModuloOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitEqualOperatorTstNode( ezcTemplateEqualOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitNotEqualOperatorTstNode( ezcTemplateNotEqualOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitIdenticalOperatorTstNode( ezcTemplateIdenticalOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitNotIdenticalOperatorTstNode( ezcTemplateNotIdenticalOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLessThanOperatorTstNode( ezcTemplateLessThanOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitGreaterThanOperatorTstNode( ezcTemplateGreaterThanOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLessEqualOperatorTstNode( ezcTemplateLessEqualOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitGreaterEqualOperatorTstNode( ezcTemplateGreaterEqualOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLogicalAndOperatorTstNode( ezcTemplateLogicalAndOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLogicalOrOperatorTstNode( ezcTemplateLogicalOrOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitAssignmentOperatorTstNode( ezcTemplateAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPlusAssignmentOperatorTstNode( ezcTemplatePlusAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitMinusAssignmentOperatorTstNode( ezcTemplateMinusAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitMultiplicationAssignmentOperatorTstNode( ezcTemplateMultiplicationAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitDivisionAssignmentOperatorTstNode( ezcTemplateDivisionAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitConcatAssignmentOperatorTstNode( ezcTemplateConcatAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitModuloAssignmentOperatorTstNode( ezcTemplateModuloAssignmentOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPreIncrementOperatorTstNode( ezcTemplatePreIncrementOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPreDecrementOperatorTstNode( ezcTemplatePreDecrementOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPostIncrementOperatorTstNode( ezcTemplatePostIncrementOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitPostDecrementOperatorTstNode( ezcTemplatePostDecrementOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitNegateOperatorTstNode( ezcTemplateNegateOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitLogicalNegateOperatorTstNode( ezcTemplateLogicalNegateOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitInstanceOfOperatorTstNode( ezcTemplateInstanceOfOperatorTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitBlockCommentTstNode( ezcTemplateBlockCommentTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitEolCommentTstNode( ezcTemplateEolCommentTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    public function visitBlockTstNode( ezcTemplateBlockTstNode $node )
    {
        $this->text .= $this->outputNode( $node );
    }

    /**
     * Extracts the name of the node and returns it as a string.
     * The name is taken from the class name by removing ezcTemplate and TstNode.
     *
     * @param Object $node The node to examine.
     * @return string
     */
    protected function extractNodeName( $node )
    {
        return preg_replace( "#^ezcTemplate(.+)TstNode#", '$1', get_class( $node ) );
    }

    /**
     * Extracts position data from the specified node and set in the out parameters.
     * The position is taken from ezcTemplateTstNode::startCursor and ezcTemplateTstNode::endCursor.
     *
     * @param Object $node The node to examine.
     * @param int    $startLine   The starting line for the node.
     * @param int    $startColumn The starting column for the node.
     * @param int    $endLine     The starting line for the node.
     * @param int    $endColumn   The starting column for the node.
     * @return bool True if the extraction was succesful.
     */
    protected function extractNodePosition( $node, &$startLine, &$startColumn, &$endLine, &$endColumn )
    {
        $startLine   = $node->startCursor->line;
        $startColumn = $node->startCursor->column;
        $endLine     = $node->endCursor->line;
        $endColumn   = $node->endCursor->column;
        return true;
    }

    /**
     * Extracts the properties from the specified node and returns it as an array.
     * The properties are taken from ezcTemplateTstNode::treeProperties.
     *
     * @param Object $node The node to examine.
     * @return array(name=>value)
     */
    protected function extractNodeProperties( $node )
    {
        return $node->treeProperties;
    }
}
?>

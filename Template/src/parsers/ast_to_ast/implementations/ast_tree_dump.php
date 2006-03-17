<?php
/**
 * File containing the ezcTemplateAstNodeGenerator class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Generator of PHP code.
 *
 * Implements the ezcTemplateBasicAstNodeVisitor interface for visiting code elements
 * and generating code for them.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateAstTreeDump extends ezcTemplateTreeDump implements ezcTemplateAstNodeVisitor
{
    /**
     * @param string $path File path for the file which should be generated.
     * @param int $indentation The default indentation to use when increasing it.
     */
    public function __construct()
    {
        parent::__construct( 'ezcTemplateAstNode' );
    }

    /**
     * Convenience function for dumping a node.
     * Instantiates the ezcTemplateAstTreeDump class and calls accept() on
     * $node, the resulting text is returned.
     *
     * @param ezcTemplateAstNode $node
     * @return string
     */
    static public function dump( ezcTemplateAstNode $node )
    {
        $treeDump = new ezcTemplateAstTreeDump();
        $node->accept( $treeDump );
        return $treeDump->text . "\n";
    }

    public function visitLiteralAstNode( ezcTemplateLiteralAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitConstantAstNode( ezcTemplateConstantAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitEolCommentAstNode( ezcTemplateEolCommentAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitBlockCommentAstNode( ezcTemplateBlockCommentAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitVariableAstNode( ezcTemplateVariableAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitDynamicVariableAstNode( ezcTemplateDynamicVariableAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitDynamicStringAstNode( ezcTemplateDynamicStringAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitArrayFetchOperatorAstNode( ezcTemplateArrayFetchOperatorAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitUnaryOperatorAstNode( ezcTemplateOperatorAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitBinaryOperatorAstNode( ezcTemplateOperatorAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitFunctionCallAstNode( ezcTemplateFunctionCallAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitDynamicFunctionCallAstNode( ezcTemplateDynamicFunctionCallAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitBodyAstNode( ezcTemplateBodyAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitGenericStatementAstNode( ezcTemplateGenericStatementAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitIfAstNode( ezcTemplateIfAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitWhileAstNode( ezcTemplateWhileAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitDoWhileAstNode( ezcTemplateDoWhileAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitForAstNode( ezcTemplateForAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitForeachAstNode( ezcTemplateForeachAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitBreakAstNode( ezcTemplateBreakAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitContinueAstNode( ezcTemplateContinueAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitReturnAstNode( ezcTemplateReturnAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitRequireAstNode( ezcTemplateRequireAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitRequireOnceAstNode( ezcTemplateRequireOnceAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitIncludeAstNode( ezcTemplateIncludeAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitIncludeOnceAstNode( ezcTemplateIncludeOnceAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitSwitchAstNode( ezcTemplateSwitchAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitCaseAstNode( ezcTemplateCaseAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitDefaultAstNode( ezcTemplateDefaultAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitConditionBodyAstNode( ezcTemplateConditionBodyAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitTryAstNode( ezcTemplateTryAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitCatchAstNode( ezcTemplateCatchAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitEchoAstNode( ezcTemplateEchoAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitPrintAstNode( ezcTemplatePrintAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitIssetAstNode( ezcTemplateIssetAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitUnsetAstNode( ezcTemplateUnsetAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitEmptyAstNode( ezcTemplateEmptyAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitParenthesisAstNode( ezcTemplateParenthesisAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitCurlyBracesAstNode( ezcTemplateCurlyBracesAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    public function visitTypeCastAstNode( ezcTemplateTypeCastAstNode $node )
    {
        $this->text .= $this->dumpNode( $node );
    }

    /**
     * Extracts the name of the node and returns it as a string.
     * The name is taken from the class name by removing ezcTemplate and AstNode.
     *
     * @param Object $node The node to examine.
     * @return string
     */
    protected function extractNodeName( $node )
    {
        return preg_replace( "#^ezcTemplate(.+)AstNode#", '$1', get_class( $node ) );
    }

    /**
     * Extracts position data from the specified node and set in the out parameters.
     * Ast nodes has no position so it always returns false.
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
        return false;
    }

    /**
     * Extracts the properties from the specified node and returns it as an array.
     * The properties are taken using get_object_vars().
     *
     * @param Object $node The node to examine.
     * @return array(name=>value)
     */
    protected function extractNodeProperties( $node )
    {
        return get_object_vars( $node );
    }
}
?>

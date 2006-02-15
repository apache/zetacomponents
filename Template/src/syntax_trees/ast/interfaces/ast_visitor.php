<?php
/**
 * File containing the ezcTemplateBasicAstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Visitor interface for the basic code elements.
 *
 * This interface defines the methods for all the generic code elements.
 *
 * The acyclic visitor pattern is used as the basis of this interface. Combining
 * this interface with other specialized ones allows the implementation of classes
 * which can visit all kinds of code elements.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
interface ezcTemplateAstNodeVisitor// extends ezcTemplateAstNodeVisitor
{
    /**
     * Visits a code element containing a builtin constant type.
     *
     * @param ezcTemplateTypeAstNode $type The code element containing the constant value.
     */
    public function visitType( ezcTemplateTypeAstNode $type );

    /**
     * Visits a code element containing an constant.
     *
     * @param ezcTemplateConstantAstNode $type The code element containing the constant value.
     */
    public function visitConstant( ezcTemplateConstantAstNode $type );

    /**
     * Visits a code element containing an variable.
     *
     * @param ezcTemplateVariableAstNode $var The code element containing the variable value.
     */
    public function visitVariable( ezcTemplateVariableAstNode $var );

    /**
     * Visits a code element containing a dynamic variable.
     *
     * @param ezcTemplateDynamicVariableAstNode $var The code element containing the dynamic variable value.
     */
    public function visitDynamicVariable( ezcTemplateDynamicVariableAstNode $var );

    /**
     * Visits a code element containing a dynamic string.
     *
     * @param ezcTemplateDynamicStringAstNode $string The code element containing the dynamic string.
     */
    public function visitDynamicString( ezcTemplateDynamicStringAstNode $type );

    /**
     * Visits a code element containing an array fetch operator type.
     *
     * @param ezcTemplateArrayFetchOperatorAstNode $operator The code element containing the array fetch operator.
     */
    public function visitArrayFetchOperator( ezcTemplateArrayFetchOperatorAstNode $operator );

    /**
     * Visits a code element containing a unary operator type.
     * Unary operators take one parameter and consist of a symbol.
     *
     * @param ezcTemplateOperatorAstNode $operator The code element containing the operator with parameter.
     */
    public function visitUnaryOperator( ezcTemplateOperatorAstNode $operator );

    /**
     * Visits a code element containing a binary operator type.
     * Binary operators take two parameters and consist of a symbol.
     *
     * @param ezcTemplateOperatorAstNode $operator The code element containing the operator with parameters.
     */
    public function visitBinaryOperator( ezcTemplateOperatorAstNode $operator );

    /**
     * Visits a code element containing a function call.
     * Function call consist of a function name and arguments.
     *
     * @param ezcTemplateFunctionCallAstNode $fcall The code element containing the function call with arguments.
     */
    public function visitFunctionCall( ezcTemplateFunctionCallAstNode $fcall );

    /**
     * Visits a code element containing a body of statements.
     * A body consists of a series of statements in sequence.
     *
     * @param ezcTemplateBodyAstNode $body The code element containing the body.
     */
    public function visitBody( ezcTemplateBodyAstNode $body );

    /**
     * Visits a code element containing a generic statement.
     * A generic statement contains a generic code expression but is terminated with a semi-colon.
     *
     * @param ezcTemplateGenericStatementAstNode $statement The code element containing the generic statement.
     */
    public function visitGenericStatement( ezcTemplateGenericStatementAstNode $statement );

    /**
     * Visits a code element containing if control structures.
     *
     * @param ezcTemplateIfAstNode $if The code element containing the if control structure.
     */
    public function visitIfControl( ezcTemplateIfAstNode $if );

    /**
     * Visits a code element containing while control structures.
     *
     * @param ezcTemplateWhileAstNode $while The code element containing the while control structure.
     */
    public function visitWhileControl( ezcTemplateWhileAstNode $while );

    /**
     * Visits a code element containing do/while control structures.
     *
     * @param ezcTemplateDoWhileAstNode $while The code element containing the do/while control structure.
     */
    public function visitDoWhileControl( ezcTemplateDoWhileAstNode $while );

    /**
     * Visits a code element containing conditions for if control structures.
     *
     * @param ezcTemplateConditionBodyAstNode $cond The code element containing the if condition.
     */
    public function visitConditionBody( ezcTemplateConditionBodyAstNode $cond );

    /**
     * Visits a code element containing for control structures.
     *
     * @param ezcTemplateForAstNode $for The code element containing the for control structure.
     */
    public function visitForControl( ezcTemplateForAstNode $for );

    /**
     * Visits a code element containing foreach control structures.
     *
     * @param ezcTemplateForeachAstNode $foreach The code element containing the foreach control structure.
     */
    public function visitForeachControl( ezcTemplateForeachAstNode $foreach );

    /**
     * Visits a code element containing break control structures.
     *
     * @param ezcTemplateBreakAstNode $break The code element containing the break control structure.
     */
    public function visitBreakControl( ezcTemplateBreakAstNode $break );

    /**
     * Visits a code element containing continue control structures.
     *
     * @param ezcTemplateContinueAstNode $continue The code element containing the continue control structure.
     */
    public function visitContinueControl( ezcTemplateContinueAstNode $continue );

    /**
     * Visits a code element containing switch control structures.
     *
     * @param ezcTemplateSwitchAstNode $switch The code element containing the switch control structure.
     */
    public function visitSwitchControl( ezcTemplateSwitchAstNode $switch );

    /**
     * Visits a code element containing case control structures.
     *
     * @param ezcTemplateCaseAstNode $case The code element containing the case control structure.
     */
    public function visitCaseControl( ezcTemplateCaseAstNode $case );

    /**
     * Visits a code element containing default case control structures.
     *
     * @param ezcTemplateDefaultAstNode $default The code element containing the default case control structure.
     */
    public function visitDefaultControl( ezcTemplateDefaultAstNode $default );

    /**
     * Visits a code element containing return control structures.
     *
     * @param ezcTemplateReturnAstNode $return The code element containing the return control structure.
     */
    public function visitReturnControl( ezcTemplateReturnAstNode $return );

    /**
     * Visits a code element containing require control structures.
     *
     * @param ezcTemplateRequireAstNode $require The code element containing the require control structure.
     */
    public function visitRequireControl( ezcTemplateRequireAstNode $require );

    /**
     * Visits a code element containing require_once control structures.
     *
     * @param ezcTemplateRequireOnceAstNode $require The code element containing the require_once control structure.
     */
    public function visitRequireOnceControl( ezcTemplateRequireOnceAstNode $require );

    /**
     * Visits a code element containing include control structures.
     *
     * @param ezcTemplateIncludeAstNode $include The code element containing the include control structure.
     */
    public function visitIncludeControl( ezcTemplateIncludeAstNode $include );

    /**
     * Visits a code element containing include_once control structures.
     *
     * @param ezcTemplateIncludeOnceAstNode $include The code element containing the include_once control structure.
     */
    public function visitIncludeOnceControl( ezcTemplateIncludeOnceAstNode $include );

    /**
     * Visits a code element containing try control structures.
     *
     * @param ezcTemplateTryAstNode $try The code element containing the try control structure.
     */
    public function visitTryControl( ezcTemplateTryAstNode $try );

    /**
     * Visits a code element containing catch control structures.
     *
     * @param ezcTemplateCatchAstNode $catch The code element containing the catch control structure.
     */
    public function visitCatchControl( ezcTemplateCatchAstNode $catch );

    /**
     * Visits a code element containing echo construct.
     *
     * @param ezcTemplateEchoAstNode $echo The code element containing the echo construct.
     */
    public function visitEchoControl( ezcTemplateEchoAstNode $echo );

    /**
     * Visits a code element containing print construct.
     *
     * @param ezcTemplatePrintAstNode $print The code element containing the print construct.
     */
    public function visitPrintControl( ezcTemplatePrintAstNode $print );

    /**
     * Visits a code element containing isset construct.
     *
     * @param ezcTemplateIssetAstNode $isset The code element containing the isset construct.
     */
    public function visitIssetControl( ezcTemplateIssetAstNode $isset );

    /**
     * Visits a code element containing unset construct.
     *
     * @param ezcTemplateUnsetAstNode $unset The code element containing the unset construct.
     */
    public function visitUnsetControl( ezcTemplateUnsetAstNode $unset );

    /**
     * Visits a code element containing empty construct.
     *
     * @param ezcTemplateEmptyAstNode $empty The code element containing the empty construct.
     */
    public function visitEmptyControl( ezcTemplateEmptyAstNode $empty );
}
?>

<?php
/**
 * File containing the ezcTemplateSourceToTstErrorMessages
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateSourceToTstErrorMessages
{
    // Expected types
    const MSG_EXPECT_ARROW_OR_CLOSE_CURLY_BRACKET = "Expecting the keyword '=>' or closing curly bracket '}'";
    const MSG_EXPECT_AS                         = "Expecting the keyword 'as'.";
    const MSG_EXPECT_CASE_STATEMENT             = "Expecting an case block.";
    const MSG_EXPECT_DELIMITER_INSIDE_FOREACH   = "Delimiter can only be used inside a foreach block.";
    const MSG_EXPECT_EXPRESSION                 = "Expecting an expression.";
    const MSG_EXPECT_EXPRESSION_NOT_IDENTIFIER  = "Expecting an expression, not an identifier. (Braces missing?)";
    const MSG_EXPECT_OPERAND                    = "Expecting an operand.";
    const MSG_EXPECT_LITERAL                    = "Expecting a literal value.";
    const MSG_EXPECT_MODULO                     = "Expecting a modulo";
    const MSG_EXPECT_NON_MODIFYING_OPERAND      = "Expecting an operand without a pre- or post operator.";
    const MSG_EXPECT_VARIABLE                   = "Expecting a variable";

    const MSG_EXPECT_VALUE                      = "Expected two operands that are not an array.";

    // Unexpected types
    const MSG_UNEXPECTED_TOKEN                  = "Unexpected token: %s";
    const MSG_UNEXPECTED_BREAK_OR_CONTINUE      = "Cannot break or continue outside a loop.";

    // Invalid
    const MSG_INVALID_VARIABLE_NAME             = "The variable name is invalid.";
    const MSG_INVALID_OPERATOR_ON_CYCLE         = "This operator cannot be used on a cycle.";
    const MSG_INVALID_IDENTIFIER                = "Invalid identifier";


    //  expected brackets
    const MSG_EXPECT_CURLY_BRACKET_OPEN         = "Expecting an opening curly bracket: '{'";
    const MSG_EXPECT_CURLY_BRACKET_CLOSE        = "Expecting a closing curly bracket: '}'";
    const MSG_EXPECT_ROUND_BRACKET_OPEN         = "Expecting an opening parentheses: '('";
    const MSG_EXPECT_ROUND_BRACKET_CLOSE        = "Expecting a closing parentheses: ')'";

    const MSG_EXPECT_SQUARE_BRACKET_CLOSE        = "Expecting a closing square bracket: ']'";

    const MSG_EXPECT_ROUND_BRACKET_CLOSE_OR_COMMA  = "Expecting a closing parentheses: ')' or a comma ','";

    // Unexpected brackets
    const MSG_UNEXPECTED_SQUARE_BRACKET_OPEN    = "Unexpected opening square bracket '['. Array fetch needs a variable. ( \$variable [ 0 ] )";
    const MSG_UNEXPECTED_ARRAY_APPEND           = "Unexpected array append '[]'. Did you forget an expression between the brackets?";
    const MSG_EXPECT_ARRAY_APPEND_ASSIGNMENT    = "Expecting an assignment '=' after an array append '[]'.";


    const MSG_ASSIGNMENT_NOT_ALLOWED            = "A 'raw' block cannot modify a variable.";

    // Uppercase problems
    const MSG_ARRAY_NOT_LOWERCASE               = "The array identifier must consist of lowercase characters only.";
    const MSG_BOOLEAN_NOT_LOWERCASE             = "Boolean type must use lowercase characters only.";

    // Other
    const MSG_TYPEHINT_FAILURE                  = "The types (array or value) are not correctly used with this operator.";


    const MSG_EXPECT_ARRAY                      = "Expecting an array.";
    const MSG_EXPECT_VALUE_NOT_ARRAY            = "Expecting a value and not an array.";
    const MSG_PARAMETER_EXPECTS_EXPRESSION      = "Parameter %s expects a value.";


    const MSG_DEFAULT_DUPLICATE                 = "Expecting {/switch}. ('default' can be available only once in the switch)";
    const MSG_DEFAULT_LAST                      = "Expecting {/switch}. ('default' is expected to be the last case of the switch.)";

    const MSG_UNKNOWN_BLOCK                     = "Unknown block <%s>.";
    const MSG_UNKNOWN_FUNCTION                  = "Unknown function call: '%s'";
    const MSG_EXPECT_PARAMETER                  = "Function call: '%s' has not enough parameters. Need an additional '%s' parameter.";
    const MSG_TOO_MANY_PARAMETERS               = "Function call: '%s' has too many parameters.";

    const MSG_UNEXPECTED_BLOCK                   = "Unexpected block {%s} at this position. Some blocks can only be used inside other blocks.";

    const MSG_OBJECT_FUNCTION_CALL_NOT_ALLOWED  = "Calling a method from an imported object is not allowed.";

    const MSG_MISSING_CUSTOM_BLOCK_PARAMETER     = "Missing the required custom block parameter <%s>."; 
    const MSG_UNKNOWN_CUSTOM_BLOCK_PARAMETER     = "Unknown custom block parameter <%s>."; 
    const MSG_REASSIGNMENT_CUSTOM_BLOCK_PARAMETER = "The custom block parameter <%s> is already assigned."; 

    // Custom block specific error messages
    const MSG_EXPECT_REQUIRED_OR_OPTIONAL_PARAMETER_DEFINITION_IN_CUSTOM_BLOCK = "The custom block definition specifies the startExpressionName <%s> but this name could not be found in either the optionalParameters or the requiredParameters array.";

    // Inconsistencies with eZ publish 3.
    const LNG_INVALID_NAMESPACE_MARKER          = "The namespace marker (:) was used in template engine in eZ publish 3.x but is no longer allowed.";
    const LNG_INVALID_NAMESPACE_ROOT_MARKER = "The namespace-root marker (#) was used in the template engine of eZ publish 3.x but it's no longer allowed.";



    // Runtime errors
    const RT_IMPORT_VALUE_MISSING               = "The use variable '%s' is not set."; 
    
    


}


?>

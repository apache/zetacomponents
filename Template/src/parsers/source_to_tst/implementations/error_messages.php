<?php


class ezcTemplateSourceToTstErrorMessages
{
    // Expected types
    const MSG_EXPECT_EXPRESSION                 = "Expecting an expression.";
    const MSG_EXPECT_EXPRESSION_NOT_IDENTIFIER  = "Expecting an expression, not an identifier. (Braces missing?)";
    const MSG_EXPECT_OPERAND                    = "Expecting an operand.";
    const MSG_EXPECT_LITERAL                    = "Expecting a literal";
    const MSG_EXPECT_NON_MODIFYING_OPERAND      = "Expecting an operand without a pre- or post operator.";
    const MSG_EXPECT_VARIABLE                   = "Expecting a variable";


    // Unexpected types
    const MSG_UNEXPECTED_TOKEN                  = "Unexpected token: %s";


    //  expected brackets
    const MSG_EXPECT_CURLY_BRACKET_OPEN         = "Expecting an opening curly bracket: '{'";
    const MSG_EXPECT_CURLY_BRACKET_CLOSE        = "Expecting a closing curly bracket: '}'";
    const MSG_EXPECT_ROUND_BRACKET_OPEN         = "Expecting an opening parentheses: '('";
    const MSG_EXPECT_ROUND_BRACKET_CLOSE        = "Expecting a closing parentheses: ')'";

    const MSG_EXPECT_ROUND_BRACKET_CLOSE_OR_COMMA  = "Expecting a closing parentheses: ')' or a comma ','";


    // Unexpected brackets
    const MSG_UNEXPECTED_SQUARE_BRACKET_OPEN    = "Unexpected opening square bracket '['. Array fetch needs a variable. ( \$variable [ 0 ] )";
 

    // Uppercase problems
    const MSG_ARRAY_NOT_LOWERCASE               = "The array identifier must consist of lowercase characters only.";



    const MSG_EXPECT_VALUE_NOT_ARRAY            = "Expecting a value and not an array.";



    // Inconsistencies with eZ publish 3.
    const LNG_INVALID_NAMESPACE_MARKER          = "The namespace marker (:) was used in template engine in eZ publish 3.x but is no longer allowed.";
}


?>

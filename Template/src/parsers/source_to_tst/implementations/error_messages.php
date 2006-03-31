<?php


class ezcTemplateSourceToTstErrorMessages
{
    const MSG_EXPECT_VARIABLE                   = "Expecting a variable";

    const MSG_EXPECT_EXPRESSION                 = "Expecting an expression.";

    const MSG_EXPECT_EXPRESSION_NOT_IDENTIFIER  = "Expecting an expression, not an identifier. (Braces missing?)";
    
    const MSG_EXPECT_OPERAND                    = "Expecting an operand.";

    const MSG_EXPECT_CLOSING_CURLY_BRACE        = "Expecting a closing curly brace";

    const MSG_UNEXPECTED_TOKEN                  = "Unexpected token: %s";

    const MSG_UNEXPECTED_OPENING_BRACKET        = "Unexpected opening square bracket '['. Array fetch needs a variable. ( \$variable [ 0 ] )";


    const LNG_INVALID_NAMESPACE_MARKER          = "The namespace marker (:) was used in template engine in eZ publish 3.x but is no longer allowed.";
}


?>

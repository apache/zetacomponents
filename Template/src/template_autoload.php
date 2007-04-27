<?php
/**
 * Autoloader definition for the Template component.
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

return array(

///////////////////////////////////////////////////////// GLOBAL // //////////////////////////////////////////////////////////////////////

             "ezcTemplate" => "Template/template.php",
             "ezcTemplateConfiguration" => "Template/configuration.php",
             "ezcTemplateAutoloaderDefinition" => "Template/structs/autoloader_definition.php",
             "ezcTemplateVariableCollection" => "Template/variable_collection.php",

             "ezcTemplateParser" => "Template/parser.php",
             "ezcTemplateCursor" => "Template/cursor.php",
             "ezcTemplateSymbolTable" => "Template/symbol_table.php",
             "ezcTemplateCycle" => "Template/cycle.php",

             "ezcTemplateStringTool" => "Template/string_tool.php",

             "ezcTemplateCustomBlockManager" => "Template/custom_block_manager.php",
             "ezcTemplateCustomFunctionManager" => "Template/custom_function_manager.php",

             "ezcTemplateSourceCode" => "Template/source_code.php",
             "ezcTemplateCompiledCode" => "Template/compiled_code.php",
             "ezcTemplateValidationItem" => "Template/validation_item.php",
             "ezcTemplateXhtmlContext" => "Template/contexts/xhtml_context.php",
             "ezcTemplateNoContext" => "Template/contexts/no_context.php",

             "ezcTemplateSourceToTstErrorMessages" => "Template/error_messages.php",

// Global Interfaces:
             "ezcTemplateAutoloader" => "Template/interfaces/autoloader.php",
             "ezcTemplateOutputContext" => "Template/interfaces/output_context.php",
             "ezcTemplateCustomBlock" => "Template/interfaces/custom_block.php",
             "ezcTemplateCustomFunction" => "Template/interfaces/custom_function.php",
             "ezcTemplateLocationInterface" => "Template/interfaces/location.php",

             "ezcTemplateCustomExtension" => "Template/structs/custom_extension.php",
             "ezcTemplateCustomBlockDefinition" => "Template/structs/custom_block_definition.php",
             "ezcTemplateCustomFunctionDefinition" => "Template/structs/custom_function_definition.php",
             "ezcTemplateCacheManager" => "Template/interfaces/cache_manager.php",

///////////////////////////////////////////////////////// SYNTAX TREES // ////////////////////////////////////////////////////////////////

// Syntax trees / TST interfaces
             "ezcTemplateTstNode" => "Template/syntax_trees/tst/interfaces/tst_node.php",
             "ezcTemplateExpressionTstNode" => "Template/syntax_trees/tst/interfaces/expression_tst.php",
             "ezcTemplateOperatorTstNode" => "Template/syntax_trees/tst/interfaces/operator_tst.php",
             "ezcTemplateModifyingOperatorTstNode" => "Template/syntax_trees/tst/interfaces/modifying_operator_tst.php",
             "ezcTemplateCodeTstNode" => "Template/syntax_trees/tst/interfaces/code_tst.php",
             "ezcTemplateTextTstNode" => "Template/syntax_trees/tst/interfaces/text_tst.php",
             "ezcTemplateTstNodeVisitor" => "Template/syntax_trees/tst/interfaces/tst_visitor.php",

// Syntax trees / TST nodes
             "ezcTemplateBlockTstNode" => "Template/syntax_trees/tst/nodes/block.php",
             "ezcTemplateCustomBlockTstNode" => "Template/syntax_trees/tst/nodes/custom_block.php",
             "ezcTemplateProgramTstNode" => "Template/syntax_trees/tst/nodes/program.php",
             "ezcTemplateLiteralBlockTstNode" => "Template/syntax_trees/tst/nodes/literal_block.php",
             "ezcTemplateEmptyBlockTstNode" => "Template/syntax_trees/tst/nodes/empty_block.php",
             "ezcTemplateParenthesisTstNode" => "Template/syntax_trees/tst/nodes/parenthesis.php",
             "ezcTemplateOutputBlockTstNode" => "Template/syntax_trees/tst/nodes/output_block.php",
             "ezcTemplateModifyingBlockTstNode" => "Template/syntax_trees/tst/nodes/modifying_block.php",
             "ezcTemplateLiteralArrayTstNode" => "Template/syntax_trees/tst/nodes/literalarray.php",
             "ezcTemplateLiteralTstNode" => "Template/syntax_trees/tst/nodes/literal.php",
             "ezcTemplateVariableTstNode" => "Template/syntax_trees/tst/nodes/variable.php",
             "ezcTemplateTextBlockTstNode" => "Template/syntax_trees/tst/nodes/text_block.php",
             "ezcTemplateFunctionCallTstNode" => "Template/syntax_trees/tst/nodes/function_call.php",
             "ezcTemplateDocCommentTstNode" => "Template/syntax_trees/tst/nodes/doc_comment.php",
             "ezcTemplateBlockCommentTstNode" => "Template/syntax_trees/tst/nodes/block_comment.php",
             "ezcTemplateEolCommentTstNode" => "Template/syntax_trees/tst/nodes/eol_comment.php",
             "ezcTemplateForeachLoopTstNode" => "Template/syntax_trees/tst/nodes/foreach_loop.php",
             "ezcTemplateWhileLoopTstNode" => "Template/syntax_trees/tst/nodes/while_loop.php",
             "ezcTemplateIfConditionTstNode" => "Template/syntax_trees/tst/nodes/if_condition.php",
             "ezcTemplateSwitchTstNode" => "Template/syntax_trees/tst/nodes/switch.php",
             "ezcTemplateCaseTstNode" => "Template/syntax_trees/tst/nodes/case.php",
             "ezcTemplateLoopTstNode" => "Template/syntax_trees/tst/nodes/loop.php",
             "ezcTemplatePropertyFetchOperatorTstNode" => "Template/syntax_trees/tst/nodes/property_fetch_operator.php",
             "ezcTemplateArrayFetchOperatorTstNode" => "Template/syntax_trees/tst/nodes/array_fetch_operator.php",
             "ezcTemplateArrayAppendOperatorTstNode" => "Template/syntax_trees/tst/nodes/array_append_operator.php",
             "ezcTemplatePlusOperatorTstNode" => "Template/syntax_trees/tst/nodes/plus_operator.php",
             "ezcTemplateMinusOperatorTstNode" => "Template/syntax_trees/tst/nodes/minus_operator.php",
             "ezcTemplateConcatOperatorTstNode" => "Template/syntax_trees/tst/nodes/concat_operator.php",
             "ezcTemplateMultiplicationOperatorTstNode" => "Template/syntax_trees/tst/nodes/multiplication_operator.php",
             "ezcTemplateDivisionOperatorTstNode" => "Template/syntax_trees/tst/nodes/division_operator.php",
             "ezcTemplateModuloOperatorTstNode" => "Template/syntax_trees/tst/nodes/modulo_operator.php",
             "ezcTemplateEqualOperatorTstNode" => "Template/syntax_trees/tst/nodes/equal_operator.php",
             "ezcTemplateNotEqualOperatorTstNode" => "Template/syntax_trees/tst/nodes/not_equal_operator.php",
             "ezcTemplateIdenticalOperatorTstNode" => "Template/syntax_trees/tst/nodes/identical_operator.php",
             "ezcTemplateNotIdenticalOperatorTstNode" => "Template/syntax_trees/tst/nodes/not_identical_operator.php",
             "ezcTemplateLessThanOperatorTstNode" => "Template/syntax_trees/tst/nodes/less_than_operator.php",
             "ezcTemplateGreaterThanOperatorTstNode" => "Template/syntax_trees/tst/nodes/greater_than_operator.php",
             "ezcTemplateLessEqualOperatorTstNode" => "Template/syntax_trees/tst/nodes/less_equal_operator.php",
             "ezcTemplateGreaterEqualOperatorTstNode" => "Template/syntax_trees/tst/nodes/greater_equal_operator.php",
             "ezcTemplateLogicalAndOperatorTstNode" => "Template/syntax_trees/tst/nodes/logical_and_operator.php",
             "ezcTemplateLogicalOrOperatorTstNode" => "Template/syntax_trees/tst/nodes/logical_or_operator.php",
             "ezcTemplateAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/assignment_operator.php",
             "ezcTemplatePlusAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/plus_assignment_operator.php",
             "ezcTemplateMinusAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/minus_assignment_operator.php",
             "ezcTemplateMultiplicationAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/multiplication_assignment_operator.php",
             "ezcTemplateDivisionAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/division_assignment_operator.php",
             "ezcTemplateConcatAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/concat_assignment_operator.php",
             "ezcTemplateModuloAssignmentOperatorTstNode" => "Template/syntax_trees/tst/nodes/modulo_assignment_operator.php",
             "ezcTemplatePreIncrementOperatorTstNode" => "Template/syntax_trees/tst/nodes/pre_increment_operator.php",
             "ezcTemplatePreDecrementOperatorTstNode" => "Template/syntax_trees/tst/nodes/pre_decrement_operator.php",
             "ezcTemplatePostIncrementOperatorTstNode" => "Template/syntax_trees/tst/nodes/post_increment_operator.php",
             "ezcTemplatePostDecrementOperatorTstNode" => "Template/syntax_trees/tst/nodes/post_decrement_operator.php",
             "ezcTemplateNegateOperatorTstNode" => "Template/syntax_trees/tst/nodes/negate_operator.php",
             "ezcTemplateLogicalNegateOperatorTstNode" => "Template/syntax_trees/tst/nodes/logical_negate_operator.php",
             "ezcTemplateDeclarationTstNode" => "Template/syntax_trees/tst/nodes/declaration.php",
             "ezcTemplateArrayRangeOperatorTstNode" => "Template/syntax_trees/tst/nodes/array_range_operator.php",
             "ezcTemplateConditionBodyTstNode" => "Template/syntax_trees/tst/nodes/condition_body.php",
             "ezcTemplateDelimiterTstNode" => "Template/syntax_trees/tst/nodes/delimiter.php",
             "ezcTemplateCycleControlTstNode" => "Template/syntax_trees/tst/nodes/cycle_control.php",
             "ezcTemplateCharsetTstNode" => "Template/syntax_trees/tst/nodes/charset.php",
             "ezcTemplateIncludeTstNode" => "Template/syntax_trees/tst/nodes/include.php",
             "ezcTemplateReturnTstNode" => "Template/syntax_trees/tst/nodes/return.php",
             "ezcTemplateIdentifierTstNode" => "Template/syntax_trees/tst/nodes/identifier.php",
             "ezcTemplateCacheTstNode" => "Template/syntax_trees/tst/nodes/cache.php",
             "ezcTemplateDynamicBlockTstNode" => "Template/syntax_trees/tst/nodes/dynamic_block.php",
             "ezcTemplateCacheBlockTstNode" => "Template/syntax_trees/tst/nodes/cache_block.php",


// Syntax trees / AST
             "ezcTemplateAstBuilder" => "Template/syntax_trees/ast/ast_builder.php",

// Syntax trees / AST interfaces
             "ezcTemplateAstNode" => "Template/syntax_trees/ast/interfaces/ast_node.php",
             "ezcTemplateParameterizedAstNode" => "Template/syntax_trees/ast/interfaces/parameterized_ast.php",
             "ezcTemplateOperatorAstNode" => "Template/syntax_trees/ast/interfaces/operator_ast.php",
             "ezcTemplateBinaryOperatorAstNode" => "Template/syntax_trees/ast/interfaces/binary_operator.php",
             "ezcTemplateStatementAstNode" => "Template/syntax_trees/ast/interfaces/statement_ast.php",
             "ezcTemplateAstNodeVisitor" => "Template/syntax_trees/ast/interfaces/ast_visitor.php",

// Syntax trees / AST  nodes
             "ezcTemplateRootAstNode" => "Template/syntax_trees/ast/nodes/root.php",
             "ezcTemplateNopAstNode" => "Template/syntax_trees/ast/nodes/nop.php",
             "ezcTemplateLiteralAstNode" => "Template/syntax_trees/ast/nodes/literal.php",
             "ezcTemplateLiteralArrayAstNode" => "Template/syntax_trees/ast/nodes/literalarray.php",
             "ezcTemplateOutputAstNode" => "Template/syntax_trees/ast/nodes/output.php",
             "ezcTemplateTypeCastAstNode" => "Template/syntax_trees/ast/nodes/type_cast.php",
             "ezcTemplateConstantAstNode" => "Template/syntax_trees/ast/nodes/constant.php",
             "ezcTemplateIdentifierAstNode" => "Template/syntax_trees/ast/nodes/identifier.php",
             "ezcTemplateEolCommentAstNode" => "Template/syntax_trees/ast/nodes/eol_comment.php",
             "ezcTemplateBlockCommentAstNode" => "Template/syntax_trees/ast/nodes/block_comment.php",
             "ezcTemplateVariableAstNode" => "Template/syntax_trees/ast/nodes/variable.php",
             "ezcTemplateDynamicVariableAstNode" => "Template/syntax_trees/ast/nodes/dynamic_variable.php",
             "ezcTemplateDynamicStringAstNode" => "Template/syntax_trees/ast/nodes/dynamic_string.php",
             "ezcTemplateBodyAstNode" => "Template/syntax_trees/ast/nodes/body.php",
             "ezcTemplateGenericStatementAstNode" => "Template/syntax_trees/ast/nodes/generic_statement.php",
             "ezcTemplateFunctionCallAstNode" => "Template/syntax_trees/ast/nodes/function_call.php",
             "ezcTemplateConditionBodyAstNode" => "Template/syntax_trees/ast/nodes/condition_body.php",
             "ezcTemplateParenthesisAstNode" => "Template/syntax_trees/ast/nodes/parenthesis.php",
             "ezcTemplateCurlyBracesAstNode" => "Template/syntax_trees/ast/nodes/curly_braces.php",
             "ezcTemplatePhpCodeAstNode" => "Template/syntax_trees/ast/nodes/php_code.php",
             "ezcTemplateDynamicBlockAstNode" => "Template/syntax_trees/ast/nodes/dynamic_block.php",
             "ezcTemplateCacheBlockAstNode" => "Template/syntax_trees/ast/nodes/cache_block.php",
             "ezcTemplateThrowExceptionAstNode" => "Template/syntax_trees/ast/nodes/throw_exception.php",

             // Control
             "ezcTemplateIfAstNode" => "Template/syntax_trees/ast/nodes/control/if.php",
             "ezcTemplateWhileAstNode" => "Template/syntax_trees/ast/nodes/control/while.php",
             "ezcTemplateDoWhileAstNode" => "Template/syntax_trees/ast/nodes/control/do_while.php",
             "ezcTemplateForAstNode" => "Template/syntax_trees/ast/nodes/control/for.php",
             "ezcTemplateForeachAstNode" => "Template/syntax_trees/ast/nodes/control/foreach.php",
             "ezcTemplateBreakAstNode" => "Template/syntax_trees/ast/nodes/control/break.php",
             "ezcTemplateContinueAstNode" => "Template/syntax_trees/ast/nodes/control/continue.php",
             "ezcTemplateSwitchAstNode" => "Template/syntax_trees/ast/nodes/control/switch.php",
             "ezcTemplateCaseAstNode" => "Template/syntax_trees/ast/nodes/control/case.php",
             "ezcTemplateDefaultAstNode" => "Template/syntax_trees/ast/nodes/control/default.php",
             "ezcTemplateReturnAstNode" => "Template/syntax_trees/ast/nodes/control/return.php",
             "ezcTemplateRequireAstNode" => "Template/syntax_trees/ast/nodes/control/require.php",
             "ezcTemplateRequireOnceAstNode" => "Template/syntax_trees/ast/nodes/control/require_once.php",
             "ezcTemplateIncludeAstNode" => "Template/syntax_trees/ast/nodes/control/include.php",
             "ezcTemplateIncludeOnceAstNode" => "Template/syntax_trees/ast/nodes/control/include_once.php",
             "ezcTemplateTryAstNode" => "Template/syntax_trees/ast/nodes/control/try.php",
             "ezcTemplateCatchAstNode" => "Template/syntax_trees/ast/nodes/control/catch.php",

             // Constructs
             "ezcTemplateEchoAstNode" => "Template/syntax_trees/ast/nodes/constructs/echo.php",
             "ezcTemplatePrintAstNode" => "Template/syntax_trees/ast/nodes/constructs/print.php",
             "ezcTemplateIssetAstNode" => "Template/syntax_trees/ast/nodes/constructs/isset.php",
             "ezcTemplateUnsetAstNode" => "Template/syntax_trees/ast/nodes/constructs/unset.php",
             "ezcTemplateEmptyAstNode" => "Template/syntax_trees/ast/nodes/constructs/empty.php",
             "ezcTemplateNewAstNode"   => "Template/syntax_trees/ast/nodes/constructs/new.php",
             "ezcTemplateCloneAstNode"   => "Template/syntax_trees/ast/nodes/constructs/clone.php",

             // Operators
             "ezcTemplateArrayFetchOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/array_fetch_operator.php",
             "ezcTemplateArrayAppendOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/array_append_assignment_operator.php",
             "ezcTemplateAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/assignment_operator.php",
             "ezcTemplateObjectAccessOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/object_access_operator.php",
             "ezcTemplateConcatAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/concat_assignment_operator.php",
             "ezcTemplateDivisionAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/division_assignment_operator.php",
             "ezcTemplateSubtractionAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/subtraction_assignment_operator.php",
             "ezcTemplateModulusAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/modulus_assignment_operator.php",
             "ezcTemplateMultiplicationAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/multiplication_assignment_operator.php",
             "ezcTemplateAdditionAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/addition_assignment_operator.php",
             "ezcTemplateBitwiseAndAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_and_assignment_operator.php",
             "ezcTemplateBitwiseOrAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_or_assignment_operator.php",
             "ezcTemplateBitwiseXorAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_xor_assignment_operator.php",
             "ezcTemplateShiftLeftAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/shift_left_assignment_operator.php",
             "ezcTemplateShiftRightAssignmentOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/shift_right_assignment_operator.php",
             "ezcTemplateArithmeticNegationOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/arithmetic_negation_operator.php",
             "ezcTemplateConcatOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/concat_operator.php",
             "ezcTemplateEqualOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/equal_operator.php",
             "ezcTemplateGreaterEqualOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/greater_equal_operator.php",
             "ezcTemplateGreaterThanOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/greater_than_operator.php",
             "ezcTemplateIdenticalOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/identical_operator.php",
             "ezcTemplateInstanceofOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/instanceof_operator.php",
             "ezcTemplateIncrementOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/increment_operator.php",
             "ezcTemplateDecrementOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/decrement_operator.php",
             "ezcTemplateLessEqualOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/less_equal_operator.php",
             "ezcTemplateLessThanOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/less_than_operator.php",
             "ezcTemplateLogicalAndOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/logical_and_operator.php",
             "ezcTemplateLogicalOrOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/logical_or_operator.php",
             "ezcTemplateLogicalNegationOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/logical_negation_operator.php",
             "ezcTemplateLogicalLiteralAndOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/logical_literal_and_operator.php",
             "ezcTemplateLogicalLiteralOrOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/logical_literal_or_operator.php",
             "ezcTemplateLogicalLiteralXorOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/logical_literal_xor_operator.php",
             "ezcTemplateBitwiseAndOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_and_operator.php",
             "ezcTemplateBitwiseOrOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_or_operator.php",
             "ezcTemplateBitwiseXorOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_xor_operator.php",
             "ezcTemplateBitwiseNegationOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/bitwise_negation_operator.php",
             "ezcTemplateShiftLeftOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/shift_left_operator.php",
             "ezcTemplateShiftRightOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/shift_right_operator.php",
             "ezcTemplateSubtractionOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/subtraction_operator.php",
             "ezcTemplateDivisionOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/division_operator.php",
             "ezcTemplateModulusOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/modulus_operator.php",
             "ezcTemplateMultiplicationOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/multiplication_operator.php",
             "ezcTemplateNotEqualOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/not_equal_operator.php",
             "ezcTemplateNotIdenticalOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/not_identical_operator.php",
             "ezcTemplateAdditionOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/addition_operator.php",
             "ezcTemplateReferenceOperatorAstNode" => "Template/syntax_trees/ast/nodes/operators/reference_operator.php",

///////////////////////////////////////////////////////// PARSERS // /////////////////////////////////////////////////////////////////////

// Parsers / source_to_tst interfaces
             "ezcTemplateSourceToTstParser" => "Template/parsers/source_to_tst/interfaces/source_to_tst_parser.php",

// Parsers / source_to_tst implementations 
             "ezcTemplateProgramSourceToTstParser" => "Template/parsers/source_to_tst/implementations/program.php",
             "ezcTemplateBlockSourceToTstParser" => "Template/parsers/source_to_tst/implementations/block.php",
             "ezcTemplateLiteralBlockSourceToTstParser" => "Template/parsers/source_to_tst/implementations/literal_block.php",
             "ezcTemplateControlStructureSourceToTstParser" => "Template/parsers/source_to_tst/implementations/control_structure.php",
             "ezcTemplateCustomBlockSourceToTstParser" => "Template/parsers/source_to_tst/implementations/custom_block.php",
             "ezcTemplateForeachLoopSourceToTstParser" => "Template/parsers/source_to_tst/implementations/foreach_loop.php",
             "ezcTemplateWhileLoopSourceToTstParser" => "Template/parsers/source_to_tst/implementations/while_loop.php",
             "ezcTemplateIfConditionSourceToTstParser" => "Template/parsers/source_to_tst/implementations/if_condition.php",
             "ezcTemplateSwitchConditionSourceToTstParser" => "Template/parsers/source_to_tst/implementations/switch_condition.php",
             "ezcTemplateLoopSourceToTstParser" => "Template/parsers/source_to_tst/implementations/loop.php",
             "ezcTemplateExpressionBlockSourceToTstParser" => "Template/parsers/source_to_tst/implementations/expression_block.php",
             "ezcTemplateExpressionSourceToTstParser" => "Template/parsers/source_to_tst/implementations/expression.php",
             "ezcTemplateDeclarationBlockSourceToTstParser" => "Template/parsers/source_to_tst/implementations/declaration.php",
             "ezcTemplateLiteralSourceToTstParser" => "Template/parsers/source_to_tst/implementations/literal.php",
             "ezcTemplateIntegerSourceToTstParser" => "Template/parsers/source_to_tst/implementations/integer.php",
             "ezcTemplateFloatSourceToTstParser" => "Template/parsers/source_to_tst/implementations/float.php",
             "ezcTemplateStringSourceToTstParser" => "Template/parsers/source_to_tst/implementations/string.php",
             "ezcTemplateBoolSourceToTstParser" => "Template/parsers/source_to_tst/implementations/bool.php",
             "ezcTemplateNullSourceToTstParser" => "Template/parsers/source_to_tst/implementations/null.php",
             "ezcTemplateArraySourceToTstParser" => "Template/parsers/source_to_tst/implementations/array.php",
             "ezcTemplateFunctionCallSourceToTstParser" => "Template/parsers/source_to_tst/implementations/function_call.php",
             "ezcTemplateArrayFetchSourceToTstParser" => "Template/parsers/source_to_tst/implementations/array_fetch.php",
             "ezcTemplateVariableSourceToTstParser" => "Template/parsers/source_to_tst/implementations/variable.php",
             "ezcTemplateIdentifierSourceToTstParser" => "Template/parsers/source_to_tst/implementations/identifier.php",
             "ezcTemplateDocCommentSourceToTstParser" => "Template/parsers/source_to_tst/implementations/doc_comment.php",
             "ezcTemplateBlockCommentSourceToTstParser" => "Template/parsers/source_to_tst/implementations/block_comment.php",
             "ezcTemplateEolCommentSourceToTstParser" => "Template/parsers/source_to_tst/implementations/eol_comment.php",
             "ezcTemplateDelimiterSourceToTstParser" => "Template/parsers/source_to_tst/implementations/delimiter.php",
             "ezcTemplateCycleSourceToTstParser" => "Template/parsers/source_to_tst/implementations/cycle.php",
             "ezcTemplateCharsetSourceToTstParser" => "Template/parsers/source_to_tst/implementations/charset.php",
             "ezcTemplateIncludeSourceToTstParser" => "Template/parsers/source_to_tst/implementations/include.php",
             "ezcTemplateCacheSourceToTstParser" => "Template/parsers/source_to_tst/implementations/cache.php",



// Generic parser interfaces
             "ezcTemplateTreeOutput"       => "Template/parsers/interfaces/tree_output.php",

// Parsers / tst_to_tst implementations
             "ezcTemplateTstWalker"               => "Template/parsers/tst_to_tst/implementations/tst_walker.php",
             "ezcTemplateCachePreparation"        => "Template/parsers/tst_to_tst/implementations/cache_preparation.php",

             "ezcTemplateFetchCacheInformation"   => "Template/parsers/tst_to_tst/implementations/cache_information.php",
             "ezcTemplateWhitespaceRemoval" => "Template/parsers/tst_to_tst/implementations/whitespace_removal.php",
             "ezcTemplateTstTreeOutput"       => "Template/parsers/tst/implementations/tst_tree_output.php",

// Parsers / tst_to_ast implementations
             "ezcTemplateTstToAstTransformer" => "Template/parsers/tst_to_ast/implementations/tst_to_ast_transformer.php",
             "ezcTemplateTstToAstCachedTransformer" => "Template/parsers/tst_to_ast/implementations/tst_to_ast_cached_transformer.php",

             "ezcTemplateOutputVariableManager" => "Template/parsers/tst_to_ast/implementations/output_variable_manager.php",

// Parsers / ast_to_ast implementations
             "ezcTemplateAstWalker"               => "Template/parsers/ast_to_ast/implementations/ast_walker.php",
             "ezcTemplateAstToAstContextAppender" => "Template/parsers/ast_to_ast/implementations/context_appender.php",
             "ezcTemplateAstToAstAssignmentOptimizer" => "Template/parsers/ast_to_ast/implementations/assignment_optimizer.php",
             "ezcTemplateAstToAstCache"          => "Template/parsers/ast_to_ast/implementations/cache.php",

// Parsers / ast_to_php implementations
             "ezcTemplateAstToPhpGenerator" => "Template/parsers/ast_to_php/implementations/php_generator.php",

// Parsers / ast_to_php implementations
             "ezcTemplateAstTreeOutput"       => "Template/parsers/ast/implementations/ast_tree_output.php",

// Exceptions
             "ezcTemplateException" => "Template/exceptions/template_exception.php",
             "ezcTemplateLocatorNotFoundException" => "Template/exceptions/locator_not_found_exception.php",
             "ezcTemplateNoManagerException" => "Template/exceptions/no_manager_exception.php",
             "ezcTemplateNoOutputContextException" => "Template/exceptions/no_output_context_exception.php",
             "ezcTemplateInvalidCompiledFileException" => "Template/exceptions/invalid_compiled_file_exception.php",
             "ezcTemplateOutdatedCompilationException" => "Template/exceptions/outdated_compilation_exception.php",
             "ezcTemplateCompilationFailedException" => "Template/exceptions/compilation_failed_exception.php",
             "ezcTemplateFileNotFoundException" => "Template/exceptions/file_not_found_exception.php",
             "ezcTemplateFileNotReadableException" => "Template/exceptions/file_not_readable_exception.php",
             "ezcTemplateFileNotWriteableException" => "Template/exceptions/file_not_writeable_exception.php",
             "ezcTemplateFileFailedUnlinkException" => "Template/exceptions/file_failed_unlink_exception.php",
             "ezcTemplateFileFailedRenameException" => "Template/exceptions/file_failed_rename_exception.php",
             "ezcTemplateSourceToTstParserException" => "Template/exceptions/source_to_tst_parser_exception.php",
             "ezcTemplateTypeHintException" => "Template/exceptions/typehint_exception.php",

             "ezcTemplateTstNodeException" => "Template/exceptions/tst_node_exception.php",
             "ezcTemplateParserException" => "Template/exceptions/parser_exception.php",
             "ezcTemplateCustomBlockException" => "Template/exceptions/custom_block_exception.php",

             "ezcTemplateRuntimeException" => "Template/exceptions/runtime_exception.php",
             "ezcTemplateInternalException" => "Template/exceptions/internal_exception.php",



// Functions
             "ezcTemplateFunctions" => "Template/functions/functions.php",
             "ezcTemplateStringFunctions" => "Template/functions/string_functions.php",
             "ezcTemplateDateFunctions" => "Template/functions/date_functions.php",
             "ezcTemplateWebFunctions" => "Template/functions/web_functions.php",
             "ezcTemplateArrayFunctions" => "Template/functions/array_functions.php",
             "ezcTemplateRegExpFunctions" => "Template/functions/regexp_functions.php",
             "ezcTemplateTypeFunctions" => "Template/functions/type_functions.php",
             "ezcTemplateMathFunctions" => "Template/functions/math_functions.php",
             "ezcTemplateDebugFunctions" => "Template/functions/debug_functions.php",

// Functions code
             "ezcTemplateString" => "Template/functions/string_code.php",
             "ezcTemplateDate" => "Template/functions/date_code.php",
             "ezcTemplateWeb" => "Template/functions/web_code.php",
             "ezcTemplateArray" => "Template/functions/array_code.php",
             "ezcTemplateRegExp" => "Template/functions/regexp_code.php",
             "ezcTemplateType" => "Template/functions/type_code.php",
             "ezcTemplateDebug" => "Template/functions/debug_code.php",

            );


?>

<?php
/**
 * File containing the ezcTemplateParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for template files.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateParser
{

    /**
     * @var ezcTemplateManager
     */
    public $manager;

    /**
     * @var ezcTemplateSourceCode
     */
    public $source;

    /**
     * Controls whether debug is displayed or not.
     *
     * @var bool
     */
    public $debug;

    /**
     * Controls whether whitespace trimming is done on the parser tree or not.
     *
     * @var bool
     */
    public $trimWhitespace;

    /**
     * The object which is responsible for removing whitespace.
     *
     * @var ezcTemplateWhitespaceRemoval
     */
    protected $whitespaceRemoval;

    /**
     * Stores the symbol table. At the beginning of parsing (at ProgramSourceToTstParser)
     * a new symbol table is created. The rest of the nodes can access the symbol
     * table.
     *
     * @var ezcTemplateSymboLTable
     */
    public $symbolTable;

    /**
     *
     * @note The source code in $code must be loaded/created before passing it to this parser.
    */
    function __construct( ezcTemplateSourceCode $source, ezcTemplateManager $manager )
    {
        $this->source = $source;
        $this->manager = $manager;
        $this->textElements = array();
        $this->trimWhitespace = true;
        $this->debug = false;

        $this->symbolTable = new ezcTemplateSymbolTable();

        $this->whitespaceRemoval = new ezcTemplateWhitespaceRemoval();
    }

    /**
     * Creates a new cursor object with the text $sourceText and returns it.
     * @note This must be used instead of using new operator to instantiate
     *       cursors. This then allows the creation method to by testable.
     *
     * @param string $sourceText The source code.
     * @return ezcTemplateCursor
     */
    public function createCursor( $sourceText )
    {
        return new ezcTemplateCursor( $sourceText );
    }

    /**
     * @todo Currently used for testing order of element creation, might not be needed.
     */
    public function reportElementCursor( $startCursor, $endCursor, $element )
    {
        //echo "element <", get_class( $element ) . ">\n";
    }

    /**
     * Creates a new program element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateProgramTstNode
     */
    public function createProgram( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateProgramTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new text element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateTextBlockTstNode
     */
    public function createText( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateTextBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new inline doc comment element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateDocCommentTstNode
     */
    public function createDocComment( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateDocCommentTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new inline block comment element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateBlockCommentTstNode
     */
    public function createBlockComment( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateBlockCommentTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new inline eol comment element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEolCommentTstNode
     */
    public function createEolComment( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateEolCommentTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new block element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateBlockTstNode
     */
    public function createBlock( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new custom block element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateBlockTstNode
     */
    public function createCustomBlock( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateCustomBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new empty block element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEmptyBlockTstNode
     */
    public function createEmptyBlock( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateEmptyBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new parenthesis expression node with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateParenthesisTstNode
     */
    public function createParenthesis( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateParenthesisTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new output block element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateOutputBlockTstNode
     */
    public function createOutputBlock( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateOutputBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new modifying block element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateModifyingBlockTstNode
     */
    public function createModifyingBlock( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateModifyingBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new literal block element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateLiteralBlockTstNode
     */
    public function createLiteralBlock( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLiteralBlockTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new type element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateLiteralTstNode
     */
    public function createLiteral( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLiteralTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new variable element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateVariableTstNode
     */
    public function createVariable( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateVariableTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new declaration element object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateDeclarationTstNode
     */
    public function createDeclaration( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateDeclarationTstNode( $this->source, $start, $end );
    }


    /**
     * Creates a new property fetch operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateVariableTstNode
     */
    public function createPropertyFetch( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePropertyFetchOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new array fetch operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateVariableTstNode
     */
    public function createArrayFetch( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateArrayFetchOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creats a new array range operator.
     */
    public function createArrayRangeOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateArrayRangeOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new plus operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplatePlusOperatorTstNode
     */
    public function createPlusOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePlusOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new minus operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateMinusOperatorTstNode
     */
    public function createMinusOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateMinusOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new concat operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateConcatOperatorTstNode
     */
    public function createConcatOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateConcatOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new multiplication operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateMultiplicationOperatorTstNode
     */
    public function createMultiplicationOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateMultiplicationOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new division operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateDivisionOperatorTstNode
     */
    public function createDivisionOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateDivisionOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new modulo operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateModuloOperatorTstNode
     */
    public function createModuloOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateModuloOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new equal operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createEqualOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateEqualOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new not equal operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateNotEqualOperatorTstNode
     */
    public function createNotEqualOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateNotEqualOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new identical operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateIdenticalOperatorTstNode
     */
    public function createIdenticalOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateIdenticalOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new not identical operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateNotIdenticalOperatorTstNode
     */
    public function createNotIdenticalOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateNotIdenticalOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new less than operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createLessThanOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLessThanOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new greater than operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createGreaterThanOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateGreaterThanOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new less equal operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createLessEqualOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLessEqualOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new greater equal operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createGreaterEqualOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateGreaterEqualOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new logical and operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createLogicalAndOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLogicalAndOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new logical or operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createLogicalOrOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLogicalOrOperatorTstNode( $this->source, $start, $end );
    }

    /**
    /**
     * Creates a new assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new plus assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createPlusAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePlusAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new minus assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createMinusAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateMinusAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new multiplication assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createMultiplicationAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateMultiplicationAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new division assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createDivisionAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateDivisionAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new concat assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createConcatAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateConcatAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new modulo assignment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createModuloAssignmentOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateModuloAssignmentOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new pre increment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createPreIncrementOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePreIncrementOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new pre decrement operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createPreDecrementOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePreDecrementOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new post increment operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createPostIncrementOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePostIncrementOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new post decrement operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createPostDecrementOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplatePostDecrementOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new negate operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createNegateOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateNegateOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new logical negate operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createLogicalNegateOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateLogicalNegateOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new instance-of operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createInstanceOfOperator( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateInstanceOfOperatorTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new function-call operator object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateEqualOperatorTstNode
     */
    public function createFunctionCall( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateFunctionCallTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new "foreach" control structure object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateForeachLoopTstNode The created object.
     */
    public function createForeachLoop( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateForeachLoopTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new "while"/"do..whole" control structure object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
       @param string            $name Optional block name.
     * @return ezcTemplateWhilehLoopElement The created object.
     */
    public function createWhileLoop( ezcTemplateCursor $start, ezcTemplateCursor $end, $name = null )
    {
        return new ezcTemplateWhileLoopTstNode( $this->source, $start, $end, $name );
    }

    /**
     * Creates a new "if" condition object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @return ezcTemplateIfConditionTstNode The created object.
     */
    public function createIfCondition( ezcTemplateCursor $start, ezcTemplateCursor $end )
    {
        return new ezcTemplateIfConditionTstNode( $this->source, $start, $end );
    }

    /**
     * Creates a new "if" condition object with the cursor positions and returns it.
     *
     * @param ezcTemplateCursor $start The starting point of the element.
     * @param ezcTemplateCursor $end The ending point of the element.
     * @param string            $name Optional block name.
     * @return ezcTemplateLoopTstNode The created object.
     */
    public function createLoop( ezcTemplateCursor $start, ezcTemplateCursor $end, $name = null )
    {
        return new ezcTemplateLoopTstNode( $this->source, $start, $end, $name );
    }

    /**
     * Figures out the operator precedence for the new operator $newOperator
     * by examining it with the current operator element.
     *
     * @param ezcTemplateTstNode $currentOperator Either the current operator
     *                                            element or general parameter
     *                                            element.
     * @param ezcTemplateOperatorTstNode $newOperator The newly found operator.
     * @return ezcTemplateOperatorTstNode
     */
    public function handleOperatorPrecedence( /*ezcTemplateTstNode*/ $currentOperator, ezcTemplateOperatorTstNode $newOperator )
    {
        if ( $currentOperator === null )
        {
            // @todo Fix exception class
            throw new Exception( "No current operator/operand has been set" );
        }

        if ( !( $currentOperator instanceof ezcTemplateOperatorTstNode ) )
        {
            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "non operator added <", get_class( $currentOperator ), "> to operator <", get_class( $newOperator ), ">\n";
                echo "non operator added as parameter, continuing on new operator\n";
                // *** DEBUG END ***
            }

            // Note this operand should be prepended (not appended) in case
            // the new operator already have some parameters set.
            $newOperator->prependParameter( $currentOperator );
            return $newOperator;
        }

        if ( $currentOperator->precedence > $newOperator->precedence )
        {
            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "new operator <", get_class( $newOperator ), ">:", $newOperator->precedence, " has lower precedence than <", get_class( $currentOperator ), ">:", $currentOperator->precedence, "\n";
                echo "searching for root operator\n";
                // *** DEBUG END ***
            }


            // Controls whether the $newOperator should be become the new root operator or not
            // This happens if all operators have a higher precedence than the new operator.
            $asRoot = false;

            // Find parent with less or equal precedence
            while ( $currentOperator->precedence > $newOperator->precedence )
            {
                if ( $currentOperator->parentOperator === null )
                {
                    $asRoot = true;
                    break;
                }
                $currentOperator = $currentOperator->parentOperator;
            }

            if ( $asRoot )
            {
                if ( $this->debug )
                {
                    // *** DEBUG START ***
                    echo "new operator <", get_class( $newOperator ), ">:", $newOperator->precedence, " has lower precedence than all operators\n";
                    echo "new operator is new root with old root as parameter, continuing on new parameter\n";
                    // *** DEBUG END ***
                }

                $newOperator->prependParameter( $currentOperator );
                $currentOperator->parentOperator = $newOperator;

                if ( $this->debug )
                {
                    // *** DEBUG START ***
                    echo "\n\n\n";
                    echo ezcTemplateTstTreeOutput::output( $newOperator );
                    echo "\n\n\n";
                    // *** DEBUG END ***
                }

                return $newOperator;
            }
        }


        // Check if the operators can merge parameters, reasons for this can be:
        // - The operators are of the same class
        // - The : part of a conditional operator is found
        if ( $currentOperator->canMergeParametersOf( $newOperator ) )
        {
            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "operators can merge their parameters <", get_class( $currentOperator ), "> & <", get_class( $newOperator ), ">\n";
                echo "no swap is done, parameters are merged\n";
                // *** DEBUG END ***
            }
            $currentOperator->mergeParameters( $newOperator );

            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n";
                echo ezcTemplateTstTreeOutput::output( $currentOperator );
                echo "\n\n\n";
                // *** DEBUG END ***
            }

            return $currentOperator;
        }

        if ( $currentOperator->precedence < $newOperator->precedence )
        {
            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "new operator <", get_class( $newOperator ), ">:", $newOperator->precedence, " has higher precedence than <", get_class( $currentOperator ), ">:", $currentOperator->precedence, "\n";
                echo "swapping last parameter with new operator, continuing on new parameter\n";
                // *** DEBUG END ***
            }

            $parameter = $currentOperator->getLastParameter();
            $currentOperator->setLastParameter( $newOperator );
            $newOperator->parentOperator = $currentOperator;
            if ( $parameter !== null )
                $newOperator->prependParameter( $parameter );

            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n";
                echo ezcTemplateTstTreeOutput::output( $currentOperator );
                echo "\n\n\n";
                // *** DEBUG END ***
            }

            return $newOperator;
        }

        // Same precedence, order must be checked
        if ( $currentOperator->precedence == $newOperator->precedence )
        {
            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "new operator <", get_class( $newOperator ), ">:", $newOperator->precedence, " is same precedence as <", get_class( $currentOperator ), ">:", $currentOperator->precedence, "\n";
                // *** DEBUG END ***
            }

//            $currentOperator->handleEqualPrecedence( $newOperator );
            if ( $this->debug )
                echo "setting current operator as parameter of new operator and using its parent as new parent, continuing on new parameter\n";

            $parentOperator = $currentOperator->parentOperator;
            $parameter = $currentOperator->getLastParameter();
//            $newOperator->appendParameter( $currentOperator );
            $newOperator->prependParameter( $currentOperator );
            if ( $parentOperator !== null )
                $parentOperator->setLastParameter( $newOperator );
            $currentOperator->parentOperator = $newOperator;
            $newOperator->parentOperator = $parentOperator;

            if ( $this->debug )
            {
                // *** DEBUG START ***
                echo "\n\n\n";
                echo ezcTemplateTstTreeOutput::output( $newOperator );
                echo "\n\n\n";
                // *** DEBUG END ***
            }

            return $newOperator;
        }

        if ( $this->debug )
        {
            // *** DEBUG START ***
            echo "new operator <", get_class( $newOperator ), ">:", $newOperator->precedence, " /\ <", get_class( $currentOperator ), ">:", $currentOperator->precedence, "\n";
            echo "\n\n\n";
            echo ezcTemplateTstTreeOutput::output( $currentOperator );
            echo "\n\n\n";
            // *** DEBUG END ***
        }

        throw new Exception( "Should not reach this place." );
    }

    /**
     * Handles a newly parsed operand, the operand will be appended to the
     * current operator if there is one, if not it becomes the current item.
     * The element which should be the current item is returned by this function.
     *
     * @param ezcTemplateTstNode $currentOperator The current operator/operand element, can be null.
     * @param ezcTemplateTstNode $operand The parsed operator/operand which should be added as parameter.
     * @return ezcTemplateTstNode
     */
    public function handleOperand( /*ezcTemplateTstNode*/ $currentOperator, ezcTemplateTstNode $operand )
    {
        if ( $currentOperator !== null )
        {
            if ( $this->debug )
            {
                if ( $operand instanceof ezcTemplateLiteralTstNode )
                    echo "adding operand <" . get_class( $operand ) . ">::<" . var_export( $operand->value, true ) . "> to operator <" . get_class( $currentOperator ) . ">\n";
                else
                    echo "adding operand <" . get_class( $operand ) . "> to operator <" . get_class( $currentOperator ) . ">\n";
            }
            $currentOperator->appendParameter( $operand );
            return $currentOperator;
        }
        else
        {
            if ( $this->debug )
            {
                if ( $operand instanceof ezcTemplateLiteralTstNode )
                    echo "setting operand <" . get_class( $operand ) . ">::<" . var_export( $operand->value, true ) . "> as \$currentOperator\n";
                else
                    echo "setting operand <" . get_class( $operand ) . "> as \$currentOperator\n";
            }
            return $operand;
        }
    }

    public function parseIntoNodeTree()
    {
        if ( !$this->source->hasCode() )
            throw new ezcTemplateParseException( ezcTemplateParseException::NO_SOURCE_CODE );

        $sourceText = $this->source->code;
        $cursor = new ezcTemplateCursor( $sourceText );

        $this->textElements = array();

        $parser = new ezcTemplateProgramSourceToTstParser( $this, null, null );
        $parser->setAllCursors( $cursor );
        
        if ( !$parser->parse() )
        {
            $currentParser = $parser->getFailingParser();

            // TODO, This exception may disappear in the future, as the Parser elements should throw their own errors.
            throw new ezcTemplateSourceToTstParserException( $currentParser, $currentParser->startCursor, $currentParser->getErrorMessage(), $currentParser->getErrorDetails() );
        }

        // Trim starting/trailing whitespace
        if ( $this->trimWhitespace )
        {
            $this->whitespaceRemoval->trimProgram( $parser->program );
        }

        // temporary compatability
        $parser->program->elements = $parser->program->children;

        return $parser->program;

//        $this->textElements = $parser->elements;

//        return $this->textElements;
    }

    /**
     * Trims away indentation for one block level.
     *
     * The parser will call the ezcTemplateBlockTstNode::trimIndentation() method
     * of the specified block object with the whitespace removal object passed
     * as parameter. This allows the block element to choose how to apply the trimming
     * process since it may have more than one child list.
     *
     * @note This does nothing if self::$trimWhitespace is set to false.
     * @param ezcTemplateBlockTstNode $block
     *        Block element which has its children trimmed of indentation whitespace.
     */
    public function trimBlockLevelIndentation( ezcTemplateBlockTstNode $block )
    {
        if ( !$this->trimWhitespace )
        {
            return;
        }

        // Tell the block to trim its indentation by passign the object
        // which has defined the rules for trimming whitespace
        $block->trimIndentation( $this->whitespaceRemoval );
    }

    /**
     * Trims away EOL whitespace for block lines for the specified block element.
     *
     * The parser will call the ezcTemplateBlockTstNode::trimLine() method
     * of the specified block object with the whitespace removal object passed
     * as parameter. This allows the block element to choose how to apply the trimming
     * process since it may have more than one child list.
     *
     * @note This does nothing if self::$trimWhitespace is set to false.
     * @param ezcTemplateBlockTstNode $block
     *        Block element which has its child blocks trimmed of EOL whitespace.
     */
    public function trimBlockLine( ezcTemplateBlockTstNode $block )
    {
        if ( !$this->trimWhitespace )
        {
            return;
        }

        // Tell the block to trim its block line for any whitespace and EOL characters
        // by passign the object  which has defined the rules for trimming whitespace
        $block->trimLine( $this->whitespaceRemoval );
    }
}

?>

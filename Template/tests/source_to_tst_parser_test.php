<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once "invariant_parse_cursor.php";

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateSourceToTstParserTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * Returns a constraint which checks if the input path exist on the filesystem.
     *
     * @return ezcMockFileExistsConstraint
     */
    static public function existsOnDisk()
    {
        return new ezcMockFileExistsConstraint();
    }

    protected function setUp()
    {
        // // required because of Reflection autoload bug
        class_exists( 'ezcTemplateSourceCode' );
        // class_exists( 'ezcTemplateManager' );
        $this->manager = new ezcTemplateManager();
        PHPUnit_Extensions_MockObject_Mock::generate( 'ezcTemplateParser', array( "reportElementCursor" ), 'MockElement_ezcTemplateParser' );

        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateCompiledPath = $this->basePath . 'compiled/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

    /**
     * Test parsing template code which does not contain any blocks.
     */
    public function testParsingTextElements()
    {
        $text = "abc def \nshow widget";
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        $items = array( array( 0, 1, 0,  20, 2, 11,  'TextBlock' ) );

        $this->setupExpectedPositions( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing template code which has a block with a missing end bracket.
     */
    public function testParsingBlockWithMissingBracketReportsError()
    {
        $text = "abc def \n{show widget";
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        $items = array( array( 0, 1, 0,  9, 2, 0,  'TextBlock' ) );

        $this->setupExpectedPositions( $parser, $text, $source, $items );

        try
        {
            $program = $parser->parseIntoNodeTree();
            self::fail( "No parse exception thrown" );
        }
        catch ( ezcTemplateSourceToTstParserException $e )
        {
        }

        $parser->verify();
    }

    /**
     * Test parsing template code contain all comment types.
     */
    public function testParsingAllCommentTypes()
    {
        self::assertThat( $this->templatePath . "comments_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "comments_test.tpl" );
        // $text = "abc def \n{show /*inside comment*/widget\n$w // eol comment\n}";
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        if ( $parser->debug )
            echo "\ncomments_test.tpl\n";

        $items = array( array( 'TextBlock' ),

                        array( 'DocComment', 'commentText', ' Documentation block ' ),

                        array( 'TextBlock' ),

                        array( 'Literal' ),
                        array( 'BlockComment', 'commentText', 'inside comment' ),
                        array( 'PlusOperator' ),
                        array( 'EolComment', 'commentText', 'eol comment' ),
                        array( 'Literal' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),

                        array( 'Literal' ),
                        array( 'EolComment', 'commentText', 'eol comment #2' ),
                        array( 'OutputBlock' ) );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing template code containing all builtin types except arrays.
     */
    public function testParseLiteralTypesExpression()
    {
        self::assertThat( $this->templatePath . "expression_types_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "expression_types_test.tpl" );
        // echo "\nexpression_types_test.tpl\n";
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        if ( $parser->debug )
            echo "\nexpression_types_test.tpl\n";

        $items = array( array( 'Literal', 'value', 1 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 42 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', -1234 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1.0 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', -4.2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 0.5 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', "1" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', "a short string" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', "a short \"quoted\" string" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', "1" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', "a short string" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', "a short \'quoted\' string" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', true ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', false ),
                        array( 'OutputBlock' ) );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing template code containing array types.
     * @todo This currently fails, remove return statement when it is fixed.
     */
    public function testParsingArrayExpression()
    {
        self::assertThat( $this->templatePath . "expression_array_types_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "expression_array_types_test.tpl" );
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        if ( $parser->debug )
            echo "\nexpression_array_types_test.tpl\n";

        $items = array( array( 'Literal', 'value', array() ),
                        array( 'OutputBlock' ) );

        $items_array1 = array( array( 'TextBlock' ),
                               array( 'Literal', 'value', 1 ),
                               array( 'Literal', 'value', 2 ),
                               array( 'Literal', 'value', 3 ),
                               array( 'Literal', 'value', array( 1, 2, 3 ) ),
                               array( 'OutputBlock' ) );

        $items = array_merge( $items,
                              $items_array1, $items_array1, $items_array1 );

        $items_array2 = array( array( 'TextBlock' ),
                               array( 'Literal', 'value', 0 ),
                               array( 'Literal', 'value', 1 ),
                               array( 'Literal', 'value', 1 ),
                               array( 'Literal', 'value', 2 ),
                               array( 'Literal', 'value', 2 ),
                               array( 'Literal', 'value', 3 ),
                               array( 'Literal', 'value', array( 0 => 1, 1 => 2, 2 => 3 ) ),
                               array( 'OutputBlock' ) );

        $items = array_merge( $items,
                              $items_array2, $items_array2, $items_array2 );

        $items_array3 = array( array( 'TextBlock' ),
                               array( 'Literal', 'value', "abc" ),
                               array( 'Literal', 'value', "def" ),
                               array( 'Literal', 'value', "foo" ),
                               array( 'Literal', 'value', "bar" ),
                               array( 'Literal', 'value', 5 ),
                               array( 'Literal', 'value', "el1" ),
                               array( 'Literal', 'value', "key1" ),
                               array( 'Literal', 'value', -50 ),
                               array( 'Literal', 'value', array( "abc" => "def", "foo" => "bar", 5 => "el1", "key1" => -50 ) ),
                               array( 'OutputBlock' ) );

        $items = array_merge( $items,
                              $items_array3, $items_array3, $items_array3 );

        $items_array4 = array( array( 'TextBlock' ),
                               array( 'Literal', 'value', 3 ),
                               array( 'Literal', 'value', array( 3 ) ),
                               array( 'Literal', 'value', 2 ),
                               array( 'Literal', 'value', array( array( 3 ), 2 ) ),
                               array( 'Literal', 'value', 1 ),
                               array( 'Literal', 'value', array( array( array( 3 ), 2 ), 1  ) ),
                               array( 'OutputBlock' ) );

        $items = array_merge( $items,
                              $items_array4 );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing template code containing variable statements.
     */
    public function testParsingVariablesExpression()
    {
        self::assertThat( $this->templatePath . "expression_variables_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "expression_variables_test.tpl" );
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        if ( $parser->debug )
            echo "\nexpression_variables_test.tpl\n";

        $items = array( array( 'Literal', 'value', 'var' ),
                        array( 'Variable', 'name', 'var' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'varName' ),
                        array( 'Variable', 'name', 'varName' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'var_name' ),
                        array( 'Variable', 'name', 'var_name' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'var_0_name' ),
                        array( 'Variable', 'name', 'var_0_name' ),
                        array( 'OutputBlock' ) );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing template code containing operators expressions.
     */
    public function testParsingOperatorExpression()
    {
        self::assertThat( $this->templatePath . "expression_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "expression_test.tpl" );
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        if ( $parser->debug )
            echo "\nexpression_test.tpl\n";

        $items = array( array( 'Literal', 'value', 'item' ),
                        array( 'Variable', 'name', 'item' ),
                        array( 'PropertyFetchOperator' ),
                        array( 'Literal', 'value', 'prop1' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'item' ),
                        array( 'Variable', 'name', 'item' ),
                        array( 'PropertyFetchOperator' ),
                        array( 'Literal', 'value', 0 ),
                        array( 'OutputBlock' ), // index 10

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'item' ),
                        array( 'Variable', 'name', 'item' ),
                        array( 'Literal', 'value', 'prop1' ),
                        array( 'ArrayFetchOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'item' ),
                        array( 'Variable', 'name', 'item' ),
                        array( 'Literal', 'value', 0 ), // index 20
                        array( 'ArrayFetchOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'item' ),
                        array( 'Variable', 'name', 'item' ),
                        array( 'Literal', 'value', 42 ),
                        array( 'ArrayFetchOperator' ),
                        array( 'PropertyFetchOperator' ),
                        array( 'Literal', 'value', 'subitem' ),
                        array( 'Literal', 'value', "test" ), // index 30
                        array( 'ArrayFetchOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'MultiplicationOperator' ), // index 40
                        array( 'Literal', 'value', 2 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'MinusOperator' ),
                        array( 'Literal', 'value', 4 ), // index 50
                        array( 'MultiplicationOperator' ),
                        array( 'Literal', 'value', 6 ),
                        array( 'DivisionOperator' ),
                        array( 'Literal', 'value', 'var' ),
                        array( 'Variable', 'name', 'var' ),
                        array( 'PropertyFetchOperator' ),
                        array( 'Literal', 'value', 'lines' ),
                        array( 'Literal', 'value', 0 ),
                        array( 'ArrayFetchOperator' ),
                        array( 'MinusOperator' ), // index 60
                        array( 'Literal', 'value', 5 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 100 ),
                        array( 'ConcatOperator' ),
                        array( 'Literal', 'value', "a" ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock') );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing operators with sub-expressions.
     */
    public function testParsingOperatorSubExpressions()
    {
        self::assertThat( $this->templatePath . "sub_expressions_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "sub_expressions_test.tpl" );
        // echo "\nsub_expressions_test.tpl\n";
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        $items = array( array( 'Literal', 'value', 1 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'MultiplicationOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'Parenthesis' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),

                        array( 'Literal', 'value', 1 ),
                        array( 'MultiplicationOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'MinusOperator' ),
                        array( 'Literal', 'value', 4 ),
                        array( 'DivisionOperator' ),
                        array( 'Literal', 'value', 200 ),
                        array( 'MultiplicationOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'Parenthesis' ),
                        array( 'Parenthesis' ),
                        array( 'Parenthesis' ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 5 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 'node' ),
                        array( 'Variable', 'name', 'node' ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 200 ),
                        array( 'Parenthesis' ),
                        array( 'OutputBlock' ) );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing all supported operators.
     */
    public function testParseOperators()
    {
        self::assertThat( $this->templatePath . "operators_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "operators_test.tpl" );
        $source = new ezcTemplateSourceCode( 'mock', 'mock', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        $items = array( array( 'Literal', 'value', 'obj' ),
                        array( 'Variable', 'name', 'obj' ),
                        array( 'PropertyFetchOperator' ),
                        array( 'Literal', 'value', 'prop' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'a' ),
                        array( 'Variable', 'name', 'a' ),
                        array( 'Literal', 'value', 0 ),
                        array( 'ArrayFetchOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'MinusOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'a' ),
                        array( 'ConcatOperator' ),
                        array( 'Literal', 'value', 'b' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'MultiplicationOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'DivisionOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'ModuloOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'EqualOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'EqualOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'NotEqualOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'NotEqualOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'IdenticalOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'IdenticalOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'NotIdenticalOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'NotIdenticalOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'LessThanOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'LessThanOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'GreaterThanOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'GreaterThanOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'LessEqualOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'LessEqualOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'GreaterEqualOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'GreaterEqualOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'LogicalAndOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'LogicalAndOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'LogicalOrOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'LogicalOrOperator' ),
                        array( 'Literal', 'value', 3 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'AssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PlusAssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'MinusAssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'MultiplicationAssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'DivisionAssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'ConcatAssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'ModuloAssignmentOperator' ),
                        array( 'Literal', 'value', 2 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'PreIncrementOperator' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'PreDecrementOperator' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PostIncrementOperator' ),
                        array( 'PlusOperator' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PostDecrementOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PostIncrementOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 1 ),
                        array( 'PostDecrementOperator' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'NegateOperator' ),
                        array( 'Literal', 'value', 'a' ),
                        array( 'Variable', 'name', 'a' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'LogicalNegateOperator' ),
                        array( 'Literal', 'value', 'a' ),
                        array( 'Variable', 'name', 'a' ),
                        array( 'OutputBlock' ),

                        array( 'TextBlock' ),
                        array( 'Literal', 'value', 'a' ),
                        array( 'Variable', 'name', 'a' ),
                        array( 'InstanceOfOperator' ),
                        array( 'Literal', 'value', 'b' ),
                        array( 'Variable', 'name', 'b' ),
                        array( 'OutputBlock' ),

                        );

        if ( $parser->debug )
            echo "\noperators_test.tpl\n";

//        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing the literal block and escaped text portions.
     */
    public function testParsingLiteralBlock()
    {
        self::assertThat( $this->templatePath . "literal_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "literal_test.tpl" );
        $source = new ezcTemplateSourceCode( 'literal_test.tpl', 'mock:literal_test.tpl', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        if ( $parser->debug )
            echo "\nliteral_test.tpl\n";

        $items = array( array( 'TextBlock', 'originalText', "some plain text\n\n" ),
                        array( 'LiteralBlock', 'originalText', "{literal}\n\nno { code } inside here\nand \\{ escaped \\} braces are kept\n{/literal}" ),
                        array( 'TextBlock', 'originalText', "\n\nand \\no/ \{ code \} here either\n" ),
                        );

        $this->setupExpectedElements( $parser, $text, $source, $items );

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing the foreach block.
     */
    public function testParsingForeachBlock()
    {
        self::assertThat( $this->templatePath . "foreach_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "foreach_test.tpl" );
        $source = new ezcTemplateSourceCode( 'foreach_test.tpl', 'mock:foreach_test.tpl', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );
//        $parser->debug = true;

        if ( $parser->debug )
            echo "\nforeach_test.tpl\n";

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo "\n\n", ezcTemplateTstTreeOutput::output( $program ), "\n";
        $parser->verify();
    }

    /**
     * Test parsing incorrect "foreach" blocks.
     */
    public function testParsingForeachBlock2()
    {
        $texts = array(
            '{foreach 1 as $i}{/foreach}',
            '{foreach $objects error $item}{/foreach}',
        );

        $nFailures = 0;
        foreach ( $texts as $i => $text )
        {
            $source = new ezcTemplateSourceCode( "while_test$i.tpl", "mock:while_test$i.tpl", $text );
            $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

            try
            {
                $program = $parser->parseIntoNodeTree();
                if ( $parser->debug )
                    echo "\n\n", ezcTemplateTstTreeOutput::output( $program ), "\n";
            }
            catch ( Exception $e )
            {
                $nFailures++;
            }

            $parser->verify();

            unset( $parser );
            unset( $source );
        }

        $nOk = count( $texts ) - $nFailures;
        if ( $nOk > 0 )
            $this->fail( "Parser did not fail on $nOk incorrect templates foreach_test2" );
    }


    /**
     * Test parsing the "while" block.
     */
    public function testParsingWhileBlock()
    {
        self::assertThat( $this->templatePath . "while_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "while_test.tpl" );
        $source = new ezcTemplateSourceCode( 'while_test.tpl', 'mock:while_test.tpl', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );
        // $parser->debug = true;

        if ( $parser->debug )
            echo "\nwhile_test.tpl\n";

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo "\n\n", ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();
    }

    /**
     * Test parsing incorrect do/while blocks.
     */
    public function testParsingWhileBlock2()
    {
        $texts = array(
            '{while}{/while}',
            '{while}',
        );

        $nFailures = 0;
        foreach ( $texts as $i => $text )
        {
            $ok = true;
            $source = new ezcTemplateSourceCode( "while_test$i.tpl", "mock:while_test$i.tpl", $text );
            $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

            try
            {
                $program = $parser->parseIntoNodeTree();
                if ( $parser->debug )
                    echo "\n\n", ezcTemplateTstTreeOutput::output( $program ), "\n";
            }
            catch ( Exception $e )
            {
                $nFailures++;
            }

            $parser->verify();

            unset( $parser );
            unset( $source );
        }

        $nOk = count( $texts ) - $nFailures;
        if ( $nOk > 0 )
            $this->fail( "Parser did not fail on $nOk incorrect templates while_test2" );
    }

    /**
     * Test parsing the "if" block.
     */
    public function testParsingIfBlock()
    {
        self::assertThat( $this->templatePath . "if_test.tpl", self::existsOnDisk() );

        $text = file_get_contents( $this->templatePath . "if_test.tpl" );
        $source = new ezcTemplateSourceCode( 'if_test.tpl', 'mock:if_test.tpl', $text );
        $parser = new MockElement_ezcTemplateParser( $source, $this->manager );

        // $parser->debug = true;

        if ( $parser->debug )
            echo "\nforeach_test.tpl\n";

        $program = $parser->parseIntoNodeTree();

        if ( $parser->debug )
            echo "\n\n", ezcTemplateTstTreeOutput::output( $program ), "\n";

        $parser->verify();

    }

    /**
     * Sets up expectations for reportElementCursor based on item list $items
     * which contains the start and ending position + expected class element.
     */
    public function setupExpectedElements( $parser, $text, $source, $items )
    {
        $index = 0;
        foreach ( $items as $item )
        {
            $class = 'ezcTemplate' . $item[0];
            if ( substr( $class, -15 ) != 'OperatorTstNode' )
                $class .= 'TstNode';
            if ( isset( $item[1] ) && isset( $item[2] ) )
            {
                $parser->expects( self::at( $index ) )
                    ->method( "reportElementCursor" )
                    ->with( self::anything(),
                            self::anything(),
                            self::logicalAnd( self::isInstanceOf( $class ),
                                              self::hasProperty( $item[1] )->that( self::identicalTo( $item[2] ) ) ) );
            }
            else
            {
                $parser->expects( self::at( $index ) )
                    ->method( "reportElementCursor" )
                    ->with( self::anything(),
                            self::anything(),
                            self::logicalAnd( self::isInstanceOf( $class ) ) );
            }
            ++$index;
        }
        $parser->expects( self::exactly( $index ) )
            ->method( "reportElementCursor" )
            ->withAnyParameters();
    }

    /**
     * Sets up expectations for reportElementCursor based on item list $items
     * which contains the start and ending position + expected class element.
     */
    public function setupExpectedPositions( $parser, $text, $source, $items )
    {
        $index = 0;
        foreach ( $items as $item )
        {
            $startCursor = new ezcTemplateCursor( $text, $item[0], $item[1], $item[2] );
            $endCursor = new ezcTemplateCursor( $text, $item[3], $item[4], $item[5] );
            $class = 'ezcTemplate' . $item[6];
            if ( substr( $class, -15 ) != 'OperatorTstNode' )
                $class .= 'TstNode';
            $element = new $class( $source, $startCursor, $endCursor );
            if ( isset( $item[7] ) && isset( $item[8] ) )
            {
                $property = $item[7];
                $element->$property = $item[8];
            }
            $parser->expects( self::at( $index ) )
                ->method( "reportElementCursor" )
                ->with( $startCursor, $endCursor, $element );
            $startCursor = $endCursor;
            ++$index;
        }
        $parser->expects( self::exactly( $index ) )
            ->method( "reportElementCursor" )
            ->withAnyParameters();
    }
}

?>

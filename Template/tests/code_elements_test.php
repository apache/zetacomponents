<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateCodeElementsTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateCodeElementsTest" );
    }

    protected function setUp()
    {
        // assignment operators
        $this->assignmentOperators = array( 'AdditionAssignment',
                                            'ConcatAssignment',
                                            'DivisionAssignment',
                                            'ModulusAssignment',
                                            'MultiplicationAssignment',
                                            'SubtractionAssignment',
                                            'Assignment' );
        // Unary operators before operand
        $this->unaryOperators = array( 'ArithmeticNegation',
                                       'LogicalNegation' );
        // Unary operators before/after operand
        $this->unaryPrePostOperators = array( 'Decrement',
                                              'Increment' );
        // Operators which are binary and logical
        $this->logicalOperators = array( 'Equal',
                                         'GreaterThan',
                                         'GreaterEqual',
                                         'Identical',
                                         'LessThan',
                                         'LessEqual',
                                         'NotEqual',
                                         'NotIdentical',
                                         'LogicalAnd',
                                         'LogicalOr' );
        // The binary operators, except array fetch which needs
        // special attention
        $this->binaryOperators = array( 'Addition',
                                        'Concat',
                                        'Division',
                                        'Modulus',
                                        'Multiplication',
                                        'Subtraction',
                                        'Concat',
                                        'Instanceof',
                                        'ObjectAccess' );
        $this->binaryOperators = array_merge( $this->binaryOperators, $this->assignmentOperators, $this->logicalOperators );
    }

    /**
     * Test all unary operators which are always placed in front of operands.
     */
    public function testUnaryOperators()
    {
        // Create with valid parameter count.
        foreach ( $this->unaryOperators as $operator )
        {
            $className = 'ezcTemplate' . $operator . 'OperatorAstNode';
            try
            {
                $operator = new $className();
                $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
                $operator->validate();
            }
            catch ( Exception $e )
            {
                self::fail( "Unary operator <{$className}> with one parameter should not throw an exception." );
            }
        }

        // Create with invalid parameter count.
        foreach ( $this->unaryOperators as $operator )
        {
            $className = 'ezcTemplate' . $operator . 'OperatorAstNode';

            $operator = new $className();
            $failed = false;
            try
            {
                $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
                $operator->appendParameter( new ezcTemplateVariableAstNode( "b" ) );
                $operator->validate();
                $failed = true;
            }
            catch ( Exception $e )
            {
            }
            if ( $failed )
            {
                self::fail( "Using two parameters only for unary operator <{$className}> does not throw an exception." );
            }

            $operator = new $className();
            $failed = false;
            try
            {
                $operator->validate();
                $failed = true;
            }
            catch ( Exception $e )
            {
            }
            if ( $failed )
            {
                self::fail( "Using no parameters for unary operator <{$className}> does not throw an exception." );
            }
        }
    }

    /**
     * Test all unary operators which can be placed in front or after operands.
     */
    public function testPrePostUnaryOperators()
    {
        // Create operator with valid parameter count.
        foreach ( $this->unaryPrePostOperators as $operator )
        {
            $className = 'ezcTemplate' . $operator . 'OperatorAstNode';
            try
            {
                $operator = new $className( true );
                $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
                $operator->validate();
            }
            catch ( Exception $e )
            {
                self::fail( "Pre unary operator <{$className}> with one parameter should not throw an exception." );
            }

            try
            {
                $operator = new $className( false );
                $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
                $operator->validate();
            }
            catch ( Exception $e )
            {
                self::fail( "Post unary operator <{$className}> with one parameter should not throw an exception." );
            }
        }

        // Create with invalid parameter count.
        foreach ( $this->unaryPrePostOperators as $operator )
        {
            $className = 'ezcTemplate' . $operator . 'OperatorAstNode';
            $operator = new $className( true );
            $failed = false;
            try
            {
                $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
                $operator->appendParameter( new ezcTemplateVariableAstNode( "b" ) );
                $operator->validate();
                $failed = true;
            }
            catch ( Exception $e )
            {
            }
            if ( $failed )
            {
                self::fail( "Using two parameters only for pre unary operator <{$className}> does not throw an exception." );
            }
            $operator = new $className( false );
            $failed = false;
            try
            {
                $operator->validate();
                $failed = true;
            }
            catch ( Exception $e )
            {
            }
            if ( $failed )
            {
                self::fail( "Using no parameters for pre unary operator <{$className}> does not throw an exception." );
            }

            $operator = new $className( false );
            $failed = false;
            try
            {
                $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
                $operator->appendParameter( new ezcTemplateVariableAstNode( "b" ) );
                $operator->validate();
                $failed = true;
            }
            catch ( Exception $e )
            {
            }
            if ( $failed )
            {
                self::fail( "Using two parameters only for post unary operator <{$className}> does not throw an exception." );
            }
            $operator = new $className( false );
            $failed = false;
            try
            {
                $operator->validate();
                $failed = true;
            }
            catch ( Exception $e )
            {
            }
            if ( $failed )
            {
                self::fail( "Using no parameters for post unary operator <{$className}> does not throw an exception." );
            }
        }
    }

    /**
     * Test the array fetch binary operator which needs special testing.
     */
    public function testArrayFetchOperator()
    {
        // Create with valid parameter count.
        $className = 'ezcTemplateArrayFetchOperatorAstNode';

        // Create with invalid parameter count.
        $operator = new $className();
        $failed = false;
        try
        {
            $operator->appendParameter( new ezcTemplateVariableAstNode( "a" ) );
            $operator->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "Using one parameter only for binary operator <{$className}> does not throw an exception." );
        }

        $operator = new $className();
        $failed = false;
        try
        {
            $operator->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "Using no parameters for binary operator <{$className}> does not throw an exception." );
        }
    }

    public function testEchoConstruct()
    {
        $type = new ezcTemplateLiteralAstNode( "text" );
        $outputList = array( $type );

        $construct = new ezcTemplateEchoAstNode( $outputList );
        self::assertSame( $outputList, $construct->getOutputList() );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "Echo construct with output parameters should not fail validation." );
        }

        $construct = new ezcTemplateEchoAstNode();
        $construct->appendOutput( $type );
        self::assertSame( $outputList, $construct->getOutputList() );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "Echo construct with appended output parameter should not fail validation." );
        }

        $construct = new ezcTemplateEchoAstNode();
        $failed = false;
        try
        {
            $construct->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "Echo construct without output parameters should fail validation." );
        }
    }

    public function testIssetConstruct()
    {
        $type = new ezcTemplateLiteralAstNode( "text" );
        $expressionList = array( $type );

        $construct = new ezcTemplateIssetAstNode( $expressionList );
        self::assertSame( $expressionList, $construct->getExpressions() );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "Isset construct with expressions should not fail validation." );
        }

        $construct = new ezcTemplateIssetAstNode();
        $construct->appendExpression( $type );
        self::assertSame( $expressionList, $construct->getExpressions() );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "Isset construct with appended expression should not fail validation." );
        }

        $construct = new ezcTemplateIssetAstNode();
        $failed = false;
        try
        {
            $construct->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "Isset construct without expressions should fail validation." );
        }
    }

    public function testUnsetConstruct()
    {
        $type = new ezcTemplateLiteralAstNode( "text" );
        $expressionList = array( $type );

        $construct = new ezcTemplateUnsetAstNode( $expressionList );
        self::assertSame( $expressionList, $construct->getExpressions() );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "Unset construct with expressions should not fail validation." );
        }

        $construct = new ezcTemplateUnsetAstNode();
        $construct->appendExpression( $type );
        self::assertSame( $expressionList, $construct->getExpressions() );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "Unset construct with appended expression should not fail validation." );
        }

        $construct = new ezcTemplateUnsetAstNode();
        $failed = false;
        try
        {
            $construct->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "Unset construct without expressions should fail validation." );
        }
    }

    public function testEmptyConstruct()
    {
        $type = new ezcTemplateLiteralAstNode( "text" );

        $construct = new ezcTemplateEmptyAstNode( $type );
        self::assertSame( $type, $construct->expression );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "'empty' construct with expression should not fail validation." );
        }

        $construct = new ezcTemplateEmptyAstNode();
        $construct->expression = $type;
        self::assertSame( $type, $construct->expression );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "'empty' construct with appended output parameter should not fail validation." );
        }

        $construct = new ezcTemplateEmptyAstNode();
        $failed = false;
        try
        {
            $construct->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "'empty' construct without output parameters should fail validation." );
        }
    }

    public function testPrintConstruct()
    {
        $type = new ezcTemplateLiteralAstNode( "text" );

        $construct = new ezcTemplatePrintAstNode( $type );
        self::assertSame( $type, $construct->expression );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "'print' construct with expression should not fail validation." );
        }

        $construct = new ezcTemplatePrintAstNode();
        $construct->expression = $type;
        self::assertSame( $type, $construct->expression );
        try
        {
            $construct->validate();
        }
        catch ( Exception $e )
        {
            self::fail( "'print' construct with appended output parameter should not fail validation." );
        }

        $construct = new ezcTemplatePrintAstNode();
        $failed = false;
        try
        {
            $construct->validate();
            $failed = true;
        }
        catch ( Exception $e )
        {
        }
        if ( $failed )
        {
            self::fail( "'print' construct without output parameters should fail validation." );
        }
    }
}
?>

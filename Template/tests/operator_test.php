<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcTemplateOperatorTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateOperatorTest" );
    }

    protected function setUp()
    {
        $source = new ezcTemplateSourceCode( '', '', '' );
        $start = new ezcTemplateCursor( '', 0, 1, 0 );
        $end = new ezcTemplateCursor( '', 0, 1, 0 );

        $this->operators = array();
        $this->operators[] = new ezcTemplateArrayFetchOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplatePropertyFetchOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplatePreIncrementOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplatePreDecrementOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplatePostIncrementOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplatePostDecrementOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplateNegateOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateLogicalNegateOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplateMultiplicationOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateDivisionOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateModuloOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplatePlusOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateMinusOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateConcatOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplateLessThanOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateGreaterThanOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateLessEqualOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateGreaterEqualOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplateEqualOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateNotEqualOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateIdenticalOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateNotIdenticalOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplateLogicalAndOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateLogicalOrOperatorTstNode( $source, $start, $end );

        $this->operators[] = new ezcTemplateAssignmentOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplatePlusAssignmentOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateMinusAssignmentOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateMultiplicationAssignmentOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateDivisionAssignmentOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateConcatAssignmentOperatorTstNode( $source, $start, $end );
        $this->operators[] = new ezcTemplateModuloAssignmentOperatorTstNode( $source, $start, $end );
    }

    /**
     * Test all precedence values, they must all be integers.
     */
    public function testPrecedenceIsInteger()
    {
        foreach ( $this->operators as $operator )
        {
            self::assertThat( $operator->precedence, self::isType( 'integer' ), "Precendence for operator <" . get_class( $operator ) . "> must be an integer." );
        }
    }

    /**
     * Test all predence values, they must all be larger than 0.
     */
    public function testPrecedenceIsInValidRange()
    {
        foreach ( $this->operators as $operator )
        {
            self::assertThat( $operator->precedence, self::greaterThan( 0 ), "Precendence for operator <" . get_class( $operator ) . "> must be 1 or higher." );
        }
    }

    /**
     * Test all predence values for gaps, this means an operator is missing or
     * a precedence has been wrongfully modified.
     */
    public function testAllPrecedencesHasNoGaps()
    {
        $levels = array();
        $min = false;
        $max = false;
        foreach ( $this->operators as $operator )
        {
            $levels[$operator->precedence] = true;
            if ( $max === false ||
                 $operator->precedence > $max )
                $max = $operator->precedence;
            if ( $min === false ||
                 $operator->precedence < $min )
                $min = $operator->precedence;
        }
        ksort( $levels );
        self::assertThat( count( $levels ), self::greaterThan( 1 ), "Level list did not even fill two items" );
        for ( $i = $min; $i <= $max; ++$i )
        {
            // We skip level 2 which is the ?: operator which is not supported
            if ( $i == 2 )
            {
                continue;
            }
            $this->assertArrayHasKey( $i, $levels );
        }
    }

}


?>

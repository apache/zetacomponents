<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

class TestSelect extends ezcQuerySelect
{
    // @todo: Do we need the below? We use them for testing now, but
    // they could come in handy if we want to manipulate SELECT queries in
    // Persistent Object.
    public function buildSelect()
    {
        return $this->selectString;
    }

    public function buildFrom()
    {
        return $this->fromString;
    }

    public function buildWhere()
    {
        return $this->whereString;
    }

    public function buildOrder()
    {
        return $this->orderString;
    }

    public function buildGroup()
    {
        return $this->groupString;
    }

    public function buildHaving()
    {
        return $this->havingString;
    }
    
    public function buildLimit()
    {
        return $this->limitString;
    }
}

/**
 * Testing the SQL abstraction layer.
 * This file tests that the methods actually produce correct output for the base
 * implementation regardless of how they methods are called. The _impl file tests
 * the same again, but with full SQL calls, only using one call type and on the database.
 *
 * @package Database
 * @subpackage Tests
 * @todo, test with null input values
 */
class ezcQuerySelectTest extends ezcTestCase
{
    private $q; // query
    private $e; // queryExpression

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->q = new TestSelect( $db );
        $this->e = $this->q->expr;
    }

    public function testBindAuto()
    {
//        $value = '1';
//        $value2 =& $this->q->bind( $value );
//        $value = '2';
//        echo $value2;
        $reference = 'WHERE id = :ezcValue1 AND id > :ezcValue2';
        $val1 = '';
        $val2 = '';
        $this->q->where( $this->e->eq( 'id', $this->q->bindParam( $val1 ) ),
                         $this->e->gt( 'id', $this->q->bindParam( $val2 ) ) );
        $this->assertEquals( $reference, $this->q->buildWhere() );
    }

    public function testBindManual()
    {
        $reference = 'WHERE id = :test1 AND id > :test2';
        $val1 = '';
        $val2 = '';
        $this->q->where( $this->e->eq( 'id', $this->q->bindParam( $val1, ':test1' ) ),
                         $this->e->gt( 'id', $this->q->bindParam( $val2, ':test2' ) ) );
        $this->assertEquals( $reference, $this->q->buildWhere() );
    }

    public function testSelectSingle()
    {
        $reference = 'SELECT column1';
        $this->q->select( 'column1' );
        $this->assertEquals( $reference, $this->q->buildSelect() );
    }

    public function testSelectMulti()
    {
        $reference = 'SELECT column1, column2, column3, column4';
        $this->q->select( 'column1', array( 'column2', 'column3' ), 'column4' );
        $this->assertEquals( $reference, $this->q->buildSelect() );
        $this->q->reset();

        $this->q->select( 'column1' )->select( array( 'column2', 'column3' ) )->select( 'column4' );
        $this->assertEquals( $reference, $this->q->buildSelect() );
    }

    public function testAliAs()
    {
        $reference = 'SELECT column1 AS col1';
        $this->q->select( $this->q->aliAs( 'column1', 'col1' ) );
        $this->assertEquals( $reference, $this->q->buildSelect() );
    }

    public function testFromSingle()
    {
        $reference = 'FROM table1';
        $this->q->from( 'table1' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testFromMulti()
    {
        $reference = 'FROM table1, table2, table3, table4';
        $this->q->from( 'table1', array( 'table2', 'table3' ), 'table4' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
        $this->q->reset();
        
        $this->q->from( 'table1' )->from( array( 'table2', 'table3' ), 'table4' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
        $this->q->reset();
        
        $this->q->from( 'table1' )->from( 'table2')->from( 'table3' )->from( 'table4' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testFromInvalid()
    {
        try
        {
            $this->q->select( '*' )->from();
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryVariableParameterException $e )
        {
            $expected = "The method 'from' expected at least 1 parameter but none were provided.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testInnerJoin()
    {
        $reference = "FROM table1 INNER JOIN table2 ON table1.id = table2.id";
        $this->q->from( $this->q->innerJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testInnerJoinExpressionParameter()
    {
        $reference = "FROM table1 INNER JOIN table2 ON table1.id = table2.id";
        $this->q->from( 'table1' )->innerJoin( 'table2', $this->e->eq( 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testInnerJoinOtherForm()
    {
        $reference = "FROM table1 INNER JOIN table2 ON table1.id = table2.id";
        $this->q->from( 'table1' )->innerJoin( 'table2', 'table1.id', 'table2.id' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testRightJoin()
    {
        $reference = "FROM table1 RIGHT JOIN table2 ON table1.id = table2.id";
        $this->q->from( $this->q->rightJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testRightJoinExpressionParameter()
    {
        $reference = "FROM table1 RIGHT JOIN table2 ON table1.id = table2.id";
        $this->q->from( 'table1' )->rightJoin( 'table2', $this->e->eq( 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testRightJoinOtherForm()
    {
        $reference = "FROM table1 RIGHT JOIN table2 ON table1.id = table2.id";
        $this->q->from( 'table1' )->rightJoin( 'table2', 'table1.id', 'table2.id' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testLeftJoin()
    {
        $reference = "FROM table1 LEFT JOIN table2 ON table1.id = table2.id";
        $this->q->from( $this->q->leftJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testLeftJoinExpressionParameter()
    {
        $reference = "FROM table1 LEFT JOIN table2 ON table1.id = table2.id";
        $this->q->from( 'table1' )->leftJoin( 'table2', $this->e->eq( 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testLeftJoinOtherForm()
    {
        $reference = "FROM table1 LEFT JOIN table2 ON table1.id = table2.id";
        $this->q->from( 'table1' )->leftJoin( 'table2', 'table1.id', 'table2.id' );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testInvalidInnerJoin()
    {
        try
        {
            $this->q->innerJoin( 'table1', 'table1.id', 'table2.id' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            return;
        }
        $this->fail( "Got no exception when an exception was expected" );
    }

    public function testInnerJoinInvalidArgumentsTypes()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->innerJoin( 'table1', 'table2', 'table1.id', array( 'table2.id' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Inconsistent types of arguments passed to innerJoin().";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testInnerJoinInvalidArgumentsNumber()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->innerJoin( 'table2' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Wrong argument count passed to innerJoin(): 1";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testInvalidRightJoin()
    {
        try
        {
            $this->q->rightJoin( 'table1', 'table1.id', 'table2.id' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            return;
        }
        $this->fail( "Got no exception when an exception was expected" );
    }

    public function testRightJoinInvalidArgumentsTypes()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->rightJoin( 'table1', 'table2', 'table1.id', array( 'table2.id' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Inconsistent types of arguments passed to rightJoin().";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testRightJoinInvalidArgumentsNumber()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->rightJoin( 'table2' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Wrong argument count passed to rightJoin(): 1";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testInvalidLeftJoin()
    {
        try
        {
            $this->q->leftJoin( 'table1', 'table1.id', 'table2.id' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            return;
        }
        $this->fail( "Got no exception when an exception was expected" );
    }

    public function testLeftJoinInvalidArgumentsTypes()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->leftJoin( 'table1', 'table2', 'table1.id', array( 'table2.id' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Inconsistent types of arguments passed to leftJoin().";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testLeftJoinInvalidArgumentsNumber()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->leftJoin( 'table2' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Wrong argument count passed to leftJoin(): 1";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testWhereSingle()
    {
        $reference = 'WHERE true';
        $this->q->where( 'true' );
        $this->assertEquals( $reference, $this->q->buildWhere() );
    }

    public function testWhereMulti()
    {
        $reference = 'WHERE true AND false';
        $this->q->where( 'true', 'false' );
        $this->assertEquals( $reference, $this->q->buildWhere() );
        $this->q->reset();

        $this->q->where( 'true' ) ->where( 'false' );
        $this->assertEquals( $reference, $this->q->buildWhere() );
    }


    public function testOrderBySingleDefault()
    {
        $reference = 'ORDER BY id';
        $this->q->orderBy( 'id' );
        $this->assertEquals( $reference, $this->q->buildOrder() );
    }

    public function testOrderBySingleDesc()
    {
        $reference = 'ORDER BY id DESC';
        $this->q->orderBy( 'id', ezcQuerySelect::DESC );
        $this->assertEquals( $reference, $this->q->buildOrder() );
    }

    public function testOrderByMulti()
    {
        $reference = 'ORDER BY id DESC, name';
        $this->q->orderBy( 'id', ezcQuerySelect::DESC )->orderBy( 'name' );
        $this->assertEquals( $reference, $this->q->buildOrder() );
    }

    public function testLimitNoOffset()
    {
        $reference = 'LIMIT 1';
        $this->q->limit( 1 );
        $this->assertEquals( $reference, $this->q->buildLimit() );
    }

    public function testLimitWithOffset()
    {
        $reference = 'LIMIT 1 OFFSET 2';
        $this->q->limit( 1, 2 );
        $this->assertEquals( $reference, $this->q->buildLimit() );
    }

    public function testGroupBySingle()
    {
        $reference = 'GROUP BY id';
        $this->q->groupBy( 'id' );
        $this->assertEquals( $reference, $this->q->buildGroup() );
    }

    public function testGroupByMulti()
    {
        $reference = 'GROUP BY id, name';
        $this->q->groupBy( 'id' )->groupBy( 'name' );
        $this->assertEquals( $reference, $this->q->buildGroup() );
    }

    public function testGroupByMultiSingleCall()
    {
        $reference = 'GROUP BY id, name';
        $this->q->groupBy( 'id', 'name' );
        $this->assertEquals( $reference, $this->q->buildGroup() );
    }

    public function testHavingSingle()
    {
        $reference = 'HAVING id > 1';
        $this->q->groupBy( 'id' )->having( $this->e->gt( 'id', 1 ) );
        $this->assertEquals( $reference, $this->q->buildHaving() );
    }

    public function testHavingInvalid()
    {
        try
        {
            $this->q->having( $this->e->gt( 'id', 1 ) );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "Invoking having() not immediately after groupBy().";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testHavingInvalidParameters()
    {
        try
        {
            $this->q->select( '*' )->from( 'table1' )
                 ->groupBy( 'id' )
                 ->having();
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryVariableParameterException $e )
        {
            $expected = "The method 'having' expected at least 1 parameter but none were provided.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testHavingMulti()
    {
        $reference = 'HAVING id > 1 AND name = John';
        $this->q->groupBy( 'id' )->having( $this->e->gt( 'id', 1 ) )
                                 ->having( $this->e->eq( 'name', 'John' ) );
        $this->assertEquals( $reference, $this->q->buildHaving() );
    }

    public function testHavingMultiSingleCall()
    {
        $reference = 'HAVING id > 1 AND name = John';
        $this->q->groupBy( 'id' )->having( $this->e->gt( 'id', 1 ), $this->e->eq( 'name', 'John' ) );
        $this->assertEquals( $reference, $this->q->buildHaving() );
    }

    // here follows the testing of the build methods
    public function testBuildFrom()
    {
        $reference = 'SELECT * FROM table';
        $this->q->select( '*' )->from( 'table' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhere()
    {
        $reference = 'SELECT * FROM table WHERE true';
        $this->q->select( '*' )->from( 'table' )->where( 'true' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhereGroup()
    {
        $reference = 'SELECT * FROM table WHERE true GROUP BY id';
        $this->q->select( '*' )->from( 'table' )
                ->where( 'true' )
                ->groupBy( 'id' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhereGroupOrder()
    {
        $reference = 'SELECT * FROM table WHERE true GROUP BY id ORDER BY name';
        $this->q->select( '*' )->from( 'table' )
                ->where( 'true' )
                ->groupBy( 'id' )
                ->orderBy( 'name' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhereGroupOrderLimit()
    {
        $reference = 'SELECT * FROM table WHERE true GROUP BY id ORDER BY name LIMIT 1';
        $this->q->select( '*' )->from( 'table' )
                ->where( 'true' )
                ->groupBy( 'id' )
                ->orderBy( 'name' )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhereOrderLimit()
    {
        $reference = 'SELECT * FROM table WHERE true ORDER BY name LIMIT 1';
        $this->q->select( '*' )->from( 'table' )
                ->where( 'true' )
                ->orderBy( 'name' )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhereGroupLimit()
    {
        $reference = 'SELECT * FROM table WHERE true GROUP BY id LIMIT 1';
        $this->q->select( '*' )->from( 'table' )
                ->where( 'true' )
                ->groupBy( 'id' )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromWhereGroupHavingLimit()
    {
        $reference = 'SELECT * FROM table WHERE true GROUP BY id HAVING id > 1 LIMIT 1';
        $this->q->select( '*' )->from( 'table' )
                ->where( 'true' )
                ->groupBy( 'id' )
                ->having( $this->e->gt( 'id', 1 ) )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromLimit()
    {
        $reference = 'SELECT * FROM table LIMIT 1';
        $this->q->select( '*' )->from( 'table' )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromDistinctAndNormal()
    {
        $reference = 'SELECT DISTINCT foo, bar FROM table';
        $this->q->selectDistinct( 'foo' )
                ->select( 'bar' )
                ->from( 'table' );

        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromNormalAndDistinct()
    {
        try
        {
            $this->q->select( 'foo' )
                    ->selectDistinct( 'bar' )
                    ->from( 'table' );
            $this->fail( 'Expected ezcQueryInvalidException.' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            return true;
        }
    }

    public function testBuildFromDistinct()
    {
        $reference = 'SELECT DISTINCT * FROM table';
        $this->q->selectDistinct( '*' )
                ->from( 'table' );

        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testBuildFromDistinctWhereOrderLimit()
    {
        $reference = 'SELECT DISTINCT * FROM table WHERE true ORDER BY name LIMIT 1';
        $this->q->selectDistinct( '*' )
                ->from( 'table' )
                ->where( 'true' )
                ->orderBy( 'name' )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testGetQueryInvalid()
    {
        try
        {
            $this->q->getQuery();
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcQueryInvalidException $e )
        {
            $expected = "select() was not called before getQuery().";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQuerySelectTest' );
    }
}
?>

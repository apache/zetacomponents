<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
    public function setUp()
    {
        $db = ezcDbInstance::get();
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
    }

    public function testInnerJoin()
    {
        $reference = "FROM table1 INNER JOIN table2 ON table1.id = table2.id";
        $this->q->from( $this->q->innerJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testRightJoin()
    {
        $reference = "FROM table1 RIGHT JOIN table2 ON table1.id = table2.id";
        $this->q->from( $this->q->rightJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
    }

    public function testLeftJoin()
    {
        $reference = "FROM table1 LEFT JOIN table2 ON table1.id = table2.id";
        $this->q->from( $this->q->leftJoin( 'table1', 'table2', 'table1.id', 'table2.id' ) );
        $this->assertEquals( $reference, $this->q->buildFrom() );
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
        $reference = 'LIMIT 1, 2';
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

    public function testBuildFromLimit()
    {
        $reference = 'SELECT * FROM table LIMIT 1';
        $this->q->select( '*' )->from( 'table' )
                ->limit( 1 );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    // multicalls
    public function testMultipleSelect()
    {
        try
        {
            $this->q->select( '*' )->select( '*' );
        }
        catch( ezcQueryException $e ) 
        {
            return;
        }
        $this->fail( "Two calls to select() did not fail" );
    }

    public function testMultipleFrom()
    {
        try
        {
            $this->q->from( 'id' )->from( 'id' );
        }
        catch( ezcQueryException $e )
        {
            return;
        }
        $this->fail( "Two calls to from() did not fail" );
    }

    public function testMultipleWhere()
    {
        try
        {
            $this->q->where( 'id' )->where( 'id' );
        }
        catch( ezcQueryException $e )
        {
            return;
        }
        $this->fail( "Two calls to where() did not fail" );
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcQuerySelectTest' );
    }
}
?>

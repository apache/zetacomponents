<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

class TestSubSelect extends ezcQuerySelect
{
    public $db;

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
class ezcQuerySubSelectTest extends ezcTestCase
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

        $this->q = new TestSubSelect( $db );
        $this->e = $this->q->expr;
    }

    public function testSubSelect()
    {
        $reference = '( SELECT column FROM table WHERE id = 1 )';
        $q2 = $this->q->subSelect();
        $q2->select( 'column' )->from( 'table' )->where($q2->expr->eq('id', 1 ) );

        $this->assertEquals( $reference, $q2->getQuery() );
    }

    public function testSubSelectNotQuoted()
    {
        $reference = 'SELECT * FROM test_table WHERE id IN ( SELECT column FROM sub_table WHERE id = 1 )';
        $this->q->select( '*' )
                ->from( 'test_table' );

        $subQ = $this->q->subSelect();
        $subQ->select( 'column' )
           ->from( 'sub_table' )
           ->where( $subQ->expr->eq( 'id', 1 ) );

        $this->q->where( $this->q->expr->in( 'id', $subQ ) );

        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testSubSubSelect()
    {
        $reference = '( SELECT column FROM table WHERE id = ( SELECT * FROM table2 ) )';
        $q2 = $this->q->subSelect();
        $q3 = $q2->subSelect();
        $q3->select( '*' )->from( 'table2' );
        $q2->select( 'column' )->from( 'table' )->where($q2->expr->eq('id', $q3->getQuery() ) );

        $this->assertEquals( $reference, $q2->getQuery() );
    }

    public function testDistinctSubSelect()
    {
        $reference = 'SELECT DISTINCT * FROM table WHERE id = ( SELECT DISTINCT column FROM table2 )';

        $q2 = $this->q->subSelect();
        $q2->selectDistinct( 'column' )->from( 'table2' );
        $this->q
            ->selectDistinct( '*' )
            ->from( 'table' )
            ->where( 
                $this->q->expr->eq( 'id', $q2->getQuery() )
            );

        $this->assertEquals( $reference, $this->q->getQuery() );

    }

    public function testSubSelectIn()
    {
        $reference = 'SELECT * FROM table WHERE id IN ( SELECT column FROM table2 )';

        $q2 = $this->q->subSelect();
        $q2->select( 'column' )->from( 'table2' );
        $this->q
            ->select( '*' )
            ->from( 'table' )
            ->where( 
                $this->q->expr->in( 'id', $q2 )
            );

        $this->assertEquals( $reference, $this->q->getQuery() );

    }

    public function testBindAuto()
    {
        $val1 = '';
        $val2 = '';
        
        $reference = '( SELECT column FROM table WHERE id = :ezcValue1 AND id2 = :ezcValue2 )';
        $q2 = $this->q->subSelect();
        $q2->select( 'column' )
             ->from( 'table' )
               ->where( $q2->expr->eq( 'id', $q2->bindParam( $val1 ) ) )
               ->where( $q2->expr->eq( 'id2', $q2->bindParam( $val2 ) ) );

        $this->assertEquals( $reference, $q2->getQuery() );
    }

    public function testBindManual()
    {
        $reference = '( SELECT column FROM table WHERE id = :test1 AND id2 = :test2 )';
        $val1 = '';
        $val2 = '';
        $q2 = $this->q->subSelect();
        $q2->select( 'column' )
             ->from( 'table' )
               ->where( $q2->expr->eq( 'id', $q2->bindParam( $val1, ':test1' ) ) )
               ->where( $q2->expr->eq( 'id2', $q2->bindParam( $val2, ':test2' ) ) );

        $this->assertEquals( $reference, $q2->getQuery() );
    }

    public function testBug11784()
    {
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery();
        $q->select( 'somecol' )->from( 'quiz' );

        $qQuestions = $q->subSelect();
        $qQuestions->select( 'id' )->from( 'question' )->where(
            $qQuestions->expr->eq( 'quiz', $qQuestions->bindValue( 1 ) )
        );

        $q->where(
            $q->expr->in( 'question', $qQuestions )
        );
        
        $this->assertEquals( "SELECT somecol FROM quiz WHERE question IN ( SELECT id FROM question WHERE quiz = :ezcValue1 )", $q->getQuery() );
    }

    public function testSubselectWithUpdate()
    {
        $db = ezcDbInstance::get();
        $q = $db->createUpdateQuery();
        $q->update( 'quiz' )->set( 'somecol', $q->bindValue( 'test' ) );

        $qQuestions = $q->subSelect();
        $qQuestions->select( 'id' )->from( 'question' )->where(
            $qQuestions->expr->eq( 'quiz', $qQuestions->bindValue( 1 ) )
        );

        $q->where(
            $q->expr->in( 'question', $qQuestions )
        );

        $this->assertEquals( "UPDATE quiz SET somecol = :ezcValue1 WHERE question IN ( SELECT id FROM question WHERE quiz = :ezcValue2 )", $q->getQuery() );
    }


    public function testSubselectWithDelete()
    {
        $db = ezcDbInstance::get();
        $q = $db->createDeleteQuery();
        $q->deleteFrom( 'quiz' );

        $qQuestions = $q->subSelect();
        $qQuestions->select( 'id' )->from( 'question' )->where(
            $qQuestions->expr->eq( 'quiz', $qQuestions->bindValue( 1 ) )
        );

        $q->where(
            $q->expr->in( 'question', $qQuestions )
        );

        $this->assertEquals( "DELETE FROM quiz WHERE question IN ( SELECT id FROM question WHERE quiz = :ezcValue1 )", $q->getQuery() );
    }

    // Verifies issue #11784 is fixed. Code taken from there.
    public function testSubselectNotQuotedInInExpr()
    {
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery();
        $q->select( 'somecol' )->from( 'quiz' );

        $qQuestions = $q->subSelect();
        $qQuestions->select( 'id' )->from( 'question' )->where(
            $qQuestions->expr->eq( 'quiz', $qQuestions->bindValue( 1 ) )
        );

        $q->where(
            $q->expr->in( 'question', $qQuestions )
        );

        $this->assertEquals(
            'SELECT somecol FROM quiz WHERE question IN ( SELECT id FROM question WHERE quiz = :ezcValue1 )',
            $q->getQuery()
        );
    }


    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQuerySubSelectTest' );
    }
}
?>

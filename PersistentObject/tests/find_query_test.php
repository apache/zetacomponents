<?php

class ezcPersistentFindQueryTest extends ezcTestCase
{
    protected $db;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        try
        {
            $this->db = ezcDbFactory::create( 'sqlite://:memory:' );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'Missing SQLite support to use query abstraction.' );
        }
    }

    public function tearDown()
    {
        unset( $this->db );
    }

    public function testCtor()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';

        $findQuery = new ezcPersistentFindQuery( $q, $cn );

        $this->assertAttributeEquals(
            array(
                'className' => $cn,
                'query'     => $q,
            ),
            'properties',
            $findQuery
        );
    }

    public function testSetOwnPropertiesFailure()
    {
        $findQuery = $this->createFindQuery();

        try
        {
            $findQuery->query = 'some thing';
            $this->fail( 'Exception not thrown on set access to property $query.' );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            $this->assertEquals(
                "The property 'query' is read-only.",
                $e->getMessage()
            );
        }

        try
        {
            $findQuery->className = 'some thing';
            $this->fail( 'Exception not thrown on set access to property $className.' );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            $this->assertEquals(
                "The property 'className' is read-only.",
                $e->getMessage()
            );
        }
    }

    public function testSetQueryPropertiesFailure()
    {
        $findQuery = $this->createFindQuery();

        try
        {
            $findQuery->someProperty = 'foo';
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testSetQueryPropertiesSuccess()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $findQuery = new ezcPersistentFindQuery( $q, $cn );

        $expr = new ezcQueryExpression( $this->db );

        $findQuery->expr = $expr;

        $this->assertSame(
            $expr,
            $q->expr
        );
    }

    public function testGetOwnPropertiesSuccess()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $findQuery = new ezcPersistentFindQuery( $q, $cn );
        
        $this->assertEquals(
            'myCustomClassName',
            $findQuery->className
        );
        $this->assertSame(
            $q,
            $findQuery->query
        );
    }

    public function testGetQueryPropertiesSuccess()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';
        $findQuery = new ezcPersistentFindQuery( $q, $cn );
        
        $this->assertEquals(
            new ezcQueryExpressionSqlite( $this->db ),
            $findQuery->query->expr
        );
    }

    public function testGetPropertiesFailure()
    {
        $findQuery = $this->createFindQuery();

        try
        {
            echo $findQuery->fooBar;
            $this->fail( 'Exception not thrown on get access to non-existent property $fooBar.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetOwnPropertiesSuccess()
    {
        $findQuery = $this->createFindQuery();

        $this->assertTrue(
            isset( $findQuery->query )
        );
        $this->assertTrue(
            isset( $findQuery->className )
        );
    }

    public function testIssetQueryPropertiesSuccess()
    {
        $findQuery = $this->createFindQuery();

        $this->assertTrue(
            isset( $findQuery->expr )
        );
    }

    public function testIssetPropertiesFailure()
    {
        $findQuery = $this->createFindQuery();

        $this->assertFalse(
            isset( $findQuery->fooBar )
        );
    }

    public function testDelegateSuccess()
    {
        $q = $this->getMock(
            'ezcQuerySelect',
            array( 'reset', 'alias', 'select' ),
            array(),
            '',
            false,
            false
        );
        $q->expects( $this->once() )
           ->method( 'reset' )
           ->will( $this->returnValue( 23 ) );
        $q->expects( $this->once() )
           ->method( 'alias' )
           ->with( 'someName', 'someAlias' );
        $q->expects( $this->never() )->method( 'select' );

        $cn = 'myCustomClassName';
        
        $findQuery = new ezcPersistentFindQuery( $q, $cn );
        
        $this->assertEquals(
            23,
            $findQuery->reset()
        );
        
        $this->assertNull(
            $findQuery->alias( 'someName', 'someAlias' )
        );
    }

    protected function createFindQuery()
    {
        $q = new ezcQuerySelect( $this->db );
        $cn = 'myCustomClassName';

        return new ezcPersistentFindQuery( $q, $cn );
    }
}

?>

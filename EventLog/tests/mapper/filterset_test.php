<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package EventLog
 * @subpackage Tests
 */

/**
 * @package EventLog
 * @subpackage Tests
 */
class ezcLogFilterSetTest extends ezcTestCase
{
	private $map;

	protected function setUp()
	{
		$this->map = new ezcLogFilterSet();
	}
   
    public function testMapSimple()
    {
        $rule = new ezcLogFilterRule( new ezcLogFilter( 1 | 2, array("A", "B"), array("C1") ), "result1", true);
        $this->map->appendRule( $rule );
        $this->assertEquals(array("result1"), $this->map->get(2, "A", "C1") );

        $rule = new ezcLogFilterRule( new ezcLogFilter( 1, array( "C" ), array( "C1") ), "result2", true );
        $this->map->appendRule( $rule );
        // $this->map->map(1, array("C"), array("C1"), "result2");
        $this->assertEquals(array("result2"), $this->map->get(1, "C", "C1") );
        $this->assertEquals(array(), $this->map->get(2, "C", "C1") );
    }
    
    public function testMapMultiple()
    {
        $this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1 | 2, array("A", "B"), array("C1") ), "result1", true ) );
        $this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1, array("B"), array("C1") ), "result2", true ) );

        // $this->map->map(1 | 2, array("A", "B"), array("C1"), "result1");
        // $this->map->map(1, array("B"), array("C1"), "result2");

        $this->assertEquals(array("result1", "result2"), $this->map->get(1, "B", "C1") );

    }

    public function testMapMultiple2()
    {
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1 | 2, array(), array("Category1") ), "A", true ) );
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array(), array("Category1") ), "B", true ) );
        $this->assertEquals(array("A", "B"), $this->map->get(2, "source", "Category1"));
    }
 
    public function testMapAll()
    {
        $this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array("A", "B"), array("C1") ), "result1", true) );
        $this->assertEquals(array("result1"), $this->map->get(1, "B", "C1") );
        $this->assertEquals(array("result1"), $this->map->get(2, "B", "C1") );
        $this->assertEquals(array(), $this->map->get(2, "C", "C1") );
    }

    
	public function testGetObjectString()
	{
    	$this->map->appendRule( new ezcLogFilterRule(  new ezcLogFilter( 1 | 2 | 8, array("Source1", "Source2"), array("Category1") ), "object1", true ) );
		$this->map->appendRule( new ezcLogFilterRule(  new ezcLogFilter( 4 , array("Source2"), array("Category1") ),  "object2", true ) );
		$this->map->appendRule( new ezcLogFilterRule(  new ezcLogFilter( 32 , array("Source2"), array("Category1") ), "object2", true ) );

		$this->assertEquals(array("object1"), $this->map->get( 2, "Source1", "Category1" ) ); 
		$this->assertEquals(array("object1"), $this->map->get( 2, "Source2", "Category1" ) ); 
	    $this->assertEquals(array(), $this->map->get( 2, "Source2", "aha" ) ); 

		$this->assertEquals(array("object2"), $this->map->get( 4, "Source2", "Category1" ) ); 

		$this->map->appendRule( new ezcLogFilterRule(  new ezcLogFilter( 4 , array("Source3"), array("Category2") ), "object3", true ) );

		$this->assertEquals(array("object3"), $this->map->get( 4, "Source3", "Category2" ) ); 
		$this->assertEquals(array(), $this->map->get( 2, "Source3", "Category2" ) ); 

		// Add extra objects.
		$this->assertEquals(array("object3"), $this->map->get( 4, "Source3", "Category2" ) ); 
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 4, array("Source3"), array("Category2") ), "Override", true) );

		$this->assertEquals(array("object3", "Override"), $this->map->get( 4, "Source3", "Category2" ) ); 
	}
   
    
	public function testGetObjectObject()
	{
        // Add a new object
        $myObject = new SimpleObject();
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1, array("Source1", "Source2"), array("Category1") ), $myObject, true ) );

        // Fetch the object.
		$objArray = $this->map->get(1, "Source2", "Category1");
        $obj = $objArray[0];
        $this->assertNotNull($obj);
        $this->assertSame($obj, $myObject,  "Returned object isn't exactly the same instance.");
		$this->assertEquals("Hello world", $obj->getHelloWorld());
	}

    public function testGetVarious()
    {
        $this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1 | 2 | 4 | 8, array("A", "B"), array("C") ),  "object1", true) );
  		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter(  4 , array("Source2"), array("Category1") ),  "object2", true ) );
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter(  32 , array("Source2"), array("Category1") ),  "object2", true ) );

        $this->assertEquals(array("object1"), $this->map->get( 2, "A", "C") );
    }

    public function testMatchAll()
    {
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1 | 2, array(), array("Category1") ), "A", true ) );
        $this->assertEquals(array("A"), $this->map->get(2, "source", "Category1"));

        $this->assertEquals(array(), $this->map->get(4, "source", "Category1"));

		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array(), array("Category1") ), "B", true ) );
        $this->assertEquals(array("A", "B"), $this->map->get(2, "source", "Category1"));
        $this->assertEquals(array( "B" ), $this->map->get(4, "source", "Category1"));

		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array(), array() ), "C", true ) );

        $this->assertEquals(array("A", "B", "C"), $this->map->get(2, "source", "Category1"));
        $this->assertEquals(array("C"), $this->map->get(2, "source", "Category2"));
    }
   
    public function testStopProcessing()
    {
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter(  2, array("A"), array("p") ) , array(), false ) );
    	$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 1 | 2, array("A", "B"), array("p") ), "OneItem", true ) );
        $this->assertEquals( array(), $this->map->get( 2, "A", "p" ) );
    }
    
    public function testMinusOneMatching()
    {
        $this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array("Bibit"), array() ), array(), false ) );
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array("Paynet", "Bibit", "Paypal"), array() ), "All Payment systems", true ) );

        
        $this->assertEquals( array("All Payment systems"), $this->map->get( 1, "Paynet", "payment madness" ) );
        $this->assertEquals( array(), $this->map->get( 1, "Content", "payment madness" ) );
        $this->assertEquals( array(), $this->map->get( 1, "Bibit", "payment madness" ) );
        $this->assertEquals( array("All Payment systems"), $this->map->get( 1, "Paypal", "payment madness" ) );

        $this->assertEquals( array("All Payment systems"), $this->map->get( 2, "Paynet", "payment madness" ) );
    }

    public function testDeleteLastRule()
    {
        $this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array("Bibit"), array() ), array("First rule"), false ) );
		$this->map->appendRule( new ezcLogFilterRule( new ezcLogFilter( 0, array("Paynet", "Bibit", "Paypal"), array() ), "Second rule", true ) );

        $this->assertEquals( array("Second rule"), $this->map->get( 1, "Paynet", "payment madness" ) );
        $this->assertEquals( array("First rule"), $this->map->get( 1, "Bibit", "payment madness" ) );
 
        $this->assertTrue( $this->map->deleteLastRule() );
        $this->assertEquals( array(), $this->map->get( 1, "Paynet", "payment madness" ) );
        $this->assertEquals( array("First rule"), $this->map->get( 1, "Bibit", "payment madness" ) );

        $this->assertTrue( $this->map->deleteLastRule() );
        $this->assertEquals( array(), $this->map->get( 1, "Paynet", "payment madness" ) );
        $this->assertEquals( array(), $this->map->get( 1, "Bibit", "payment madness" ) );

        $this->assertFalse( $this->map->deleteLastRule() );

    }

    public function testReuseLogFilter()
    {
        $filter = new ezcLogFilter( 0, array("A"), array() );
        $this->map->appendRule( new ezcLogFilterRule( $filter, array("A"), false ) );

        $filter->source = array("B"); 
        $this->map->appendRule( new ezcLogFilterRule( $filter, array("B"), false ) );

        $this->assertEquals( array("A"), $this->map->get(1, "A", "z" ) );
        $this->assertEquals( array("B"), $this->map->get(1, "B", "z" ) );
    }

/*
    public function testLoggingMap()
    {
        $this->map->map( 1 | 2 | 4, array(), array(), "logging.log" );
        $this->map->map( 2 | 4, array(), array(), "critical.log" );
        $this->map->map( 0, array("content"), array("templates"), "content_templates.log");
        $this->map->get(2, "content", "templates");

        $this->assertEquals(array("content_templates.log", "logging.log", "critical.log"), $this->map->get(2, "content", "templates"));
    }

    public function testAdd()
    {
        $this->map->map(2 | 4, array(), array(), "Audits");
        $this->map->map( 0, array(), array(), "TheRest");

        $this->assertEquals( array("TheRest"), $this->map->get( 1, "A", "B" ) );
        $this->assertEquals( array("Audits", "TheRest"), $this->map->get( 2, "A", "B" ) );
        $this->assertEquals( array("Audits", "TheRest"), $this->map->get( 4, "A", "B" ) );
        $this->assertEquals( array("TheRest"), $this->map->get( 8, "A", "B" ) );
        $this->assertEquals( array("TheRest"), $this->map->get( 16, "A", "B" ) );
    }

    public function testRemove()
    {
        $this->map->map( 0, array(), array(), "TheRest");
        $this->map->unmap( 2| 4, array(), array(), "TheRest");

        $this->assertEquals( array("TheRest"), $this->map->get( 1, "A", "B" ) );
        $this->assertEquals( array(), $this->map->get( 2, "A", "B" ) );
        $this->assertEquals( array(), $this->map->get( 4, "A", "B" ) );
        $this->assertEquals( array("TheRest"), $this->map->get( 8, "A", "B" ) );
        $this->assertEquals( array("TheRest"), $this->map->get( 16, "A", "B" ) );
    }
 
    public function testAddAndRemove()
    {
        $this->map->map(2 | 4, array(), array(), "Audits");
        $this->map->map( 0, array(), array(), "TheRest");
        $this->map->unmap( 2| 4, array(), array(), "TheRest");

        $this->assertEquals( array("TheRest"), $this->map->get( 1, "A", "B" ) );
        $this->assertEquals( array("Audits"),  $this->map->get( 2, "A", "B" ) );
        $this->assertEquals( array("Audits"),  $this->map->get( 4, "A", "B" ) );
        $this->assertEquals( array("TheRest"), $this->map->get( 8, "A", "B" ) );
        $this->assertEquals( array("TheRest"), $this->map->get( 16, "A", "B" ) );
    }

    */
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite(__CLASS__);
	}
}

class SimpleObject
{
	function getHelloWorld()
	{
		return "Hello world";
	}
}





























?>

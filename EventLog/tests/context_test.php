<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcLogContextTest extends ezcTestCase
{
    protected $context;

    protected function setUp()
    {
        $this->context = new ezcLogContext();
    }
    
    public function testEventTypeGetSet()
    {
        $this->context->setSeverityContext( 2 | 4 | 16, array( "Username" => "Bart Simpson", 
                                                                "Radio station" => "SlayRadio" ) );

        $this->assertEquals(array( "Username" => "Bart Simpson", "Radio station" => "SlayRadio"), $this->context->getContext( 4, "anything") );

        $this->context->setSeverityContext( 1 | 32, array( "Car" => "Red Ferrari" ) );
        $this->assertEquals(array( "Car" => "Red Ferrari" ), $this->context->getContext( 1, "anything") );
    }

    public function testEventTypeAddMultiple()
    {
        $this->context->setSeverityContext( 2 | 4 | 16, array( "A" => "a") );
        $this->context->setSeverityContext( 4 | 8 | 16, array( "B" => "b") );
        $this->context->setSeverityContext( 8 | 16| 32, array( "C" => "c", "D" => "d") );

        $this->assertEquals(array( "A" => "a" ) , $this->context->getContext( 2, "anything" ) );
        $this->assertEquals(array( "A" => "a", "B" => "b" ) , $this->context->getContext( 4, "anything" ) );
        $this->assertEquals(array( "B" => "b", "C" => "c", "D" => "d" ) , $this->context->getContext( 8, "anything" ) );
        $this->assertEquals(array( "A" => "a", "B" => "b", "C" => "c", "D" => "d" ) , $this->context->getContext( 16, "anything" ) );
        $this->assertEquals(array( "C" => "c", "D" => "d" ) , $this->context->getContext( 32, "anything" ) );
    }

    public function testEventTypeNotExist()
    {
        $this->assertEquals(array() , $this->context->getContext( 2, "anything" ) );

        $this->context->setSeverityContext( 2 | 4 | 16, array( "A" => "a") );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 16, "anything" ) );

        $this->assertEquals( array(), $this->context->getContext( 8, "anything" ) );
    }
    
    public function testEventTypeOverride()
    {
        $this->context->setSeverityContext( 2 | 4 | 16, array( "A" => "a") );
        $this->context->setSeverityContext( 2 | 16, array( "A" => "b") );
        $this->assertEquals( array( "A" => "b" ), $this->context->getContext( 16, "anything" ) );
        $this->assertEquals( array( "A" => "b" ), $this->context->getContext( 2, "anything" ) );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 4, "anything" ) );
    }

    public function testEventTypeDelete()
    {
        $this->context->setSeverityContext( 2 | 4 | 16, array( "A" => "a") );
        $this->context->unsetSeverityContext( 4 | 16 | 32 );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, "anything" ) );
        $this->assertEquals( array(), $this->context->getContext( 4, "anything" ) );
        $this->assertEquals( array(), $this->context->getContext( 16, "anything" ) );
        $this->assertEquals( array(), $this->context->getContext( 32, "anything" ) );
    }
     
   // //////////////// Same tests but now for the event source // /////////////////////// 

    public function testEventSourceGetSet()
    {
        $this->context->setSourceContext( array("s2", "s4", "s16"), array( "Username" => "Bart Simpson", 
                                                                "Radio station" => "SlayRadio" ) );

        $this->assertEquals(array( "Username" => "Bart Simpson", "Radio station" => "SlayRadio"), $this->context->getContext( 1, "s4") );

        $this->context->setSourceContext( array( "s1", "s32" ), array( "Car" => "Red Ferrari" ) );
        $this->assertEquals(array( "Car" => "Red Ferrari" ), $this->context->getContext( 1, "s1") );
    }

    public function testEventSourceAddMultiple()
    {
        $this->context->setSourceContext( array( "s2", "s4",  "s16" ), array( "A" => "a") );
        $this->context->setSourceContext( array( "s4", "s8",  "s16" ), array( "B" => "b") );
        $this->context->setSourceContext( array( "s8", "s16", "s32" ), array( "C" => "c", "D" => "d") );

        $this->assertEquals(array( "A" => "a" ) , $this->context->getContext( 2, "s2" ) );
        $this->assertEquals(array( "A" => "a", "B" => "b" ) , $this->context->getContext( 4, "s4" ) );
        $this->assertEquals(array( "B" => "b", "C" => "c", "D" => "d" ) , $this->context->getContext( 8, "s8" ) );
        $this->assertEquals(array( "A" => "a", "B" => "b", "C" => "c", "D" => "d" ) , $this->context->getContext( 16, "s16" ) );
        $this->assertEquals(array( "C" => "c", "D" => "d" ) , $this->context->getContext( 32, "s32" ) );
    }

    public function testEventSourceNotExist()
    {
        $this->assertEquals(array() , $this->context->getContext( 2, "s2" ) );

        $this->context->setSourceContext( array( "s2", "s4", "s16" ), array( "A" => "a") );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 16, "s16" ) );

        $this->assertEquals( array(), $this->context->getContext( 8, "s8" ) );
    }
    
    public function testEventSourceOverride()
    {
        $this->context->setSourceContext( array( "s2", "s4", "s16" ), array( "A" => "a") );
        $this->context->setSourceContext( array( "s2", "s16" ), array( "A" => "b") );
        $this->assertEquals( array( "A" => "b" ), $this->context->getContext( 16, "s16" ) );
        $this->assertEquals( array( "A" => "b" ), $this->context->getContext( 2, "s2" ) );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 4, "s4" ) );
    }

    public function testEventSourceDelete()
    {
        $this->context->setSourceContext( array( "s2", "s4", "s16" ), array( "A" => "a") );
        $this->context->unsetSourceContext( array("s4","s16", "s32") );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, "s2" ) );
        $this->assertEquals( array(), $this->context->getContext( 4, "s4" ) );
        $this->assertEquals( array(), $this->context->getContext( 16, "s16" ) );
        $this->assertEquals( array(), $this->context->getContext( 32, "s32" ) );
    }
 


    public function testEventSourceStrangeNames()
    {
        $this->context->setSourceContext( array( 2, "s2", "A name", "A pretty long name for a source", 
                                                    "using `quotes` and 'stuff' like \"that\"" ), array( "A" => "a") );

        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, "s2" ) );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, 2 ) );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, "A name" ) );
        $this->assertEquals( array( ), $this->context->getContext( 2, "Doesn't exist" ) );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, "A pretty long name for a source" ) );
        $this->assertEquals( array( "A" => "a" ), $this->context->getContext( 2, "using `quotes` and 'stuff' like \"that\"" ) );
    }
 
   // //////////////// Testing both  // ////////////////////// 

   public function testCombination()
   {
        $this->context->setSourceContext( array( "s2", "s4", "s16" ), array( "A" => "a") );
        $this->context->setSeverityContext( 1 | 2 | 8, array( "B" => "b") );

        $this->assertEquals( array( "B" => "b", "A" => "a" ), $this->context->getContext( 2, "s2" ) );
        $this->assertEquals( array( "B" => "b", "A" => "a" ), $this->context->getContext( 1, "s4" ) );
        $this->assertEquals( array( "B" => "b"), $this->context->getContext( 1, "SlayRadio" ) );
        $this->assertEquals( array( "A" => "a"), $this->context->getContext( 42, "s16" ) );
        $this->assertEquals( array( ), $this->context->getContext( 32, "s32" ) );
   }

   public function testReset()
   {
        $this->context->setSourceContext( array( "s2", "s4", "s16" ), array( "A" => "a") );
        $this->context->setSeverityContext( 1 | 2 | 8, array( "B" => "b") );

        $this->assertEquals( array( "B" => "b", "A" => "a" ), $this->context->getContext( 2, "s2" ) );

        $this->context->reset();
        $this->assertEquals( array(), $this->context->getContext( 2, "s2" ) );

        $this->context->setSourceContext( array( "s2", "s4", "s16" ), array( "A" => "a") );
        $this->context->setSeverityContext( 1 | 2 | 8, array( "C" => "c") );
        $this->assertEquals( array( "C" => "c", "A" => "a" ), $this->context->getContext( 2, "s2" ) );
   }
   

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite("ezcLogContextTest");
	}
}

?>

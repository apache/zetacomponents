<?php
/**
 * ezcConsoleOutputFormatsTest 
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcConsoleOutputFormats struct.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleOutputFormatsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcConsoleOutputFormatsTest" );
	}

    public function testConstructor()
    {
        $formats = new ezcConsoleOutputFormats();
        $formats->default = new ezcConsoleOutputFormat();
        $this->assertEquals( 
            $formats,
            new ezcConsoleOutputFormats(),
            'Default values incorrect for ezcConsoleOutputFormats.'
        );
    }

    public function testGetAccessNonExistent()
    {
        $formats = new ezcConsoleOutputFormats();
        $format = new ezcConsoleOutputFormat();
        $this->assertEquals( 
            $format,
            $formats->foobar
        );
    }

    public function testGetAccessExistent()
    {
        $formats = new ezcConsoleOutputFormats();
        $format = new ezcConsoleOutputFormat();
        $formats->foobar = $format;
        $this->assertEquals( 
            $format,
            $formats->foobar
        );
    }

    public function testGetAccessManipulate()
    {
        $formats = new ezcConsoleOutputFormats();
        $formats->foobar->color = 'blue';
        
        $format = new ezcConsoleOutputFormat();
        $format->color = 'blue';
        
        $this->assertEquals( 
            $format,
            $formats->foobar
        );
    }

    public function testSetAccessExistent()
    {
        $formats = new ezcConsoleOutputFormats();
        $format = new ezcConsoleOutputFormat();
        $formats->foobar = $format;
        $this->assertEquals( 
            $format,
            $formats->foobar
        );
    }

    public function testIssetAccessSuccess()
    {
        $formats = new ezcConsoleOutputFormats();
        $formats->foobar = new ezcConsoleOutputFormat();
        $this->assertTrue( isset( $formats->foobar ) );
    }

    public function testIssetAccessFailure()
    {
        $formats = new ezcConsoleOutputFormats();
        $this->assertFalse( isset( $formats->foobar ) );
    }

    public function testIterator()
    {
        $formatsObj = new ezcConsoleOutputFormats();
        $formatsArr = $this->readAttribute(
            $formatsObj, 'formats'
        );
        reset( $formatsArr );

        // First run
        foreach ( $formatsObj as $name => $format )
        {
            $this->assertEquals(
                current( $formatsArr ),
                $format
            );
            $this->assertEquals(
                key( $formatsArr ),
                $name
            );

            next( $formatsArr );
        }
        $this->assertFalse(
            current( $formatsArr )
        );
        $this->assertFalse(
            $formatsObj->valid()
        );
        
        reset( $formatsArr );
        // Second run
        foreach ( $formatsObj as $name => $format )
        {
            $this->assertEquals(
                current( $formatsArr ),
                $format
            );
            $this->assertEquals(
                key( $formatsArr ),
                $name
            );

            next( $formatsArr );
        }
        $this->assertFalse(
            current( $formatsArr )
        );
        $this->assertFalse(
            $formatsObj->valid()
        );
    }

    public function testCountable()
    {
        $formatsObj = new ezcConsoleOutputFormats();

        $this->assertEquals(
            3,
            count( $formatsObj )
        );

        $formatsObj->foobar->color = 'blue';

        $this->assertEquals(
            4,
            count( $formatsObj )
        );
    }
}

?>

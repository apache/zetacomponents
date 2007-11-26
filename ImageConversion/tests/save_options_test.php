<?php
/**
 * ezcImageSaveOptionsTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcImageSaveOptionsTest extends ezcTestCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageSaveOptionsTest" );
	}

    public function testGetAccessSuccess()
    {
        $opt = new ezcImageSaveOptions();

        $this->assertNull( $opt->compression );
        $this->assertNull( $opt->quality );
        $this->assertNull( $opt->transparencyReplacementColor );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcImageSaveOptions();
        
        try
        {
            echo $opt->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on get access to invalid property foo." );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcImageSaveOptions();

        $opt->compression                  = 8;
        $opt->quality                      = 23;
        $opt->transparencyReplacementColor = array( 23, 42, 13 );

        $this->assertEquals( $opt->compression,                  8 );
        $this->assertEquals( $opt->quality,                      23 );
        $this->assertEquals( $opt->transparencyReplacementColor, array( 23, 42, 13 ) );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcImageSaveOptions();

        $this->genericSetFailureTest( $opt, "compression", -23 );
        $this->genericSetFailureTest( $opt, "compression",  10 );
        $this->genericSetFailureTest( $opt, "compression",  "foo" );
        $this->genericSetFailureTest( $opt, "quality", -23 );
        $this->genericSetFailureTest( $opt, "quality", 101 );
        $this->genericSetFailureTest( $opt, "quality", "foo" );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", -23 );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", 101 );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", "foo" );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", new stdClass() );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", array() );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", array( 42, 23 ) );
        $this->genericSetFailureTest( $opt, "transparencyReplacementColor", array( 'foo' => 42,  'bar' => 23 ) );

        try
        {
            $opt->foo = 23;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on set access to invalid property foo." );
    }

    public function genericSetFailureTest( $obj, $propertyName, $value )
    {
        try
        {
            $obj->$propertyName = $value;
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "ezcBaseValueException not thrown on invalid value '$value' for " . get_class( $obj ) . "->$propertyName." );
    }
}

?>

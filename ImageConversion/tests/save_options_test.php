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

        $opt->compression = 8;
        $opt->quality     = 23;

        $this->assertEquals( $opt->compression, 8 );
        $this->assertEquals( $opt->quality,     23 );
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

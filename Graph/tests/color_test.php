<?php
/**
 * ezcGraphColorTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphColorTest extends ezcTestCase
{
	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphColorTest" );
	}

    public function testFactoryColorFromHex()
    {
        $color = ezcGraphColor::fromHex( '#05172A' );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testFactoryColorFromHexWithAlpha()
    {
        $color = ezcGraphColor::fromHex( '#05172A40' );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 64, 'Wrong alpha color value' );
    }

    public function testFactoryColorFromIntegerArray()
    {
        $color = ezcGraphColor::fromIntegerArray( array( 5, 23, 42 ) );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testFactoryColorFromFloatArray()
    {
        $color = ezcGraphColor::fromFloatArray( array( .02, .092, .165 ) );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testFactoryColorCreateFromHex()
    {
        $color = ezcGraphColor::create( '#05172A' );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testFactoryColorCreateFromHexWithAlpha()
    {
        $color = ezcGraphColor::create( '#05172A40' );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 64, 'Wrong alpha color value' );
    }

    public function testFactoryColorCreateFromIntegerArray()
    {
        $color = ezcGraphColor::create( array( 5, 23, 42 ) );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testFactoryColorCreateFromFloatArray()
    {
        $color = ezcGraphColor::create( array( .02, .092, .165 ) );

        $this->assertEquals( $color->red, 5, 'Wrong red color value' );
        $this->assertEquals( $color->green, 23, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 42, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testFactoryUnknownColorDefinition()
    {
        try
        {
            $color = ezcGraphColor::create( 1337 );
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException' );
    }
}
?>

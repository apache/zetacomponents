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

    public function testLinearGradientColorFallback()
    {
        $color = new ezcGraphLinearGradient(
            new ezcGraphCoordinate( 0, 0 ),
            new ezcGraphCoordinate( 10, 10 ),
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertEquals( $color->red, 255, 'Wrong red color value' );
        $this->assertEquals( $color->green, 255, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 255, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testRadialGradientColorFallback()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertEquals( $color->red, 255, 'Wrong red color value' );
        $this->assertEquals( $color->green, 255, 'Wrong green color value' );
        $this->assertEquals( $color->blue, 255, 'Wrong blue color value' );
        $this->assertEquals( $color->alpha, 0, 'Wrong alpha color value' );
    }

    public function testLinearGradientProperties()
    {
        $color = new ezcGraphLinearGradient(
            new ezcGraphCoordinate( 0, 0 ),
            new ezcGraphCoordinate( 10, 10 ),
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertEquals( $color->startPoint, new ezcGraphCoordinate( 0, 0 ) );
        $this->assertEquals( $color->endPoint, new ezcGraphCoordinate( 10, 10 ) );
        $this->assertEquals( $color->startColor, ezcGraphColor::fromHex( '#FFFFFF' ) );
        $this->assertEquals( $color->endColor, ezcGraphColor::fromHex( '#00000000' ) );
    }

    public function testRadialGradientProperties()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertEquals( $color->center, new ezcGraphCoordinate( 0, 0 ) );
        $this->assertEquals( $color->width, 10 );
        $this->assertEquals( $color->height, 20 );
        $this->assertEquals( $color->startColor, ezcGraphColor::fromHex( '#FFFFFF' ) );
        $this->assertEquals( $color->endColor, ezcGraphColor::fromHex( '#00000000' ) );
    }

    public function testLinearGradientSetProperties()
    {
        $color = new ezcGraphLinearGradient(
            new ezcGraphCoordinate( 0, 0 ),
            new ezcGraphCoordinate( 10, 10 ),
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $color->startPoint = new ezcGraphCoordinate( 5, 5 );
        $color->endPoint = new ezcGraphCoordinate( 15, 15 );
        $color->startColor = ezcGraphColor::fromHex( '#000000' );
        $color->endColor = ezcGraphColor::fromHex( '#FFFFFF' );

        $this->assertEquals( $color->startPoint, new ezcGraphCoordinate( 5, 5 ) );
        $this->assertEquals( $color->endPoint, new ezcGraphCoordinate( 15, 15 ) );
        $this->assertEquals( $color->startColor, ezcGraphColor::fromHex( '#000000' ) );
        $this->assertEquals( $color->endColor, ezcGraphColor::fromHex( '#FFFFFF00' ) );
    }

    public function testRadialGradientSetProperties()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $color->center = new ezcGraphCoordinate( 5, 5 );
        $color->width = 15;
        $color->height = 25;
        $color->startColor = ezcGraphColor::fromHex( '#000000' );
        $color->endColor = ezcGraphColor::fromHex( '#FFFFFF' );
        
        $this->assertEquals( $color->center, new ezcGraphCoordinate( 5, 5 ) );
        $this->assertEquals( $color->width, 15 );
        $this->assertEquals( $color->height, 25 );
        $this->assertEquals( $color->startColor, ezcGraphColor::fromHex( '#000000' ) );
        $this->assertEquals( $color->endColor, ezcGraphColor::fromHex( '#FFFFFF00' ) );
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

    public function testInvertBlack()
    {
        $color = ezcGraphColor::create( '#000000' )->invert();

        $this->assertEquals(
            $color,
            ezcGraphColor::create( '#FFFFFF' )
        );
    }

    public function testInvertWhite()
    {
        $color = ezcGraphColor::create( '#FFFFFF' )->invert();

        $this->assertEquals(
            $color,
            ezcGraphColor::create( '#000000' )
        );
    }

    public function testInvertTransparentWhite()
    {
        $color = ezcGraphColor::create( '#FFFFFF22' )->invert();

        $this->assertEquals(
            $color,
            ezcGraphColor::create( '#00000022' )
        );
    }

    public function testInvertRandomColor()
    {
        $color = ezcGraphColor::create( '#123456' )->invert();

        $this->assertEquals(
            $color,
            ezcGraphColor::create( '#EDCBA9' )
        );
    }
}
?>

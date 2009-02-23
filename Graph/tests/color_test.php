<?php
/**
 * ezcGraphColorTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphColorTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphColorTest" );
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

    public function testColorPropertyRed()
    {
        $options = ezcGraphColor::create( '#00000000' );

        $this->assertSame(
            0,
            $options->red,
            'Wrong default value for property red in class ezcGraphColor'
        );

        $options->red = 1;
        $this->assertSame(
            1,
            $options->red,
            'Setting property value did not work for property red in class ezcGraphColor'
        );

        try
        {
            $options->red = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testColorPropertyGreen()
    {
        $options = ezcGraphColor::create( '#00000000' );

        $this->assertSame(
            0,
            $options->green,
            'Wrong default value for property green in class ezcGraphColor'
        );

        $options->green = 1;
        $this->assertSame(
            1,
            $options->green,
            'Setting property value did not work for property green in class ezcGraphColor'
        );

        try
        {
            $options->green = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testColorPropertyBlue()
    {
        $options = ezcGraphColor::create( '#00000000' );

        $this->assertSame(
            0,
            $options->blue,
            'Wrong default value for property blue in class ezcGraphColor'
        );

        $options->blue = 1;
        $this->assertSame(
            1,
            $options->blue,
            'Setting property value did not work for property blue in class ezcGraphColor'
        );

        try
        {
            $options->blue = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testColorPropertyAlpha()
    {
        $options = ezcGraphColor::create( '#00000000' );

        $this->assertSame(
            0,
            $options->alpha,
            'Wrong default value for property alpha in class ezcGraphColor'
        );

        $options->alpha = 1;
        $this->assertSame(
            1,
            $options->alpha,
            'Setting property value did not work for property alpha in class ezcGraphColor'
        );

        try
        {
            $options->alpha = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testColorPropertyNotFoundException()
    {
        try
        {
            $color = ezcGraphColor::create( array( .02, .092, .165 ) );
            $color->black = 23;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testLinearGradientPropertyNotFoundException()
    {
        $color = new ezcGraphLinearGradient(
            new ezcGraphCoordinate( 0, 0 ),
            new ezcGraphCoordinate( 10, 10 ),
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        try
        {
            $color->black;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }
    }

    public function testLinearGradientPropertyStartPoint()
    {
        $color = new ezcGraphLinearGradient(
            $coord = new ezcGraphCoordinate( 0, 0 ),
            new ezcGraphCoordinate( 10, 10 ),
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertSame(
            $coord,
            $color->startPoint,
            'Wrong default value for property startPoint in class ezcGraphRadialGradient'
        );

        $color->startPoint = $coord = new ezcGraphCoordinate( 5, 23 );
        $this->assertSame(
            $coord,
            $color->startPoint,
            'Setting property value did not work for property startPoint in class ezcGraphRadialGradient'
        );

        try
        {
            $color->startPoint = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLinearGradientPropertyEndPoint()
    {
        $color = new ezcGraphLinearGradient(
            new ezcGraphCoordinate( 0, 0 ),
            $coord = new ezcGraphCoordinate( 10, 10 ),
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertSame(
            $coord,
            $color->endPoint,
            'Wrong default value for property endPoint in class ezcGraphRadialGradient'
        );

        $color->endPoint = $coord = new ezcGraphCoordinate( 5, 23 );
        $this->assertSame(
            $coord,
            $color->endPoint,
            'Setting property value did not work for property endPoint in class ezcGraphRadialGradient'
        );

        try
        {
            $color->endPoint = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
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

    public function testRadialGradientPropertyNotFoundException()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        try
        {
            $color->black;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }
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

    public function testRadialGradientPropertyCenter()
    {
        $color = new ezcGraphRadialGradient(
            $coord = new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertSame(
            $coord,
            $color->center,
            'Wrong default value for property center in class ezcGraphRadialGradient'
        );

        $color->center = $coord = new ezcGraphCoordinate( 5, 23 );
        $this->assertSame(
            $coord,
            $color->center,
            'Setting property value did not work for property center in class ezcGraphRadialGradient'
        );

        try
        {
            $color->center = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRadialGradientPropertyWidth()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertSame(
            10.,
            $color->width,
            'Wrong default value for property width in class ezcGraphRadialGradient'
        );

        $color->width = 20;
        $this->assertSame(
            20.,
            $color->width,
            'Setting property value did not work for property width in class ezcGraphRadialGradient'
        );

        try
        {
            $color->width = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRadialGradientPropertyHeight()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertSame(
            20.,
            $color->height,
            'Wrong default value for property height in class ezcGraphRadialGradient'
        );

        $color->height = 30;
        $this->assertSame(
            30.,
            $color->height,
            'Setting property value did not work for property height in class ezcGraphRadialGradient'
        );

        try
        {
            $color->height = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testRadialGradientPropertyOffset()
    {
        $color = new ezcGraphRadialGradient(
            new ezcGraphCoordinate( 0, 0 ),
            10, 20,
            ezcGraphColor::fromHex( '#FFFFFF' ),
            ezcGraphColor::fromHex( '#000000' )
        );

        $this->assertSame(
            0,
            $color->offset,
            'Wrong default value for property offset in class ezcGraphRadialGradient'
        );

        $color->offset = .5;
        $this->assertSame(
            .5,
            $color->offset,
            'Setting property value did not work for property offset in class ezcGraphRadialGradient'
        );

        try
        {
            $color->offset = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
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

<?php
/**
 * ezcGraphDriverOptionsTest 
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
class ezcGraphDriverOptionsTest extends ezcTestImageCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphDriverOptionsTest" );
	}

    public function testDriverOptionsProperty()
    {
        $driver = new ezcGraphSvgDriver();

        $this->assertEquals(
            new ezcGraphSvgDriverOptions(),
            $driver->options,
            'Wrong default value for property options in class ezcGraphSvgDriver'
        );

        $driver->options = new ezcGraphFlashDriverOptions();
        $this->assertEquals(
            new ezcGraphFlashDriverOptions(),
            $driver->options,
            'Setting property value did not work for property options in class ezcGraphSvgDriver'
        );

        try
        {
            $driver->options = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverSetUnknownProperty()
    {
        $driver = new ezcGraphSvgDriver();

        try
        {
            $driver->unknownProperty = false;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testDriverGetUnknownProperty()
    {
        $driver = new ezcGraphSvgDriver();

        try
        {
            $driver->unknownProperty;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testDriverOptionsPropertyWidth()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            null,
            $options->width,
            'Wrong default value for property width in class ezcGraphSvgDriverOptions'
        );

        $options->width = 100;
        $this->assertSame(
            100,
            $options->width,
            'Setting property value did not work for property width in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->width = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverOptionsPropertyHeight()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            null,
            $options->height,
            'Wrong default value for property height in class ezcGraphSvgDriverOptions'
        );

        $options->height = 100;
        $this->assertSame(
            100,
            $options->height,
            'Setting property value did not work for property height in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->height = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverOptionsPropertyShadeCircularArc()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            .5,
            $options->shadeCircularArc,
            'Wrong default value for property shadeCircularArc in class ezcGraphSvgDriverOptions'
        );

        $options->shadeCircularArc = .2;
        $this->assertSame(
            .2,
            $options->shadeCircularArc,
            'Setting property value did not work for property shadeCircularArc in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->shadeCircularArc = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverOptionsPropertyLineSpacing()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            .1,
            $options->lineSpacing,
            'Wrong default value for property lineSpacing in class ezcGraphSvgDriverOptions'
        );

        $options->lineSpacing = .2;
        $this->assertSame(
            .2,
            $options->lineSpacing,
            'Setting property value did not work for property lineSpacing in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->lineSpacing = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverOptionsPropertyFont()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            'ezcGraphFontOptions',
            get_class( $options->font ),
            'Wrong default value for property font in class ezcGraphSvgDriverOptions'
        );

        $fontOptions = new ezcGraphFontOptions();
        $fontOptions->path = dirname( __FILE__ ) . '/data/font2.ttf';

        $options->font = $fontOptions;
        $this->assertSame(
            $fontOptions,
            $options->font,
            'Setting property value did not work for property font in class ezcGraphSvgDriverOptions'
        );

        try
        {
            $options->font = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverOptionsPropertyAutoShortenString()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            true,
            $options->autoShortenString,
            'Wrong default value for property autoShortenString in class ezcGraphDriverOptions'
        );

        $options->autoShortenString = false;
        $this->assertSame(
            false,
            $options->autoShortenString,
            'Setting property value did not work for property autoShortenString in class ezcGraphDriverOptions'
        );

        try
        {
            $options->autoShortenString = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testDriverOptionsPropertyAutoShortenStringPostFix()
    {
        $options = new ezcGraphSvgDriverOptions();

        $this->assertSame(
            '..',
            $options->autoShortenStringPostFix,
            'Wrong default value for property autoShortenStringPostFix in class ezcGraphDriverOptions'
        );

        $options->autoShortenStringPostFix = ' ...';
        $this->assertSame(
            ' ...',
            $options->autoShortenStringPostFix,
            'Setting property value did not work for property autoShortenStringPostFix in class ezcGraphDriverOptions'
        );
    }

    public function testPropertyNotFoundException()
    {
        $options = new ezcGraphSvgDriverOptions();

        try
        {
            $options->unknown = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }
}
?>

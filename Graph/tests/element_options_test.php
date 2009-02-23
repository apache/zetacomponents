<?php
/**
 * ezcGraphElementOptionsTest 
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
class ezcGraphElementOptionsTest extends ezcTestImageCase
{

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphElementOptionsTest" );
	}


    public function testChartElementPropertyTitle()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            false,
            $options->title,
            'Wrong default value for property title in class ezcGraphChartElementBackground'
        );

        $options->title = 'Title';
        $this->assertSame(
            'Title',
            $options->title,
            'Setting property value did not work for property title in class ezcGraphChartElementBackground'
        );
    }

    public function testChartElementPropertyBackground()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            false,
            $options->background,
            'Wrong default value for property background in class ezcGraphChartElementBackground'
        );

        $options->background = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->background,
            'Setting property value did not work for property background in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->background = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testChartElementPropertyBoundings()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            'ezcGraphBoundings',
            get_class( $options->boundings ),
            'Wrong default value for property boundings in class ezcGraphChartElementBackground'
        );
    }

    public function testChartElementPropertyBorder()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            false,
            $options->border,
            'Wrong default value for property border in class ezcGraphChartElementBackground'
        );

        $options->border = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->border,
            'Setting property value did not work for property border in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->border = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testChartElementPropertyPadding()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            0,
            $options->padding,
            'Wrong default value for property padding in class ezcGraphChartElementBackground'
        );

        $options->padding = 1;
        $this->assertSame(
            1,
            $options->padding,
            'Setting property value did not work for property padding in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->padding = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyMargin()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            0,
            $options->margin,
            'Wrong default value for property margin in class ezcGraphChartElementBackground'
        );

        $options->margin = 1;
        $this->assertSame(
            1,
            $options->margin,
            'Setting property value did not work for property margin in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->margin = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyBorderWidth()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            0,
            $options->borderWidth,
            'Wrong default value for property borderWidth in class ezcGraphChartElementBackground'
        );

        $options->borderWidth = 1;
        $this->assertSame(
            1,
            $options->borderWidth,
            'Setting property value did not work for property borderWidth in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->borderWidth = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyPosition()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            ezcGraph::LEFT,
            $options->position,
            'Wrong default value for property position in class ezcGraphChartElementBackground'
        );

        $options->position = ezcGraph::RIGHT;
        $this->assertSame(
            ezcGraph::RIGHT,
            $options->position,
            'Setting property value did not work for property position in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->position = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyMaxTitleHeight()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            16,
            $options->maxTitleHeight,
            'Wrong default value for property maxTitleHeight in class ezcGraphChartElementBackground'
        );

        $options->maxTitleHeight = 20;
        $this->assertSame(
            20,
            $options->maxTitleHeight,
            'Setting property value did not work for property maxTitleHeight in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->maxTitleHeight = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyPortraitTitleSize()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            .15,
            $options->portraitTitleSize,
            'Wrong default value for property portraitTitleSize in class ezcGraphChartElementBackground'
        );

        $options->portraitTitleSize = .5;
        $this->assertSame(
            .5,
            $options->portraitTitleSize,
            'Setting property value did not work for property portraitTitleSize in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->portraitTitleSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyLandscapeTitleSize()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            .2,
            $options->landscapeTitleSize,
            'Wrong default value for property landscapeTitleSize in class ezcGraphChartElementBackground'
        );

        $options->landscapeTitleSize = .5;
        $this->assertSame(
            .5,
            $options->landscapeTitleSize,
            'Setting property value did not work for property landscapeTitleSize in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->landscapeTitleSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementPropertyFont()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            'ezcGraphFontOptions',
            get_class( $options->font ),
            'Wrong default value for property font in class ezcGraphChartElementBackground'
        );

        $fontOptions = new ezcGraphFontOptions();
        $fontOptions->path = dirname( __FILE__ ) . '/data/font2.ttf';

        $options->font = $fontOptions;
        $this->assertSame(
            $fontOptions,
            $options->font,
            'Setting property value did not work for property font in class ezcGraphChartElementBackground'
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

    public function testChartElementPropertyFontCloned()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            false,
            $options->fontCloned,
            'Wrong default value for property fontCloned in class ezcGraphChartElementBackground'
        );
    }

    public function testChartElementBackgroundPropertyImage()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            false,
            $options->image,
            'Wrong default value for property image in class ezcGraphChartElementBackground'
        );

        $options->image = $file = dirname( __FILE__ ) . '/data/gif.gif';
        $this->assertSame(
            $file,
            $options->image,
            'Setting property value did not work for property image in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->image = false;
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseFileNotFoundException.' );
    }

    public function testChartElementBackgroundPropertyRepeat()
    {
        $options = new ezcGraphChartElementBackground();

        $this->assertSame(
            ezcGraph::NO_REPEAT,
            $options->repeat,
            'Wrong default value for property repeat in class ezcGraphChartElementBackground'
        );

        $options->repeat = ezcGraph::VERTICAL;
        $this->assertSame(
            ezcGraph::VERTICAL,
            $options->repeat,
            'Setting property value did not work for property repeat in class ezcGraphChartElementBackground'
        );

        try
        {
            $options->repeat = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLegendPropertyPadding()
    {
        $options = new ezcGraphChartElementLegend();

        $this->assertSame(
            0,
            $options->padding,
            'Wrong default value for property padding in class ezcGraphChartElementLegend'
        );

        $options->padding = 1;
        $this->assertSame(
            1,
            $options->padding,
            'Setting property value did not work for property padding in class ezcGraphChartElementLegend'
        );

        try
        {
            $options->padding = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLegendPropertyPortraitSize()
    {
        $options = new ezcGraphChartElementLegend();

        $this->assertSame(
            .2,
            $options->portraitSize,
            'Wrong default value for property portraitSize in class ezcGraphChartElementLegend'
        );

        $options->portraitSize = .5;
        $this->assertSame(
            .5,
            $options->portraitSize,
            'Setting property value did not work for property portraitSize in class ezcGraphChartElementLegend'
        );

        try
        {
            $options->portraitSize = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLegendPropertyLandscapeSize()
    {
        $options = new ezcGraphChartElementLegend();

        $this->assertSame(
            .1,
            $options->landscapeSize,
            'Wrong default value for property landscapeSize in class ezcGraphChartElementLegend'
        );

        $options->landscapeSize = .5;
        $this->assertSame(
            .5,
            $options->landscapeSize,
            'Setting property value did not work for property landscapeSize in class ezcGraphChartElementLegend'
        );

        try
        {
            $options->landscapeSize = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLegendPropertySymbolSize()
    {
        $options = new ezcGraphChartElementLegend();

        $this->assertSame(
            14,
            $options->symbolSize,
            'Wrong default value for property symbolSize in class ezcGraphChartElementLegend'
        );

        $options->symbolSize = 20;
        $this->assertSame(
            20,
            $options->symbolSize,
            'Setting property value did not work for property symbolSize in class ezcGraphChartElementLegend'
        );

        try
        {
            $options->symbolSize = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLegendPropertyMinimumSymbolSize()
    {
        $options = new ezcGraphChartElementLegend();

        $this->assertSame(
            .05,
            $options->minimumSymbolSize,
            'Wrong default value for property minimumSymbolSize in class ezcGraphChartElementLegend'
        );

        $options->minimumSymbolSize = .1;
        $this->assertSame(
            .1,
            $options->minimumSymbolSize,
            'Setting property value did not work for property minimumSymbolSize in class ezcGraphChartElementLegend'
        );

        try
        {
            $options->minimumSymbolSize = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementLegendPropertySpacing()
    {
        $options = new ezcGraphChartElementLegend();

        $this->assertSame(
            2,
            $options->spacing,
            'Wrong default value for property spacing in class ezcGraphChartElementLegend'
        );

        $options->spacing = 5;
        $this->assertSame(
            5,
            $options->spacing,
            'Setting property value did not work for property spacing in class ezcGraphChartElementLegend'
        );

        try
        {
            $options->spacing = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyNullPosition()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            false,
            $options->nullPosition,
            'Wrong default value for property nullPosition in class ezcGraphChartElementNumericAxis'
        );

        $options->nullPosition = .5;
        $this->assertSame(
            .5,
            $options->nullPosition,
            'Setting property value did not work for property nullPosition in class ezcGraphChartElementNumericAxis'
        );
    }

    public function testChartElementAxisPropertyAxisSpace()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            .1,
            $options->axisSpace,
            'Wrong default value for property axisSpace in class ezcGraphChartElementNumericAxis'
        );

        $options->axisSpace = .2;
        $this->assertSame(
            .2,
            $options->axisSpace,
            'Setting property value did not work for property axisSpace in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->axisSpace = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    /* Disabled for now.
    public function testChartElementAxisPropertyOuterAxisSpace()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            null,
            $options->outerAxisSpace,
            'Wrong default value for property outerAxisSpace in class ezcGraphChartElementNumericAxis'
        );

        $options->outerAxisSpace = .2;
        $this->assertSame(
            .2,
            $options->outerAxisSpace,
            'Setting property value did not work for property outerAxisSpace in class ezcGraphChartElementNumericAxis'
        );

        $options->outerAxisSpace = null;
        $this->assertSame(
            null,
            $options->outerAxisSpace,
            'Setting property value did not work for property outerAxisSpace in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->outerAxisSpace = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    } // */

    public function testChartElementAxisPropertyMajorGrid()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            false,
            $options->majorGrid,
            'Wrong default value for property majorGrid in class ezcGraphChartElementNumericAxis'
        );

        $options->majorGrid = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->majorGrid,
            'Setting property value did not work for property majorGrid in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->majorGrid = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testChartElementAxisPropertyMinorGrid()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            false,
            $options->minorGrid,
            'Wrong default value for property minorGrid in class ezcGraphChartElementNumericAxis'
        );

        $options->minorGrid = $color = ezcGraphColor::fromHex( '#FFFFFF' );
        $this->assertSame(
            $color,
            $options->minorGrid,
            'Setting property value did not work for property minorGrid in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->minorGrid = false;
        }
        catch ( ezcGraphUnknownColorDefinitionException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphUnknownColorDefinitionException.' );
    }

    public function testChartElementAxisPropertyMajorStep()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            null,
            $options->majorStep,
            'Wrong default value for property majorStep in class ezcGraphChartElementNumericAxis'
        );

        $options->majorStep = 1.;
        $this->assertSame(
            1.,
            $options->majorStep,
            'Setting property value did not work for property majorStep in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->majorStep = -1.;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyMinorStep()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            null,
            $options->minorStep,
            'Wrong default value for property minorStep in class ezcGraphChartElementNumericAxis'
        );

        $options->minorStep = 1.;
        $this->assertSame(
            1.,
            $options->minorStep,
            'Setting property value did not work for property minorStep in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->minorStep = -1.;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyFormatString()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            '%s',
            $options->formatString,
            'Wrong default value for property formatString in class ezcGraphChartElementNumericAxis'
        );

        $options->formatString = '[%s]';
        $this->assertSame(
            '[%s]',
            $options->formatString,
            'Setting property value did not work for property formatString in class ezcGraphChartElementNumericAxis'
        );
    }

    public function testChartElementAxisPropertyLabel()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            false,
            $options->label,
            'Wrong default value for property label in class ezcGraphChartElementNumericAxis'
        );

        $options->label = 'Axis';
        $this->assertSame(
            'Axis',
            $options->label,
            'Setting property value did not work for property label in class ezcGraphChartElementNumericAxis'
        );
    }

    public function testChartElementAxisPropertyLabelSize()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            14,
            $options->labelSize,
            'Wrong default value for property labelSize in class ezcGraphChartElementNumericAxis'
        );

        $options->labelSize = 20;
        $this->assertSame(
            20,
            $options->labelSize,
            'Setting property value did not work for property labelSize in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->labelSize = 2;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyLabelMargin()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            2,
            $options->labelMargin,
            'Wrong default value for property labelMargin in class ezcGraphChartElementNumericAxis'
        );

        $options->labelMargin = 1;
        $this->assertSame(
            1,
            $options->labelMargin,
            'Setting property value did not work for property labelMargin in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->labelMargin = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyMinArrowHeadSize()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            4,
            $options->minArrowHeadSize,
            'Wrong default value for property minArrowHeadSize in class ezcGraphChartElementNumericAxis'
        );

        $options->minArrowHeadSize = 10;
        $this->assertSame(
            10,
            $options->minArrowHeadSize,
            'Setting property value did not work for property minArrowHeadSize in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->labelMargin = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyMaxArrowHeadSize()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            8,
            $options->maxArrowHeadSize,
            'Wrong default value for property maxArrowHeadSize in class ezcGraphChartElementNumericAxis'
        );

        $options->maxArrowHeadSize = 10;
        $this->assertSame(
            10,
            $options->maxArrowHeadSize,
            'Setting property value did not work for property maxArrowHeadSize in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->labelMargin = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyAxisLabelRenderer()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            'ezcGraphAxisExactLabelRenderer',
            get_class( $options->axisLabelRenderer ),
            'Wrong default value for property axisLabelRenderer in class ezcGraphChartElementNumericAxis'
        );

        $options->axisLabelRenderer = $axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();
        $this->assertSame(
            $axisLabelRenderer,
            $options->axisLabelRenderer,
            'Setting property value did not work for property axisLabelRenderer in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->axisLabelRenderer = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testChartElementAxisPropertyLabelCallback()
    {
        $options = new ezcGraphChartElementNumericAxis();

        $this->assertSame(
            null,
            $options->labelCallback,
            'Wrong default value for property labelCallback in class ezcGraphChartElementNumericAxis'
        );

        $options->labelCallback = 'printf';
        $this->assertSame(
            'printf',
            $options->labelCallback,
            'Setting property value did not work for property labelCallback in class ezcGraphChartElementNumericAxis'
        );

        $options->labelCallback = array( $this, __METHOD__ );
        $this->assertSame(
            array( $this, __METHOD__ ),
            $options->labelCallback,
            'Setting property value did not work for property labelCallback in class ezcGraphChartElementNumericAxis'
        );

        try
        {
            $options->labelCallback = 'undefined_function';
        }
        catch ( ezcBasevalueException $e )
        {
            return true;
        }

        $this->fail( 'ezcBasevalueException expected.' );
    }

    public function testChartElementTextPropertyMaxHeight()
    {
        $options = new ezcGraphChartElementText();

        $this->assertSame(
            0.1,
            $options->maxHeight,
            'Wrong default value for property maxHeight in class ezcGraphChartElementText'
        );

        $options->maxHeight = .2;
        $this->assertSame(
            .2,
            $options->maxHeight,
            'Setting property value did not work for property maxHeight in class ezcGraphChartElementText'
        );

        try
        {
            $options->maxHeight = 2;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>

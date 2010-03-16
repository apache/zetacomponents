<?php
/**
 * ezcImageConversionHandlerGdTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . "/test_case.php";

/**
 * Test suite for ImageFiltersShell class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionFiltersShellTest extends ezcImageConversionTestCase
{

    protected $handler;

    protected $imageReference;

    protected function getActiveReference()
    {
        $handlerArr = (array) $this->handler;
        return $handlerArr["\0ezcImageMethodcallHandler\0activeReference"];
    }

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionFiltersShellTest" );
	}

    protected function setUp()
    {
        try
        {
            $this->handler = new ezcImageImagemagickHandler( ezcImageGdBaseHandler::defaultSettings() );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
        $this->imageReference = $this->handler->load( $this->testFiles['jpeg'] );
    }

    protected function tearDown()
    {
        unset( $this->handler );
    }

    public function testScale()
    {
        $this->handler->scale( 500, 500, ezcImageGeometryFilters::SCALE_BOTH );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            250
        );
    }

    public function testScaleDown_do()
    {
        $this->handler->scale( 500, 2, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            450
        );
    }

    public function testScaleDown_dont()
    {
        $this->handler->scale( 500, 500, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScaleUp_do()
    {
        $this->handler->scale( 500, 500, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            250
        );
    }

    public function testScaleUp_dont()
    {
        $this->handler->scale( 2, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScaleFailureInvalidParam()
    {
        try
        {
            $this->handler->scale( 500, 2, 23 );
            $this->fail( 'Exception not throwen on invalid scale direction.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->scale( -23, 2, ezcImageGeometryFilters::SCALE_UP );
            $this->fail( 'Exception not throwen on invalid scale direction.' );
        }
        catch ( ezcBaseValueException $e )
        {}
        
        try
        {
            $this->handler->scale( 500, -23, ezcImageGeometryFilters::SCALE_UP );
            $this->fail( 'Exception not throwen on invalid scale direction.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testScaleWidthBoth()
    {
        $this->handler->scale( 2, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            450
        );
    }

    public function testScaleWidthUp_1()
    {
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScaleWidthUp_2()
    {
        $this->handler->scaleWidth( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            250
        );
    }

    public function testScaleWidthDown_1()
    {
        $this->handler->scaleWidth( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScaleWidthDown_2()
    {
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            450
        );
    }

    public function testScaleWidthFailureInvalidParam()
    {
        try
        {
            $this->handler->scaleWidth( 'foo', ezcImageGeometryFilters::SCALE_DOWN );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->scaleWidth( -23, ezcImageGeometryFilters::SCALE_DOWN );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}
        
        try
        {
            $this->handler->scaleWidth( 42, 23 );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testScaleHeightUp_1()
    {
        $this->handler->scaleHeight( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            250
        );
    }

    public function testScaleHeightUp_2()
    {
        $this->handler->scaleHeight( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScaleHeightDown_1()
    {
        $this->handler->scaleHeight( 30, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScaleHeightDown_2()
    {
        $this->handler->scaleHeight( 30, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            550
        );
    }

    public function testScaleHeightFailureInvalidParam()
    {
        try
        {
            $this->handler->scaleHeight( 'foo', ezcImageGeometryFilters::SCALE_DOWN );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->scaleHeight( -23, ezcImageGeometryFilters::SCALE_DOWN );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}
        
        try
        {
            $this->handler->scaleHeight( 42, 23 );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testScalePercent_1()
    {
        $this->handler->scalePercent( 50, 50 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            500
        );
    }

    public function testScalePercentFailureInvalidParam()
    {
        try
        {
            $this->handler->scalePercent( -23, 100 );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->scalePercent( 100, -23 );
            $this->fail( 'Exception not throwen on invalid height.' );
        }
        catch ( ezcBaseValueException $e )
        {}
        
        try
        {
            $this->handler->scalePercent( -23, -23 );
            $this->fail( 'Exception not throwen on invalid width and height.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testScalePercent_2()
    {
        $this->handler->scalePercent( 200, 200 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected."
        );
    }

    public function testScaleExact_1()
    {
        $this->handler->scaleExact( 200, 200 );
        $this->handler->scaleExact( 200, 200 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            300
        );
    }

    public function testScaleExact_2()
    {
        $this->handler->scaleExact( 10, 200 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            400
        );
    }

    public function testScaleExact_3()
    {
        $this->handler->scaleExact( 200, 10 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            450
        );
    }

    public function testScaleExactFailureInvalidParam()
    {
        try
        {
            $this->handler->scaleExact( -23, 100 );
            $this->fail( 'Exception not throwen on invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->scaleExact( 100, -23 );
            $this->fail( 'Exception not throwen on invalid height.' );
        }
        catch ( ezcBaseValueException $e )
        {}
        
        try
        {
            $this->handler->scaleExact( -23, -23 );
            $this->fail( 'Exception not throwen on invalid width and height.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testCrop_1()
    {
        $this->handler->crop( 50, 38, 50, 37 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_2()
    {
        $this->handler->crop( 100, 75, -50, -37 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_3()
    {
        $this->handler->crop( 50, 75, 250, 38 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_0_Offset()
    {
        $this->handler->crop( 0, 0, 10, 10 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCropNegativeOffset_1()
    {
        $this->handler->crop( -100, -100, 50, 50 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCropNegativeOffset_2()
    {
        $this->handler->crop( -50, -50, 50, 50 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCropNegativeOffset_3()
    {
        $this->handler->crop( -50, -50, -50, -50 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCropFailureInvalidParams()
    {
        try
        {
            $this->handler->crop( 'foo', 23, 23, 23 );
            $this->fail( 'Exception not thrown on crop with invalid x coordinate.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->crop( 23, 'foo', 23, 23 );
            $this->fail( 'Exception not thrown on crop with invalid y coordinate.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->crop( 23, 23, 'foo', 23 );
            $this->fail( 'Exception not thrown on crop with invalid width.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->crop( 23, 23, 23, 'foo' );
            $this->fail( 'Exception not thrown on crop with invalid height.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testColorspaceGrey()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_GREY );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            300
        );
    }

    public function testColorspaceMonochrome()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_MONOCHROME );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            10000
        );
    }

    public function testColorspaceSepia()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_SEPIA );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            5000
        );
    }
    
    public function testColorspaceFailureInvalidParam()
    {
        try
        {
            $this->handler->colorspace( 23 );
            $this->fail( 'Exception not thrown on invalid colorspace.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testNoiseUniform()
    {
        $this->handler->noise( 'Uniform' );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            // Noise is normally different each time
            200
        );
    }

    public function testNoiseGaussian()
    {
        $this->handler->noise( 'Gaussian' );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            // Noise is normally different each time
            30000
        );
    }

    public function testNoiseMultiplicative()
    {
        $this->handler->noise( 'Multiplicative' );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            // Noise is normally different each time
            30000
        );
    }

    public function testNoiseImpulse()
    {
        $this->handler->noise( 'Impulse' );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            // Noise is normally different each time
            10000
        );
    }

    public function testNoiseLaplacian()
    {
        $this->handler->noise( 'Laplacian' );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            // Noise is normally different each time
            22000
        );
    }

    public function testNoisePoisson()
    {
        $this->handler->noise( 'Poisson' );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            // Noise is normally different each time
            12000
        );
    }
    
    public function testNoiseFailureInvalidParam()
    {
        try
        {
            $this->handler->noise( 'foo' );
            $this->fail( 'Exception not thrown on invalid noise value.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testSwirl_10()
    {
        $this->handler->swirl( 10 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            2000
        );
    }

    public function testSwirl_50()
    {
        $this->handler->swirl( 50 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            2000
        );
    }

    public function testSwirl_100()
    {
        $this->handler->swirl( 100 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            2000
        );
    }
    
    public function testSwirlFailureInvalidParam()
    {
        try
        {
            $this->handler->swirl( -23 );
            $this->fail( 'Exception not thrown on invalid swirl value.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testBorder_2()
    {
        $this->handler->border( 2, array( 0x00, 0x00, 0xFF ) );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testBorder_5()
    {
        $this->handler->border( 5, array( 255, 0, 0 ) );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testBorderFailures()
    {
        try
        {
            $this->handler->border( false, array( 255, 0, 0 ) );
            $this->fail( "Border filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->border( 10, array( 255, false, 0 ) );
            $this->fail( "Border filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
    }
    
    public function testWatermarkAbsoluteNoScale()
    {
        $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", 100, 80 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
    
    public function testWatermarkAbsoluteScale()
    {
        $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", 10, 10, 130, 93 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            100
        );
    }
    
    public function testWatermarkAbsoluteNoScaleNegativeOffset()
    {
        $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", -50, -33 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            strtr( $this->getReferencePath(), array( "NegativeOffset" =>  "" ) ),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
    
    public function testWatermarkAbsoluteScaleNegativeOffset()
    {
        $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", -140, -103, 130, 93 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            strtr( $this->getReferencePath(), array( "NegativeOffset" =>  "" ) ),
            $this->getTempPath(),
            "Image not rendered as expected.",
            100
        );
    }
    
    public function testWatermarkAbsoluteFailureInvalidParam()
    {
        try
        {
            $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/foo.png", -140, -103, 130, 93 );
            $this->fail( 'Exception not throwen on invalid watermark file.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", 'foo', -103, 130, 93 );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", -140, 'foo', 130, 93 );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", -140, -103, 'foo', 93 );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkAbsolute( dirname( __FILE__ ) . "/data/watermark.png", -140, -103, 130, 'foo' );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }
    
    public function testWatermarkPercentNoScale()
    {
        $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 10, 90 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
    
    public function testWatermarkPercentScale()
    {
        $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 80, 80, 20 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            100
        );
    }
    
    public function testWatermarkPercentFailureInvalidParam()
    {
        try
        {
            $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/foo.png", 80, 80, 20 );
            $this->fail( 'Exception not throwen on invalid watermark file.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", -80, 80, 20 );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 80, -80, 20 );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}

        try
        {
            $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 80, 80, -20 );
            $this->fail( 'Exception not throwen on invalid x coord.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }
    
    public function testCropThumbnailVertical()
    {
        $this->handler->croppedThumbnail( 50, 50 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            500
        );
    }
    
    public function testCropThumbnailHorizontal()
    {
        $this->handler->croppedThumbnail( 100, 50 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            500
        );
    }
    
    public function testCroppedThumbnailFailures()
    {
        try
        {
            $this->handler->croppedThumbnail( -10, 50 );
            $this->fail( "CroppedThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->croppedThumbnail( "foo", 50 );
            $this->fail( "CroppedThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->croppedThumbnail( 50, -10 );
            $this->fail( "CroppedThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->croppedThumbnail( 50, false );
            $this->fail( "CroppedThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
    }
    
    public function testFillThumbnailVertical()
    {
        $this->handler->filledThumbnail( 50, 50, array( 255, 0, 0 ) );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            500
        );
    }
    
    public function testFillThumbnailHorizontal()
    {
        $this->handler->filledThumbnail( 100, 50, array( 255, 0, 0 ) );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            500
        );
    }
    
    public function testFillThumbnailTooLargeColorArray()
    {
        $this->handler->filledThumbnail( 100, 50, array( 255, 0, 0, 400, 500, 600 ) );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
    
    public function testFilledThumbnailFailures()
    {
        try
        {
            $this->handler->filledThumbnail( -10, 50, array( 255, 0, 0 ) );
            $this->fail( "FilledThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->filledThumbnail( "foo", 50, array( 255, 0, 0 ) );
            $this->fail( "FilledThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->filledThumbnail( 50, -10, array( 255, 0, 0 ) );
            $this->fail( "FilledThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->filledThumbnail( 50, false, array( 255, 0, 0 ) );
            $this->fail( "FilledThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->filledThumbnail( 50, 50, array( 255, false, 0 ) );
            $this->fail( "FilledThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
        try
        {
            $this->handler->filledThumbnail( 50, 50, array( "bar", 0, 0 ) );
            $this->fail( "FilledThumbnail filter accepted incorrect value." );
        }
        catch ( ezcBaseValueException $e )
        {}
    }
}
?>

<?php
/**
 * ezcImageConversionHandlerGdTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testScalePercent_2()
    {
        $this->handler->scaleExact( 200, 200 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
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

    public function testSwirl_10()
    {
        $this->handler->swirl( 10 );
        $this->handler->save( $this->getActiveReference(), $this->getTempPath() );
        $this->handler->close( $this->getActiveReference() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
    
    public function testWatermarkPercentNoScale()
    {
        $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 10, 20 );
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
        $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 20, 20, 60, 60 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }
}
?>

<?php
/**
 * ezcImageConversionHandlerGdTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . "/test_case.php";

/**
 * Test suite for ImageFiltersGd class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionFiltersGdTest extends ezcImageConversionTestCase
{
    protected $handler;

    protected $imageReference;

    protected function getActiveResource()
    {
        /*
         * @todo Possible bug in Reflection API?
         *
        echo "\n--- Handler object ---\n";
        var_dump( $this->handler );
        $obj = new ReflectionObject( $this->handler );
        echo "\n--- Handler reflection object ---\n";
        var_dump( $obj );
        $atts = $obj->getProperties();
        echo "\n--- Handler reflection attribute objects ---\n";
        var_dump( $atts );
        echo "\n--- Handler reflection has property activeReference ---\n";
        var_dump( $obj->hasProperty( "activeReference" ) );
        echo "\n--- Now trying ->getProperty( activeReference ) ---\n";
        $att = $obj->getProperty( "activeReference" );
        echo "\n--- Handler reflection attribute object for activeReference ---\n";
        var_dump( $att );
        $activeReference = $this->readAttribute( $this->handler, "activeReference" );
        $references = $this->readAttribute( $this->handler, "references" );
        */
        $handlerArr = ( array) $this->handler;
        $reference = $handlerArr["\0ezcImageMethodcallHandler\0activeReference"];
        $referenceData = $handlerArr["\0ezcImageMethodcallHandler\0references"][$reference];
        return $referenceData["resource"];
    }

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionFiltersGdTest" );
	}

    protected function setUp()
    {
        try
        {
            $this->handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
        $this->imageReference = $this->handler->load( $this->testFiles["jpeg"] );
    }

    protected function tearDown()
    {
        unset( $this->handler );
    }

    public function testScaleBoth()
    {
        $this->handler->scale( 500, 500, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            500,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            377,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleDown_do()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 2, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            3,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            2,
            imagesy( $this->getActiveResource() ),
            "Height of scaled image incorrect."
        );
    }

    public function testScaleDown_dont()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 200, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Height of scaled image incorrect."
        );
    }

    public function testScaleUp_do()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 300, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            398,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            300,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleUp_dont()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scale( 500, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            $oldDim["y"],
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
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
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            50,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            37,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthUp_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthUp_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            300,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            226,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthDown_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleWidthDown_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleWidth( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            50,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            38,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
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

    public function testScaleHeightBoth()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            66,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            50,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightUp_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 226, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            300,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            226,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightUp_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightDown_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            113,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleHeightDown_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleHeight( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            66,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            50,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
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
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scalePercent( 50, 50 );
        $this->assertEquals(
            75,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            57,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScalePercent_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scalePercent( 200, 200 );
        $this->assertEquals(
            300,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            226,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
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

    public function testScaleExact_1()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleExact( 200, 200 );
        $this->assertEquals(
            200,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            200,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleExact_2()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleExact( 10, 200 );
        $this->assertEquals(
            10,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            200,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
    }

    public function testScaleExact_3()
    {
        $oldDim = array(
            "x" => imagesx( $this->getActiveResource() ),
            "y" => imagesy( $this->getActiveResource() ),
        );
        $this->handler->scaleExact( 200, 10 );
        $this->assertEquals(
            200,
            imagesx( $this->getActiveResource() ),
            "Width of scaled image incorrect."
        );
        $this->assertEquals(
            10,
            imagesy( $this->getActiveResource() ),
            "Width of scaled image incorrect."
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

    public function testScaleTransparent()
    {
        $ref = $this->handler->load( dirname( __FILE__ ) . "/data/watermark.png" );
        $this->handler->scale( 80, 80 );
        $this->handler->save( $ref, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            10000
        );
    }

    public function testCrop_1()
    {
        $this->handler->crop( 50, 38, 50, 37 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
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
        $this->handler->save( $this->imageReference, $this->getTempPath() );
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
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCrop_4()
    {
        $this->handler->crop( 50, 75, 38, 250 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
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
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testCropTransparent()
    {
        $ref = $this->handler->load( dirname( __FILE__ ) . "/data/watermark.png" );
        $this->handler->crop( 20, 0, 10, 5 );
        $this->handler->save( $ref, $this->getTempPath() );
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
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testColorspaceMonochrome()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_MONOCHROME );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testColorspaceSepia()
    {
        $this->handler->colorspace( ezcImageColorspaceFilters::COLORSPACE_SEPIA );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            500
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
    
    public function testWatermarkPercentScale()
    {
        $this->handler->watermarkPercent( dirname( __FILE__ ) . "/data/watermark.png", 80, 80, 20 );
        $this->handler->save( $this->imageReference, $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not rendered as expected.",
            450
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
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

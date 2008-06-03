<?php
/**
 * ezcImageConversionHandlerGdTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require base class for handler tests.
 */
require_once "handler_test.php";

/**
 * Test suite for ImageHandlerGd class.
 * This test class contains all tests that are specific to the GD handler.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionHandlerGdTest extends ezcImageConversionHandlerTest
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionHandlerGdTest" );
	}

    protected function setUp()
    {
        try
        {
            $dummy = new ezcImageGdHandler( ezcImageGdBaseHandler::defaultSettings() );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
        $this->handlerClass = "ezcImageGdHandler";
        parent::setUp();
    }

    public function testLoadSuccess()
    {
        $filePath = $this->testFiles["jpeg"];

        $ref = $this->handler->load( $filePath );

        $refProp = $this->getReferences();
        $imageRef = current( $refProp );

        $this->assertEquals(
            $imageRef["file"],
            $filePath,
            "Image reference not registered correctly."
        );
        
        $this->assertEquals(
            $imageRef["mime"],
            "image/jpeg",
            "Image reference not registered correctly."
        ); 
    }

    public function testLoadFailureFilenotexists()
    {
        $filePath = $this->testFiles["nonexistent"];

        try
        {
            $ref = $this->handler->load( $filePath );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return;
        }
        $this->fail( "Required exception not thrown on not existing file." );
    }

    public function testLoadFailureUnknownmimetype()
    {
        $filePath = $this->testFiles["text"];

        try
        {
            $ref = $this->handler->load( $filePath );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Required exception not thrown on not existing file." );
    }

    public function testLoadFailureUnknownMimeTypeParam()
    {
        $filePath = $this->testFiles['png'];

        try
        {
            $ref = $this->handler->load( $filePath, 'text/plain' );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Required exception not thrown on not existing file." );
    }

    public function testSaveOldfileNoconvert()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        copy( $srcPath, $dstPath );

        $copytime = filemtime( $dstPath );

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $dstPath );

        unlink( $dstPath );

        $handler->save( $ref );

        $this->assertTrue(
            file_exists( $dstPath ),
            "File not correctly saved to old destination."
        );
    }

    public function testSaveNewfileNoconvert()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );
        $handler->save( $ref, $dstPath );

        $this->assertTrue(
            file_exists( $dstPath ),
            "File not correctly saved to new destination."
        );
    }

    public function testSaveNewfileConvert()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );
        $handler->save( $ref, $dstPath, "image/png" );

        $analyzer = new ezcImageAnalyzer( $dstPath );

        $this->assertEquals(
            "image/png",
            $analyzer->mime,
            "File not correctly saved to new destination."
        );
    }
    
    public function testSaveNewfileQualityLow()
    {
        $srcPath = $this->testFiles["png"];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );

        $opts = new ezcImageSaveOptions();
        $opts->quality     = 0;

        $handler->save( $ref, $dstPath, "image/jpeg", $opts );

        $this->assertTrue(
            filesize( $dstPath ) < 2000,
            "File saved with too high quality."
        );
    }

    public function testSaveNewfileQualityHigh()
    {
        $srcPath = $this->testFiles["png"];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );

        $opts = new ezcImageSaveOptions();
        $opts->quality     = 100;

        $handler->save( $ref, $dstPath, "image/jpeg", $opts );

        $this->assertTrue(
            filesize( $dstPath ) > 30000,
            "File saved with too low quality."
        );
    }

    public function testSaveNewfileCompressionLow()
    {
        $srcPath = $this->testFiles["png"];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );

        $opts = new ezcImageSaveOptions();
        $opts->compression = 0;

        $handler->save( $ref, $dstPath, "image/png", $opts );

        $this->assertTrue(
            filesize( $dstPath ) > 100000,
            "File saved with too high compression."
        );
    }

    public function testSaveNewfileCompressionHigh()
    {
        $srcPath = $this->testFiles["png"];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );

        $opts = new ezcImageSaveOptions();
        $opts->compression = 9;

        $handler->save( $ref, $dstPath, "image/png", $opts );

        $this->assertTrue(
            filesize( $dstPath ) < 40000,
            "File saved with too low compression."
        );
    }

    public function testSaveFailureUnknownMimeType()
    {
        $srcPath = $this->testFiles['jpeg'];
        $dstPath = $this->getTempPath();

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );
        try
        {
            $handler->save( $ref, $dstPath, 'text/plain' );
            $this->fail( 'Exception not thrown on save with invalid MIME type.' );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {}

        $handler->close( $ref );
    }

    public function testConvertSuccess()
    {
        $filePath = $this->testFiles["jpeg"];

        $ref = $this->handler->load( $filePath );
        $this->handler->convert( $ref, "image/png" );

        $refProp = $this->getReferences();
        $imageRef = current( $refProp );

        $this->assertTrue(
            $imageRef["mime"] === "image/png",
            "MIME type conversion not registered correctly."
        );
    }

    public function testConvertFailure()
    {
        $filePath = $this->testFiles["jpeg"];

        $ref = $this->handler->load( $filePath );

        try
        {
            $this->handler->convert( $ref, "application/ezc" );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Exception for unknown conversion not thrown." );
    }

    public function testApplyFilterSingle()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $ref = $this->handler->load( $srcPath );
        $this->handler->applyFilter( $ref, new ezcImageFilter( "scale", array( "width" => 200, "height" => 200, "direction" => ezcImageGeometryFilters::SCALE_BOTH ) ) );
        $this->handler->save( $ref, $dstPath );
        $this->assertImageSimilar(
             $this->getReferencePath(),
             $dstPath,
            "Applying single filter through handler failed.",
            // ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
            60
        );
    }

    public function testApplyFilterMultiple()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $ref = $this->handler->load( $srcPath );
        $this->handler->applyFilter( $ref, new ezcImageFilter( "scale", array( "width" => 200, "height" => 200, "direction" => ezcImageGeometryFilters::SCALE_BOTH ) ) );
        $this->handler->applyFilter( $ref, new ezcImageFilter( "crop", array( "x" => 50, "width" => 100, "y" => 50, "height" => 100 ) ) );
        $this->handler->applyFilter( $ref, new ezcImageFilter( "colorspace", array( "space" => ezcImageColorspaceFilters::COLORSPACE_SEPIA ) ) );
        $this->handler->save( $ref, $dstPath );

        $this->assertImageSimilar(
             $this->getReferencePath(),
             $dstPath,
            "Applying multiple filter through handler failed.",
            // ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
            80
        );
    }

    public function testConvertTransparentNonTransparent()
    {

        $srcPath = $this->testFiles["png_transparent"];
        $dstPath = $this->getTempPath();

        $ref = $this->handler->load( $srcPath );

        $options = new ezcImageSaveOptions();
        $options->transparencyReplacementColor = array( 255, 0, 0 );

        $this->handler->save( $ref, $dstPath, 'image/jpeg', $options );
        
        $this->handler->close( $ref );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $dstPath,
             "Converting transparent background failed.",
            500
        );
    }
}
?>

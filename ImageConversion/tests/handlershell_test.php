<?php
/**
 * ezcImageConversionHandlerShellTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require base class for handler tests.
 */
require_once "handler_test.php";

/**
 * Test suite for ImageHandlerShell class.
 * This test class contains all tests that are specific to the GD handler.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionHandlerShellTest extends ezcImageConversionHandlerTest
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionHandlerShellTest" );
	}

    public function setUp()
    {
        try
        {
            $dummy = new ezcImageImagemagickHandler( ezcImageImagemagickBaseHandler::defaultSettings() );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
        $this->handlerClass = "ezcImageImagemagickHandler";
        parent::setUp();
    }

    public function testInitFromSetBinary()
    {
        $settings = ezcImageImagemagickHandler::defaultSettings();
        $settings->options['binary'] = ezcBaseFeatures::getImageConvertExecutable();

        $handler = new ezcImageImagemagickHandler( $settings );

        $filePath = $this->testFiles["jpeg"];

        $ref = $handler->load( $filePath );
        $handler->close( $ref );
    }

    public function testLoadSuccess()
    {
        $filePath = $this->testFiles["jpeg"];

        $ref = $this->handler->load( $filePath );

        $refProp = $this->getReferences();
        $imageRef = current( $refProp );

        $this->handler->close( $ref );
        $this->assertSame(
            $filePath,
            $imageRef["file"],
            "Image reference not registered correctly."
        );

        $this->assertSame(
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
        $filePath = $this->testFiles["noimage"];

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

    public function testLoadCorruptJpegFailure()
    {
        $origPath = $this->testFiles['corrupt_jpeg'];
        $tmpPath  = $this->getTempPath();

        copy( $origPath, $tmpPath );

        $ref = $this->handler->load( $tmpPath );

        unlink( $tmpPath );
        
        try
        {
            $this->handler->save( $ref );
            $this->fail( 'Exception not thrown on processing corrupt JPEG.' );
        } catch ( ezcImageFileNotProcessableException $e ) {}

        $this->handler->close( $ref );
    }

    public function testCloseSuccess()
    {
        $srcPath = $this->testFiles["jpeg"];
        $ref = $this->handler->load( $srcPath );

        $refProp = $this->getReferences();
        $tmpFile = $refProp[$ref]["resource"];

        $this->handler->close( $ref );

        $refProp = $this->getReferences();

        $this->assertFalse(
            isset( $refProp[$ref] ),
            "Reference not freed successfully."
        );
        $this->assertFalse(
            file_exists( $tmpFile ),
            "Temporary file not deleted successfully."
        );
    }
    
    public function testRemoveTempFilesInDtorSuccess()
    {
        $filePath = $this->testFiles["jpeg"];

        $ref = $this->handler->load( $filePath );

        $refProp = $this->getReferences();
        $imageRef = current( $refProp );
        
        // Manually destruct handler
        unset( $this->handler );

        $this->assertFalse(
            file_exists( $imageRef["resource"] ),
            "Image reference not closed correctly in dtor."
        );

    }

    public function testApplyFilterSingle()
    {

        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $ref = $this->handler->load( $srcPath );
        $this->handler->applyFilter( $ref, new ezcImageFilter( "scale", array( "width" => 200, "height" => 200, "direction" => ezcImageGeometryFilters::SCALE_BOTH ) ) );
        $this->handler->save( $ref, $dstPath );
        $this->handler->close( $ref );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $dstPath,
             "Applying single filter through handler failed.",
            300
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

        $this->handler->close( $ref );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $dstPath,
            "Applying multiple filter through handler failed.",
            // ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
            12000
        );
        // @ todo: Orphan! Remove!
        $this->removeTempDir();
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

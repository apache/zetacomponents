<?php
/**
 * ezcConsoleToolsOutputTest 
 * 
 * @package ImageAnalysis
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ImageAnalyzer class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcImageAnalysisAnalyzerTest extends ezcTestCase
{

    protected $basePath;

    protected $testFiles = array( 
        'exif_jpeg'       => 'jpeg_exif.jpg',
        'noexif_jpeg'     => 'jpeg_noexif.jpg',
        'exif_tiff'       => 'tiff_exif.tiff',
        'noexif_tiff'     => 'tiff_noexif.tiff',
        'animated_gif'    => 'gif_animated.gif',
        'noanimated_gif'  => 'gif_nonanimated.gif',
        'noanimated_png'  => 'png_nonanimated.png',
        'svg'             => 'svg.svg',
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageAnalysisAnalyzerTest" );
	}

    protected function setUp()
    {
        if ( !extension_loaded( 'exif' ) )
        {
            $this->markTestSkipped( 'ext/exif is required to run this test.' );
        }

        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    public function testPhpHandlerGetMimeJpegExif()
    {
        $file =  $this->basePath . $this->testFiles['exif_jpeg'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/jpeg',
            $analyzer->mime,
            'MIME-Type was not determined correctly for JPEG.'
        );
    }
    
    public function testImagemagickHandlerGetMimeJpegExif()
    {
        $file =  $this->basePath . $this->testFiles['exif_jpeg'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/jpeg',
            $analyzer->mime,
            'MIME-Type was not determined correctly for JPEG.'
        );
    }

    public function testPhpHandlerGetMimeJpegNoexif()
    {
        $file =  $this->basePath . $this->testFiles['noexif_jpeg'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/jpeg',
            $analyzer->mime,
            'MIME-Type was not determined correctly for JPEG.'
        );
    }
    
    public function testImagemagickHandlerGetMimeJpegNoexif()
    {
        $file =  $this->basePath . $this->testFiles['noexif_jpeg'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/jpeg',
            $analyzer->mime,
            'MIME-Type was not determined correctly for JPEG.'
        );
    }

    public function testPhpHandlerGetMimeTiffExif()
    {
        $file =  $this->basePath . $this->testFiles['exif_tiff'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/tiff',
            $analyzer->mime,
            'MIME-Type was not determined correctly for TIFF.'
        );
    }

    public function testImagemagickHandlerGetMimeTiffExif()
    {
        $file =  $this->basePath . $this->testFiles['exif_tiff'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/tiff',
            $analyzer->mime,
            'MIME-Type was not determined correctly for TIFF.'
        );
    }

    public function testPhpHandlerGetMimeTiffNoexif()
    {
        $file =  $this->basePath . $this->testFiles['noexif_tiff'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/tiff',
            $analyzer->mime,
            'MIME-Type was not determined correctly for TIFF.'
        );
    }

    public function testImagemagickHandlerGetMimeTiffNoexif()
    {
        $file =  $this->basePath . $this->testFiles['noexif_tiff'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/tiff',
            $analyzer->mime,
            'MIME-Type was not determined correctly for TIFF.'
        );
    }

    public function testPhpHandlerGetMimeGifNonanimated()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_gif'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/gif',
            $analyzer->mime,
            'MIME-Type was not determined correctly for GIF.'
        );
    }
    
    public function testImagemagickHandlerGetMimeGifNonanimated()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_gif'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/gif',
            $analyzer->mime,
            'MIME-Type was not determined correctly for GIF.'
        );
    }

    public function testPhpHandlerGetMimeGifAnimated()
    {
        $file =  $this->basePath . $this->testFiles['animated_gif'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/gif',
            $analyzer->mime,
            'MIME-Type was not determined correctly for GIF.'
        );
    }
    
    public function testImagemagickHandlerGetMimeGifAnimated()
    {    
        $file =  $this->basePath . $this->testFiles['animated_gif'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/gif',
            $analyzer->mime,
            'MIME-Type was not determined correctly for GIF.'
        );
    }

    public function testPhpHandlerGetMimePngNonanimated()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_png'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            'image/png',
            $analyzer->mime,
            'MIME-Type was not determined correctly for PNG.'
        );
    }
        
    public function testImagemagickHandlerGetMimePngNonanimated()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_png'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            'image/png',
            $analyzer->mime,
            'MIME-Type was not determined correctly for PNG.'
        );
    }

    public function testPhpHandlerJpegExifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['exif_jpeg'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            ' ',
            $analyzer->data->comment,
            '<comment> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            76383,
            $analyzer->data->size,
            '<size> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for JPEG.'
        );
    }
        
    public function testImagemagickHandlerJpegExifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['exif_jpeg'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for JPEG.'
        );
        // @FIXME: update test case, as soon as Exif works here.
        $this->assertSame( 
            null,
            $analyzer->data->comment,
            '<comment> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            76383,
            $analyzer->data->size,
            '<size> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for JPEG.'
        );
        // @FIXME: update test case, as soon as Exif works here.
        /*
        $this->assertSame( 
            true,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for JPEG.'
        );
        */
    }

    public function testPhpHandlerJpegNoexifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['noexif_jpeg'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            null,
            $analyzer->data->comment,
            '<comment> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            68802,
            $analyzer->data->size,
            '<size> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for JPEG.'
        );
    }
        
    public function testImagemagickHandlerJpegNoexifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['noexif_jpeg'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            null,
            $analyzer->data->comment,
            '<comment> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            68802,
            $analyzer->data->size,
            '<size> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for JPEG.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for JPEG.'
        );
    }

    public function testPhpHandlerTiffExifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['exif_tiff'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            null,
            $analyzer->data->comment,
            '<comment> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            108125,
            $analyzer->data->size,
            '<size> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for TIFF.'
        );
    }
        
    public function testImagemagickHandlerTiffExifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['exif_tiff'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for TIFF.'
        );
        // FIXME: Exif does not show comment, but ImageMagick does!!!
        $this->assertSame( 
            'A simple comment in a TIFF file.',
            $analyzer->data->comment,
            '<comment> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            108125,
            $analyzer->data->size,
            '<size> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for TIFF.'
        );
    }

    public function testPhpHandlerTiffNoexifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['noexif_tiff'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            null,
            $analyzer->data->comment,
            '<comment> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            108043,
            $analyzer->data->size,
            '<size> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for TIFF.'
        );
    }
    
    public function testImagemagickHandlerTiffNoexifReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['noexif_tiff'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            399,
            $analyzer->data->width,
            '<width> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            600,
            $analyzer->data->height,
            '<height> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            true,
            $analyzer->data->isColor,
            '<isColor> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            null,
            $analyzer->data->comment,
            '<comment> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            108043,
            $analyzer->data->size,
            '<size> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for TIFF.'
        );
        $this->assertSame( 
            false,
            $analyzer->data->hasThumbnail,
            '<hasThumbnail> not extracted correctly for TIFF.'
        );
    }

    public function testPhpHandlerPngReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_png'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            160,
            $analyzer->data->width,
            '<width> not extracted correctly for PNG.'
        );
        $this->assertSame( 
            120,
            $analyzer->data->height,
            '<height> not extracted correctly for PNG.'
        );
        $this->assertSame( 
            5420,
            $analyzer->data->size,
            '<size> not extracted correctly for PNG.'
        );
    }
    
    public function testImagemagickHandlerPngReportsDetails()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_png'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            160,
            $analyzer->data->width,
            '<width> not extracted correctly for PNG.'
        );
        $this->assertSame( 
            120,
            $analyzer->data->height,
            '<height> not extracted correctly for PNG.'
        );
        $this->assertSame( 
            5420,
            $analyzer->data->size,
            '<size> not extracted correctly for PNG.'
        );
    }
    
    public function testPhpHandlerAnimatedGifReportsAnimated()
    {
        $file =  $this->basePath . $this->testFiles['animated_gif'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame(
            true,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for GIF.'
        );
    }

    public function testImagemagickHandlerAnimatedGifReportsAnimated()
    {
        $file =  $this->basePath . $this->testFiles['animated_gif'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame(
            true,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for GIF.'
        );
    }

    public function testPhpHandlerNoexifJpegReportsNotAnimated()
    {
        $file =  $this->basePath . $this->testFiles['noexif_jpeg'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame(
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> no extracted correctly for JPEG.'
        );
    }

    public function testImagemagickHandlerNoexifJpegReportsNotAnimated()
    {
        $file =  $this->basePath . $this->testFiles['noexif_jpeg'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame(
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> no extracted correctly for JPEG.'
        );
    }
    
    public function testPhpHandlerNonanimatedGifReportsNotAnimated()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_gif'];
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for GIF.'
        );
    }
    
    public function testImagemagickHandlerNonanimatedGifReportsNotAnimated()
    {
        $file =  $this->basePath . $this->testFiles['noanimated_gif'];
        $analyzer = $this->getAnalyzerImagemagickHandler( $file );
        $this->assertSame( 
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for GIF.'
        );
    }

    public function testPhpHandlerExifJpegReportsNotAnimated()
    {
        $file =  $this->basePath . $this->testFiles['exif_jpeg'];

        // Test Php handler
        $analyzer = $this->getAnalyzerPhpHandler( $file );
        $this->assertSame(
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for JPEG.'
        );
    }
    
    public function testImagemagickHandlerExifJpegReportsNotAnimated()
    {    
        $file =  $this->basePath . $this->testFiles['exif_jpeg'];

        // Test ImageMagick handler
        $analyzer = $this->getAnalyzerImageMagickHandler( $file );
        $this->assertSame(
            false,
            $analyzer->data->isAnimated,
            '<isAnimated> not extracted correctly for JPEG.'
        );
    }

    public function testSvgMimeType()
    {
        $file = $this->basePath . $this->testFiles['svg'];
        $analyzer = $this->getAnalyzerImageMagickHandler( $file );
        $this->assertEquals(
            "image/svg+xml",
            $analyzer->mime,
            '<mime> not extracted correctly for SVG.'
        );
    }

    public function testAnalyzerGeneralNotProcessable()
    {

    }

    protected function getAnalyzerPhpHandler( $file )
    {
        ezcImageAnalyzer::setHandlerClasses( array( 'ezcImageAnalyzerPhpHandler' => array() ) );
        return new ezcImageAnalyzer( $file );
    }
    
    protected function getAnalyzerImageMagickHandler( $file )
    {
        ezcImageAnalyzer::setHandlerClasses( array( 'ezcImageAnalyzerImagemagickHandler' => array() ) );
        return new ezcImageAnalyzer( $file );
    }
    
}
?>

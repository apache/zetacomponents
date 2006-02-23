<?php
/**
 * ezcImageConversionHandlerGdTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require base class for handler tests.
 */
require_once 'handler_test.php';

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
		return new ezcTestSuite( "ezcImageConversionHandlerGdTest" );
	}

    public function setUp()
    {
        $this->handlerClass = 'ezcImageGdHandler';
        parent::setUp();
    }

    public function testLoadSuccess()
    {
        $filePath = $this->basePath . $this->testFiles['jpeg'];

        $ref = $this->handler->load( $filePath );

        $handleArr = (array)$this->handler;
        $refProp = $handleArr["\0ezcImageMethodcallHandler\0references"];
        $imageRef = current( $refProp );

        $this->assertTrue(
            $imageRef['file'] === $filePath && $imageRef['mime'] === 'image/jpeg',
            'Image reference not registered correctly.'
        );
    }

    public function testLoadFailureFilenotexists()
    {
        // Non existant path
        $filePath = $this->basePath . $this->testFiles['nonexistant'];

        try
        {
            $ref = $this->handler->load( $filePath );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return;
        }
        $this->fail( 'Required exception not thrown on not existing file.' );
    }

    public function testLoadFailureUnknownmimetype()
    {
        // Non existant path
        $filePath = $this->basePath . $this->testFiles['invalid'];

        try
        {
            $ref = $this->handler->load( $filePath );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( 'Required exception not thrown on not existing file.' );
    }

    public function testSaveOldfileNoconvert()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        copy( $srcPath, $dstPath );

        $copytime = filemtime( $dstPath );

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $dstPath );

        unlink( $dstPath );

        $handler->save( $ref );

        $this->assertTrue(
            file_exists( $dstPath ),
            'File not correctly saved to old destination.'
        );
    }

    public function testSaveNewfileNoconvert()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );
        $handler->save( $ref, $dstPath );

        $this->assertTrue(
            file_exists( $dstPath ),
            'File not correctly saved to new destination.'
        );
    }

    public function testSaveNewfileConvert()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $ref = $handler->load( $srcPath );
        $handler->save( $ref, $dstPath, 'image/png' );

        $analyzer = new ezcImageAnalyzer( $dstPath );

        $this->assertTrue(
            $analyzer->mime === 'image/png',
            'File not correctly saved to new destination.'
        );
    }

    public function testConvertSuccess()
    {
        $filePath = $this->basePath . $this->testFiles['jpeg'];

        $ref = $this->handler->load( $filePath );
        $this->handler->convert( $ref, 'image/png' );

        $handleArr = (array)$this->handler;
        $refProp = $handleArr["\0ezcImageMethodcallHandler\0references"];
        $imageRef = current( $refProp );

        $this->assertTrue(
            $imageRef['mime'] === 'image/png',
            'MIME type conversion not registered correctly.'
        );
    }

    public function testConvertFailure()
    {
        $filePath = $this->basePath . $this->testFiles['jpeg'];

        $ref = $this->handler->load( $filePath );

        try
        {
            $this->handler->convert( $ref, 'application/php' );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( 'Exception for unknown conversion not thrown.' );
    }

    public function testApplyFilterSingle()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $ref = $this->handler->load( $srcPath );
        $this->handler->applyFilter( $ref, new ezcImageFilter( 'scale', array( 'width' => 200, 'height' => 200, 'direction' => ezcImageGeometryFilters::SCALE_BOTH ) ) );
        $this->handler->save( $ref, $dstPath );
        $this->assertEquals(
             '8fdbaa50ce1c403814a623babc7ca686',
             md5_file( $dstPath ),
            'Applying single filter through handler failed.'
        );
    }

    public function testApplyFilterMultiple()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $ref = $this->handler->load( $srcPath );
        $this->handler->applyFilter( $ref, new ezcImageFilter( 'scale', array( 'width' => 200, 'height' => 200, 'direction' => ezcImageGeometryFilters::SCALE_BOTH ) ) );
        $this->handler->applyFilter( $ref, new ezcImageFilter( 'crop', array( 'x' => 50, 'width' => 100, 'y' => 100, 'height' => 100 ) ) );
        $this->handler->applyFilter( $ref, new ezcImageFilter( 'colorspace', array( 'space' => ezcImageColorspaceFilters::COLORSPACE_SEPIA ) ) );
        $this->handler->save( $ref, $dstPath );

        $this->assertEquals(
            '015a3bd639eeb06b2ef5ae081ef9f5b8',
            md5_file( $dstPath ),
            'Applying multiple filter through handler failed.'
        );
    }
}
?>

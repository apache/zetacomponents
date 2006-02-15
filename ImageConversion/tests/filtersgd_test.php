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
 * Test suite for ImageFiltersGd class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionFiltersGdTest extends ezcTestCase
{
    protected $basePath;

    protected $handler;

    protected $imageReference;

    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

	public static function suite()
	{
		return new ezcTestSuite( "ezcImageConversionFiltersGdTest" );
	}

    /**
     * setUp
     *
     * @access public
     */
    public function setUp()
    {
        $this->basePath = dirname( __FILE__ ) . '/data/';
        $this->tmpPath =  $this->createTempDir( 'ezcImageConversionTest' ) . '/';
        $this->handler = new ezcImageGdHandler( ezcImageGdHandler::defaultSettings() );
        $this->imageReference = $this->handler->load( $this->basePath . $this->testFiles['jpeg'] );
    }

    /**
     * tearDown
     *
     * @access public
     */
    public function tearDown()
    {
        unset( $this->handler );
        $this->removeTempDir();
    }

    public function testScaleBoth()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            500,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            377,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleDown_do()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scale( 500, 2, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            3,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            2,
            imagesy( $this->handler->getActiveResource() ),
            'Height of scaled image incorrect.'
        );
    }

    public function testScaleDown_dont()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scale( 500, 200, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            113,
            imagesy( $this->handler->getActiveResource() ),
            'Height of scaled image incorrect.'
        );
    }

    public function testScaleUp_do()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scale( 500, 300, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            398,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            300,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleUp_dont()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scale( 500, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            $oldDim['y'],
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleWidthBoth()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            50,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            37,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleWidthUp_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            113,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleWidthUp_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleWidth( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            300,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            226,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleWidthDown_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleWidth( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            113,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleWidthDown_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            50,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            38,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleHeightBoth()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleHeight( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->assertEquals(
            66,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            50,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleHeightUp_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleHeight( 226, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            300,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            226,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleHeightUp_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleHeight( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->assertEquals(
            150,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            113,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleHeightDown_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleHeight( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            150,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            113,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleHeightDown_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleHeight( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->assertEquals(
            66,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            50,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScalePercent_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scalePercent( 50, 50 );
        $this->assertEquals(
            75,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            57,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScalePercent_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scalePercent( 200, 200 );
        $this->assertEquals(
            300,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            226,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleExact_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleExact( 200, 200 );
        $this->assertEquals(
            200,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            200,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleExact_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleExact( 10, 200 );
        $this->assertEquals(
            10,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            200,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testScaleExact_3()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $oldDim = array(
            'x' => imagesx( $this->handler->getActiveResource() ),
            'y' => imagesy( $this->handler->getActiveResource() ),
        );
        $filters->scaleExact( 200, 10 );
        $this->assertEquals(
            200,
            imagesx( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
        $this->assertEquals(
            10,
            imagesy( $this->handler->getActiveResource() ),
            'Width of scaled image incorrect.'
        );
    }

    public function testCrop_1()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->crop( 50, 38, 50, 37 );
        $this->handler->save( $this->imageReference, $this->tmpPath . 'testCrop_1.jpg' );
        $this->assertEquals(
            '437f836552da040a4571f114aee95315',
            md5_file( $this->tmpPath . 'testCrop_1.jpg' ),
            'md5 sum for cropped file did not match.'
        );
    }

    public function testCrop_2()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->crop( 100, 75, -50, -37 );
        $this->handler->save( $this->imageReference, $this->tmpPath . 'testCrop_2.jpg' );
        $this->assertEquals(
            '437f836552da040a4571f114aee95315',
            md5_file( $this->tmpPath . 'testCrop_2.jpg' ),
            'md5 sum for cropped file did not match.'
        );
    }

    public function testCrop_3()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->crop( 50, 75, 200, -37 );
        $this->handler->save( $this->imageReference, $this->tmpPath . 'testCrop_3.jpg' );
        $this->assertEquals(
            'acbcb000f1e1ec1d7b727b30f30aebb0',
            md5_file( $this->tmpPath . 'testCrop_3.jpg' ),
            'md5 sum for cropped file did not match.'
        );
    }

    public function testColorspaceGrey()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_GREY );
        $this->handler->save( $this->imageReference, $this->tmpPath . 'testColorspaceGrey.jpg' );
        $this->assertEquals(
            '491a2c48f9ced71cd91b12bdc6d4ba35',
            md5_file( $this->tmpPath . 'testColorspaceGrey.jpg' ),
            'md5 sum for grey scaled file did not match.'
        );
    }

    public function testColorspaceMonochrome()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_MONOCHROME );
        $this->handler->save( $this->imageReference, $this->tmpPath . 'testColorspaceMonochrome.jpg' );
        $this->assertEquals(
            'c2acebb7bde3a516ca4eb13a342ec63f',
            md5_file( $this->tmpPath . 'testColorspaceMonochrome.jpg' ),
            'md5 sum for monochrome scaled file did not match.'
        );
    }

    public function testColorspaceSepia()
    {
        $filters = new ezcImageGdFilters( $this->handler );
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_SEPIA );
        $this->handler->save( $this->imageReference, $this->tmpPath . 'testLuminanceSepia.jpg' );
        $this->assertEquals(
            '8a29d998fadd74e8ec8f0a61fa33b390',
            md5_file( $this->tmpPath . 'testLuminanceSepia.jpg' ),
            'md5 sum for sepia lumianted file did not match.'
        );
    }
}
?>

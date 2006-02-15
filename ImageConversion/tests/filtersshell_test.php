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
 * Test suite for ImageFiltersShell class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionFiltersShellTest extends ezcTestCase
{
    protected $basePath;

    protected $handler;

    protected $imageReference;

    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'png'           => 'png.png',
        'xpm'           => 'xpm.xpm',
        'invalid'       => 'text.txt',
    );

    protected $expectedResults = array(
        'testBorder_2' => 'e84cdc684fdc90d3a8bde7abde3538c0',
        'testBorder_5' => 'f26ab77fc309e38fce4788aed70348a2',
        'testColorspaceGrey' => '57d8e16a4a01131fbaecd519162aa095',
        'testColorspaceMonochrome' => '53bc6b9f9e012e875b27143bd3e29e21',
        'testColorspaceSepia' => '1db4c3a057a2546dd56f0d61f8480911',
        'testCrop_1' => 'dc5a31eb43e3b5c9edee54d3c24fc7a3',
        'testCrop_2' => 'dc5a31eb43e3b5c9edee54d3c24fc7a3',
        'testCrop_3' => '524dc9211b054a967db9a444f4b59597',
        'testScale' => 'd0969b833c95c0cabb4e5dbf0100eaa7',
        'testScaleDown_do' => 'd896401cee2e7e9913fc3e0ac8946d6e',
        'testScaleDown_dont' => '902e24014b1d1490a94eaf89be5113a6',
        'testScaleExact_1' => '29814bd3aba32b5e4f0f09d980e55523',
        'testScaleExact_2' => '3e67f58c4ff4abd9f398cf8b8789aa45',
        'testScaleExact_3' => '6963f30c3c8f69e3a86b4d6e3e65b4c6',
        'testScaleHeightBoth' => 'a94cdc09c4071c812963b15b76d6c8c7',
        'testScaleHeightDown_1' => '902e24014b1d1490a94eaf89be5113a6',
        'testScaleHeightDown_2' => '3ce41709bb8df756595942fa5f9b3085',
        'testScaleHeightUp_1' => '332817a9d76d1ff786e0c1974211f60f',
        'testScaleHeightUp_2' => '902e24014b1d1490a94eaf89be5113a6',
        'testScalePercent_1' => 'a94cdc09c4071c812963b15b76d6c8c7',
        'testScalePercent_2' => '29814bd3aba32b5e4f0f09d980e55523',
        'testScaleUp_do' => 'd0969b833c95c0cabb4e5dbf0100eaa7',
        'testScaleUp_dont' => '902e24014b1d1490a94eaf89be5113a6',
        'testScaleWidthBoth' => '4850859d12d6acb12ba3d4488b2a80ee',
        'testScaleWidthDown_1' => '902e24014b1d1490a94eaf89be5113a6',
        'testScaleWidthDown_2' => '4850859d12d6acb12ba3d4488b2a80ee',
        'testScaleWidthUp_1' => '902e24014b1d1490a94eaf89be5113a6',
        'testScaleWidthUp_2' => '33a84244a4dbe99a6e69fe21f1bae6a4',
        'testSwirl_10' => '842f1639c9b2fad83765b1e36e5e66a3',
        'testSwirl_100' => 'c84b8ef31597e64226a3785e5121fb28',
        'testSwirl_50' => '6a55dfa03983bc1849664a7c0212c39b',
    );

	public static function suite()
	{
		return new ezcTestSuite( "ezcImageConversionFiltersShellTest" );
	}

    /**
     * setUp
     *
     * @access public
     */
    public function setUp()
    {
        $this->basePath = dirname( __FILE__ ) . '/data/';
        $this->handler = new ezcImageImagemagickHandler( ezcImageImagemagickHandler::defaultSettings() );
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
    }

    public function testScale()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_BOTH );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleDown_do()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scale( 500, 2, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleDown_dont()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleUp_do()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleUp_dont()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scale( 2, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthBoth()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthUp_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthUp_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleWidth( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthDown_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleWidth( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthDown_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightUp_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleHeight( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightUp_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleHeight( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightDown_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleHeight( 30, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightDown_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleHeight( 30, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScalePercent_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scalePercent( 50, 50 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScalePercent_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleExact( 200, 200 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleExact_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleExact( 200, 200 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleExact_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleExact( 10, 200 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleExact_3()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->scaleExact( 200, 10 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testCrop_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->crop( 50, 38, 50, 37 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testCrop_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->crop( 100, 75, -50, -37 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testCrop_3()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->crop( 50, 75, 250, 38 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testColorspaceGrey()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_GREY );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testColorspaceMonochrome()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_MONOCHROME );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testColorspaceSepia()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_SEPIA );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseUniform()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->noise( 'Uniform' );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseGaussian()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->noise( 'Gaussian' );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseMultiplicative()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->noise( 'Multiplicative' );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseImpulse()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->noise( 'Impulse' );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseLaplacian()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->noise( 'Laplacian' );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoisePoisson()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->noise( 'Poisson' );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testSwirl_10()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->swirl( 10 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testSwirl_50()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->swirl( 50 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testSwirl_100()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->swirl( 100 );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testBorder_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->border( 2, array( 0x00, 0x00, 0xFF ) );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }

    public function testBorder_5()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = new ezcImageImagemagickFilters( $this->handler );
        $filters->border( 5, array( 255, 0, 0 ) );
        $this->handler->save( $this->handler->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->handler->getActiveReference() );
        $this->removeTempDir();
    }
}
?>

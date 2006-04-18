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
        'testScale' => '0eaf5e408963c9af8a56ce2109cc4bcf',
        'testScaleDown_do' => '3e20a6f83b2d280239e095cfd1763d56',
        'testScaleDown_dont' => '297d82aa08ee93be0f6824d50b9b6422',
        'testScaleUp_do' => '0eaf5e408963c9af8a56ce2109cc4bcf',
        'testScaleUp_dont' => '297d82aa08ee93be0f6824d50b9b6422',
        'testScaleWidthBoth' => 'a85cf54ad0577035dd65c550df3e81dd',
        'testScaleWidthUp_1' => '297d82aa08ee93be0f6824d50b9b6422',
        'testScaleWidthUp_2' => '9ecf8dd3f918ed4a133694af0a89bdce',
        'testScaleWidthDown_1' => '297d82aa08ee93be0f6824d50b9b6422',
        'testScaleWidthDown_2' => 'a85cf54ad0577035dd65c550df3e81dd',
        'testScaleHeightUp_1' => 'b6bfedab15f29be6eb6c818172e0631e',
        'testScaleHeightUp_2' => '297d82aa08ee93be0f6824d50b9b6422',
        'testScaleHeightDown_1' => '297d82aa08ee93be0f6824d50b9b6422',
        'testScaleHeightDown_2' => '1b0193c7252790408d869de685fa6ae4',
        'testScalePercent_1' => '934b5a6a72997748de4a2536dbff7f47',
        'testScalePercent_2' => '2964b8b81c60c24b219394b7e236e027',
        'testScaleExact_1' => '2964b8b81c60c24b219394b7e236e027',
        'testScaleExact_2' => 'dfd8e002aec1a993428c98374f594a0b',
        'testScaleExact_3' => '804f8a7567ea190a541a4936de2ce5aa',
        'testCrop_1' => '0e72228abfebdab1f9df8ccfa1cda17b',
        'testCrop_2' => '0e72228abfebdab1f9df8ccfa1cda17b',
        'testCrop_3' => 'bee4239402275d1ea197b8bcc5581e41',
        'testColorspaceGrey' => 'dfb2d024ff62069e3b853783d24962d8',
        'testColorspaceMonochrome' => 'dba54a47a891f02e720c6f7774e5b386',
        'testColorspaceSepia' => '02b992231ca2cbc7e7cbfaeaee549d60',
        'testNoiseUniform' => '10e7b9ca325565d9547fbe71b09b55e6',
        'testNoiseGaussian' => '79709cee3243192943e6d3920f1d1a40',
        'testNoiseMultiplicative' => '4702e59e330b57309f88fae547e199fd',
        'testNoiseImpulse' => 'bcc155f25928fbf77101080f88c60939',
        'testNoiseLaplacian' => '10842d6ee045768d96f4308e9dc28fe2',
        'testNoisePoisson' => 'df01ce929ba08c090990bcd37991dbad',
        'testSwirl_10' => 'bb51c934341e4fb38d7238a986c134a7',
        'testSwirl_50' => '3c1d67fc962b212b3b404acbe21e27ed',
        'testSwirl_100' => 'aa383235ff0da3679184cd0194ec05e5',
        'testBorder_2' => '146b42ba2ae97efdaec673e613ebb9bf',
        'testBorder_5' => '45e2819f4813c674da346999b137eff2',
    );

    protected function getActiveReference()
    {
        $handlerArr = (array) $this->handler;
        return $handlerArr["\0ezcImageMethodcallHandler\0activeReference"];
    }

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
        $filters = $this->handler;
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_BOTH );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleDown_do()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scale( 500, 2, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleDown_dont()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleUp_do()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scale( 500, 500, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleUp_dont()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scale( 2, 2, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthBoth()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_BOTH );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthUp_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthUp_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleWidth( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthDown_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleWidth( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleWidthDown_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleWidth( 50, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightUp_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleHeight( 300, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightUp_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleHeight( 300, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightDown_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleHeight( 30, ezcImageGeometryFilters::SCALE_UP );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleHeightDown_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleHeight( 30, ezcImageGeometryFilters::SCALE_DOWN );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScalePercent_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scalePercent( 50, 50 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScalePercent_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleExact( 200, 200 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleExact_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleExact( 200, 200 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleExact_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleExact( 10, 200 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testScaleExact_3()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->scaleExact( 200, 10 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testCrop_1()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->crop( 50, 38, 50, 37 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testCrop_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->crop( 100, 75, -50, -37 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testCrop_3()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->crop( 50, 75, 250, 38 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testColorspaceGrey()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_GREY );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testColorspaceMonochrome()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_MONOCHROME );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testColorspaceSepia()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->colorspace( ezcImageColorspaceFilters::COLORSPACE_SEPIA );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseUniform()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->noise( 'Uniform' );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseGaussian()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->noise( 'Gaussian' );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseMultiplicative()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->noise( 'Multiplicative' );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseImpulse()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->noise( 'Impulse' );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoiseLaplacian()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->noise( 'Laplacian' );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testNoisePoisson()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->noise( 'Poisson' );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertTrue(
            file_exists( $dstPath ),
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testSwirl_10()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->swirl( 10 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testSwirl_50()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->swirl( 50 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testSwirl_100()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->swirl( 100 );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testBorder_2()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->border( 2, array( 0x00, 0x00, 0xFF ) );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }

    public function testBorder_5()
    {
        $dstPath = $this->createTempDir( str_replace( '::', '_', __METHOD__) . '_' ) . '/result';
        $filters = $this->handler;
        $filters->border( 5, array( 255, 0, 0 ) );
        $this->handler->save( $this->getActiveReference(), $dstPath );
        // echo "\n'".__FUNCTION__."' => '".md5_file( $dstPath )."',\n";
        $this->assertEquals(
            $this->expectedResults[__FUNCTION__],
            md5_file( $dstPath ),
            'Filter <'.__METHOD__.'> did not produce correct output.'
        );
        $this->handler->close( $this->getActiveReference() );
        $this->removeTempDir();
    }
}
?>

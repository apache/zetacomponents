<?php
/**
 * ezcImageConversionTransformationTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ImageTransformation class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionTransformationTest extends ezcTestCase
{
    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'png'           => 'png.png',
        'gif'           => 'gif_nonanimated.gif',
        'animated'      => 'gif_animated.gif',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

    protected $testFiltersSuccess = array();

    protected $testFiltersFailure = array();

    protected $converter;

    protected $basePath;

    protected $testPath;

	public static function suite()
	{
		return new ezcTestSuite( "ezcImageConversionTransformationTest" );
	}

    /**
     * setUp
     *
     * @access public
     */
    public function setUp()
    {
        try
        {
            $this->testFiltersSuccess = array(
                0 => array(
                    0 => new ezcImageFilter(
                        'scaleExact',
                        array(
                            'width'     => 50,
                            'height'    => 50,
                            'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                            )
                        ),
                    1 => new ezcImageFilter(
                        'crop',
                        array(
                            'x'     => 10,
                            'width' => 30,
                            'y'     => 10,
                            'height'=> 30,
                            )
                        ),
                    2 => new ezcImageFilter(
                        'colorspace',
                        array(
                            'space' => ezcImageColorspaceFilters::COLORSPACE_GREY,
                            )
                        ),
                    ),
                1 => array(
                    0 => new ezcImageFilter(
                        'scale',
                        array(
                            'width'     => 50,
                            'height'    => 1000,
                            'direction' => ezcImageGeometryFilters::SCALE_DOWN,
                            )
                        ),
                    2 => new ezcImageFilter(
                        'colorspace',
                        array(
                            'space' => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME,
                            )
                        ),
                    ),
                2 => array(
                    0 => new ezcImageFilter(
                        'scaleHeight',
                        array(
                            'height'    => 70,
                            'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                            )
                        ),
                    2 => new ezcImageFilter(
                        'colorspace',
                        array(
                            'space' => ezcImageColorspaceFilters::COLORSPACE_SEPIA,
                            )
                        ),
                    ),
                );
            $this->testFiltersFailure = array(
                // Nonexistant filter
                0 => array(
                    0 => new ezcImageFilter(
                        'toby',
                        array(
                            'width'     => 50,
                            'height'    => 50,
                            'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                            )
                        ),
                    1 => new ezcImageFilter(
                        'crop',
                        array(
                            'x'     => 10,
                            'width' => 30,
                            'y'     => 10,
                            'height'=> 30,
                            )
                        ),
                    2 => new ezcImageFilter(
                        'colorspace',
                        array(
                            'space' => ezcImageColorspaceFilters::COLORSPACE_GREY,
                            )
                        ),
                    ),
                // Missing option
                1 => array(
                    0 => new ezcImageFilter(
                        'scale',
                        array(
                    )
                        ),
                    2 => new ezcImageFilter(
                        'colorspace',
                        array(
                            'space' => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME,
                            )
                        ),
                    ),
                );

            static $i = 1;
            $this->basePath = dirname( __FILE__ ) . '/data/';
            $conversionsIn = array(
                'image/gif'  => 'image/png',
                'image/xpm'  => 'image/jpeg',
                'image/wbmp' => 'image/jpeg',
            );
            $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' ) ),
                                                       $conversionsIn );
            $this->converter = new ezcImageConverter( $settings );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
    }

    /**
     * tearDown
     *
     * @access public
     */
    public function tearDown()
    {
        unset( $this->converter );
        // $this->removeTempDir();
    }

    public function testConstructSuccess()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
            1 => new ezcImageFilter(
                'scaleWidth',
                array(
                    'width'     => 40,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
            2 => new ezcImageFilter(
                'crop',
                array(
                        'xStart'     => 10,
                        'xEnd'       => 40,
                        'yStart'     => 10,
                        'yEnd'       => 40,
                )
            ),
        );

        $mimeIn = array( 'image/jpeg' );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );

        $transArr = (array)$trans;
        $filters  = $transArr["\0*\0filters"];
        $mimeOut  = $transArr["\0*\0mimeOut"];

        $this->assertEquals(
            $mimeIn,
            $mimeOut,
            'MIME types not registered correctly in transformation.'
        );
        $this->assertEquals(
            $filtersIn,
            $filters,
            'Filters not registered correctly in transformation.'
        );
    }

    public function testConstructFailure_1()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'toby',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( 'image/jpeg' );

        try
        {
            $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Transformation did not throw exception on invalid filter.' );
    }

    public function testConstructFailure_2()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( 'application/toby' );

        try
        {
            $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( 'Transformation did not throw exception on invalid MIME type.' );
    }

    public function testAddFilterSuccess()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $newFilter = new ezcImageFilter(
            'scaleWidth',
            array(
                'width'     => 40,
                'direction' => ezcImageGeometryFilters::SCALE_BOTH,
            )
        );

        $filtersOut = $filtersIn;
        $filtersOut[] = $newFilter;

        $mimeIn = array( 'image/jpeg' );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );

        $trans->addFilter( $newFilter );

        $transArr = (array)$trans;
        $filters  = $transArr["\0*\0filters"];

        $this->assertEquals(
            $filtersOut,
            $filters,
            'Filters not added correctly to transformation.'
        );
    }

    public function testAddFilterFailure()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $newFilter = new ezcImageFilter(
            'toby',
            array(
                'width'     => 40,
                'direction' => ezcImageGeometryFilters::SCALE_BOTH,
            )
        );

        $filtersOut = $filtersIn;
        $filtersOut[] = $newFilter;

        $mimeIn = array( 'image/jpeg' );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );

        try
        {
            $trans->addFilter( $newFilter );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Transformation did not throw exception on invalid filter.' );
    }

    public function testGetOutMimeSuccess_1()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( 'image/jpeg' );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );

        $this->assertEquals(
            'image/jpeg',
            $trans->getOutMime( $this->basePath . $this->testFiles['jpeg'] ),
            'Transformation returned incorrect output MIME type.'
        );
    }

    public function testGetOutMimeSuccess_2()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( 'image/jpeg', 'image/png' );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );

        $this->assertEquals(
            'image/png',
            $trans->getOutMime( $this->basePath . $this->testFiles['gif'] ),
            'Transformation returned incorrect output MIME type.'
        );
    }

    public function testGetOutMimeSuccess_3()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                'scale',
                array(
                    'width'     => 50,
                    'height'    => 50,
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( 'image/jpeg' );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersIn, $mimeIn );

        $this->assertEquals(
            'image/jpeg',
            $trans->getOutMime( $this->basePath . $this->testFiles['gif'] ),
            'Transformation returned incorrect output MIME type.'
        );
    }

    public function testTransformSuccessPng_1()
    {
        $this->commonTransformTestSuccess(
            'png',
            0,
            '0c4c2ab1c373717de4e921b233b9a383',
            __METHOD__
        );
    }

    public function testTransformSuccessPng_2()
    {
        $this->commonTransformTestSuccess(
            'png',
            1,
            '23334301a3ded5850ab11333be60fc1e',
            __METHOD__
        );
    }

    public function testTransformSuccessPng_3()
    {
        $this->commonTransformTestSuccess(
            'png',
            2,
            '0e37f55de6904a5279f1021f35f936a7',
            __METHOD__
        );
    }

    public function testTransformSuccessJpeg_1()
    {
        $this->commonTransformTestSuccess(
            'jpeg',
            0,
            '255d6921b53b79ec38140d2dea0eee96',
            __METHOD__
        );
    }

    public function testTransformSuccessJpeg_2()
    {
        $this->commonTransformTestSuccess(
            'jpeg',
            1,
            'f5ecdad7feb0150a5855486a21f071d5',
            __METHOD__
        );
    }

    public function testTransformSuccessJpeg_3()
    {
        $this->commonTransformTestSuccess(
            'jpeg',
            2,
            'f1a2fede0c65f3d807c66f39f090b399',
            __METHOD__
        );
    }

    public function testTransformSuccessGif_1()
    {
        $this->commonTransformTestSuccess(
            'gif',
            0,
            'fac15d3387899936b4c74417b4a1f1a2',
            __METHOD__
        );
    }

    public function testTransformSuccessGif_2()
    {
        $this->commonTransformTestSuccess(
            'gif',
            1,
            '6db2c00f902bf65ae20d3ff19c05f166',
            __METHOD__
        );
    }

    public function testTransformSuccessGif_3()
    {
        $this->commonTransformTestSuccess(
            'gif',
            2,
            '9c505c2263a65dec7a6167d4f0ae0de1',
            __METHOD__
        );
    }

    public function testTransformSuccessGifAnimated()
    {
        $this->commonTransformTestSuccess(
            'animated',
            2,
            '9a6e0141efc695a7bca2c0889b329935',
            __METHOD__
        );
    }

    public function testTransformFailure_1()
    {
        $this->commonTransformTestFailure(
            'jpeg',
            0,
            'ezcImageFilterNotAvailableException',
            __METHOD__
        );
    }

    public function testTransformFailure_2()
    {
        $this->commonTransformTestFailure(
            'jpeg',
            1,
            'ezcImageTransformationException',
            __METHOD__
        );
    }

    public function testTransformFailure_3()
    {
        $this->commonTransformTestFailure(
            'nonexistant',
            1,
            'ezcBaseFileNotFoundException',
            __METHOD__
        );
    }

    /**
     * Test for bug #8137
     * Test for bug #8137: ImageConversion - ezcImageTransformation fails on 
     * processing multiple images in 1 request.
     * 
     * @return void
     */
    public function testMultiTransform()
    {
        $inFiles = array( 
            $this->basePath . $this->testFiles['jpeg'],
            $this->basePath . $this->testFiles['png'],
        );
        $tmp = $this->createTempDir( str_replace( '::', '_', __METHOD__ ) . '_' );
        $outFiles = array(
             $tmp . '/result1',
             $tmp . '/result2',
        );

        $mimeOut = array( 'image/jpeg' );
        $trans = new ezcImageTransformation( $this->converter, 'test', $this->testFiltersSuccess[0], $mimeOut );

        $trans->transform( $inFiles[0], $outFiles[0] );
        $trans->transform( $inFiles[1], $outFiles[1] );

        $this->assertEquals( '255d6921b53b79ec38140d2dea0eee96', md5_file( $outFiles[0] ) );
        $this->assertEquals( 'bb85f174c3be80459030611b53a43ccb', md5_file( $outFiles[1] ) );

        $this->removeTempDir();
    }

    protected function commonTransformTestSuccess( $inFileRef, $filtersRef, $md5sum, $name )
    {
        $inFile = $this->basePath . $this->testFiles[$inFileRef];
        $outFile = $this->createTempDir( str_replace( '::', '_', $name ) . '_' ) . '/result';

        $mimeIn = array( 'image/jpeg', 'image/png' );
        $trans = new ezcImageTransformation( $this->converter, 'test', $this->testFiltersSuccess[$filtersRef], $mimeIn );

        $trans->transform( $inFile, $outFile );

        // Uncomment to get md5 sums:
        // echo "\n$name: ".md5_file( $outFile )."\n\n";

        $this->assertEquals(
            $md5sum,
            md5_file( $outFile ),
            'Transformation did not produce correct output.'
        );

        // Comment this for visual inspection
        $this->removeTempDir();
    }

    protected function commonTransformTestFailure( $inFileRef, $filtersRef, $exceptionClass, $name )
    {
        $inFile = $this->basePath . $this->testFiles[$inFileRef];
        $outFile = $this->createTempDir( str_replace( '::', '_', $name ) . '_' ) . '/result';

        $mimeIn = array( 'image/jpeg', 'image/png' );

        try
        {
            $trans = new ezcImageTransformation( $this->converter, 'test', $this->testFiltersFailure[$filtersRef], $mimeIn );
            $trans->transform( $inFile, $outFile );
        }
        catch ( Exception $e )
        {
            $this->assertTrue(
                get_class( $e ) === $exceptionClass,
                'Transformation threw incorrect exception class <'.get_class( $e ).'> on invalid data <'.$filtersRef.'>.'
            );
            $this->removeTempDir();
            return;
        }
        $this->fail( 'Transformation did not throw exception on invalid data.' );
        // If we failed, this stays.
        $this->removeTempDir();
    }
}
?>

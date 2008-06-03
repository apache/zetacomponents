<?php
/**
 * ezcImageConversionTransformationTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */


require_once dirname( __FILE__ ) . "/test_case.php";

/**
 * Test suite for ImageTransformation class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionTransformationTest extends ezcImageConversionTestCase
{
    protected $testFiltersSuccess = array();

    protected $testFiltersFailure = array();

    protected $converter;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionTransformationTest" );
	}

    protected function setUp()
    {
        try
        {
            $this->testFiltersSuccess = array(
                0 => array(
                    0 => new ezcImageFilter(
                        "scaleExact",
                        array(
                            "width"     => 50,
                            "height"    => 50,
                            "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                            )
                        ),
                    1 => new ezcImageFilter(
                        "crop",
                        array(
                            "x"     => 10,
                            "width" => 30,
                            "y"     => 10,
                            "height"=> 30,
                            )
                        ),
                    2 => new ezcImageFilter(
                        "colorspace",
                        array(
                            "space" => ezcImageColorspaceFilters::COLORSPACE_GREY,
                            )
                        ),
                    ),
                1 => array(
                    0 => new ezcImageFilter(
                        "scale",
                        array(
                            "width"     => 50,
                            "height"    => 1000,
                            "direction" => ezcImageGeometryFilters::SCALE_DOWN,
                            )
                        ),
                    2 => new ezcImageFilter(
                        "colorspace",
                        array(
                            "space" => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME,
                            )
                        ),
                    ),
                2 => array(
                    0 => new ezcImageFilter(
                        "scaleHeight",
                        array(
                            "height"    => 70,
                            "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                            )
                        ),
                    2 => new ezcImageFilter(
                        "colorspace",
                        array(
                            "space" => ezcImageColorspaceFilters::COLORSPACE_SEPIA,
                            )
                        ),
                    ),
                // Optional parameter dismissed
                3 => array(
                    0 => new ezcImageFilter(
                        "scale",
                        array(
                            "width"     => 50,
                            "height"    => 50,
                            )
                        ),
                    ),
                );
            $this->testFiltersFailure = array(
                // Nonexistant filter
                0 => array(
                    0 => new ezcImageFilter(
                        "toby",
                        array(
                            "width"     => 50,
                            "height"    => 50,
                            "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                            )
                        ),
                    1 => new ezcImageFilter(
                        "crop",
                        array(
                            "x"     => 10,
                            "width" => 30,
                            "y"     => 10,
                            "height"=> 30,
                            )
                        ),
                    2 => new ezcImageFilter(
                        "colorspace",
                        array(
                            "space" => ezcImageColorspaceFilters::COLORSPACE_GREY,
                            )
                        ),
                    ),
                // Missing option
                1 => array(
                    0 => new ezcImageFilter(
                        "scale",
                        array(
                    )
                        ),
                    2 => new ezcImageFilter(
                        "colorspace",
                        array(
                            "space" => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME,
                            )
                        ),
                    ),
                );

            $conversionsIn = array(
                "image/gif"  => "image/png",
                "image/xpm"  => "image/jpeg",
                "image/wbmp" => "image/jpeg",
            );
            if ( ezcBaseFeatures::os() === 'Windows' )
            {
                unset( $conversionsIn["image/xpm"] );
            }
  
            $settings = new ezcImageConverterSettings(
                array( new ezcImageHandlerSettings( "GD", "ezcImageGdHandler" ) ),
                $conversionsIn
            );
            $this->converter = new ezcImageConverter( $settings );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
    }

    protected function tearDown()
    {
        unset( $this->converter );
    }

    public function testConstructSuccess()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
            1 => new ezcImageFilter(
                "scaleWidth",
                array(
                    "width"     => 40,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
            2 => new ezcImageFilter(
                "crop",
                array(
                        "xStart"     => 10,
                        "xEnd"       => 40,
                        "yStart"     => 10,
                        "yEnd"       => 40,
                )
            ),
        );

        $mimeIn = array( "image/jpeg" );

        $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );

        $this->assertAttributeEquals(
            $mimeIn,
            "mimeOut",
            $trans,
            "MIME types not registered correctly in transformation."
        );
        $this->assertAttributeEquals(
            $filtersIn,
            "filters",
            $trans,
            "Filters not registered correctly in transformation."
        );
    }

    public function testConstructFailureFilterNotAvailable()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "toby",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( "image/jpeg" );

        try
        {
            $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Transformation did not throw exception on invalid filter." );
    }

    public function testConstructFailureInvalidMimeType()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( "application/toby" );

        try
        {
            $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Transformation did not throw exception on invalid MIME type." );
    }

    public function testAddFilterSuccess()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $newFilter = new ezcImageFilter(
            "scaleWidth",
            array(
                "width"     => 40,
                "direction" => ezcImageGeometryFilters::SCALE_BOTH,
            )
        );

        $filtersOut = $filtersIn;
        $filtersOut[] = $newFilter;

        $mimeIn = array( "image/jpeg" );

        $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );

        $trans->addFilter( $newFilter );

        $this->assertAttributeEquals(
            $filtersOut,
            "filters",
            $trans,
            "Filters not added correctly to transformation."
        );
    }

    public function testAddFilterFailure()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $newFilter = new ezcImageFilter(
            "toby",
            array(
                "width"     => 40,
                "direction" => ezcImageGeometryFilters::SCALE_BOTH,
            )
        );

        $filtersOut = $filtersIn;
        $filtersOut[] = $newFilter;

        $mimeIn = array( "image/jpeg" );

        $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );

        try
        {
            $trans->addFilter( $newFilter );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Transformation did not throw exception on invalid filter." );
    }

    public function testGetOutMimeSuccessNoTransform()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( "image/jpeg" );

        $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );

        $this->assertEquals(
            "image/jpeg",
            $trans->getOutMime( $this->testFiles["jpeg"] ),
            "Transformation returned incorrect output MIME type."
        );
    }

    public function testGetOutMimeSuccessExplicitTransform()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( "image/jpeg", "image/png" );

        $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );

        $this->assertEquals(
            "image/png",
            $trans->getOutMime( $this->testFiles["gif_nonanimated"] ),
            "Transformation returned incorrect output MIME type."
        );
    }

    public function testGetOutMimeSuccessImplicitTransform()
    {
        $filtersIn = array(
            0 => new ezcImageFilter(
                "scale",
                array(
                    "width"     => 50,
                    "height"    => 50,
                    "direction" => ezcImageGeometryFilters::SCALE_BOTH,
                )
            ),
        );

        $mimeIn = array( "image/jpeg" );

        $trans = new ezcImageTransformation( $this->converter, "test", $filtersIn, $mimeIn );

        $this->assertEquals(
            "image/jpeg",
            $trans->getOutMime( $this->testFiles["gif_nonanimated"] ),
            "Transformation returned incorrect output MIME type."
        );
    }

    public function testTransformSuccessPng_1()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[0],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["png"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            // ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
            20
        );
    }

    public function testTransformFailureText()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[0],
            array( "image/jpeg", "image/png" )
        );

        try
        {
            $trans->transform( $this->testFiles["text"], $this->getTempPath() );
        }
        catch ( ezcImageTransformationException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on invalid image input." );
    }

    public function testTransformSuccessPng_2()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[1],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["png"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessPng_3()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[2],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["png"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            // ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
            40
        );
    }

    public function testTransformSuccessPng_4()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[3],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["png"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            // ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
            20
        );
    }

    public function testTransformSuccessJpeg_1()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[0],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["jpeg"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessJpeg_2()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[1],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["jpeg"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessJpeg_3()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[2],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["jpeg"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessGif_1()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[0],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["gif_nonanimated"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessGif_2()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[1],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["gif_nonanimated"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessGif_3()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[2],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["gif_nonanimated"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            ezcImageConversionTestCase::DEFAULT_SIMILARITY_GAP
        );
    }

    public function testTransformSuccessGifAnimated()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersSuccess[2],
            array( "image/jpeg", "image/png" )
        );
        $trans->transform( $this->testFiles["gif_animated"], $this->getTempPath() );
        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image not generated successfully.",
            7000
        );
    }

    public function testTransformFailureFilterNotAvailable()
    {
        try
        {
            $trans = new ezcImageTransformation(
                $this->converter,
                "test",
                $this->testFiltersFailure[0],
                array( "image/jpeg", "image/png" )
            );
            $trans->transform( $this->testFiles["jpeg"], $this->getTempPath() );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Expected exception not thrown." );

    }

    public function testTransformFailureMissingFilterOption()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersFailure[1],
            array( "image/jpeg", "image/png" )
        );
        try
        {
            $trans->transform( $this->testFiles["jpeg"], $this->getTempPath() );
        }
        catch ( ezcImageTransformationException $e )
        {
            return;
        }
        $this->fail( "Expected exception not thrown." );

    }

    public function testTransformFailureFileNotFound()
    {
        $trans = new ezcImageTransformation(
            $this->converter,
            "test",
            $this->testFiltersFailure[1],
            array( "image/jpeg", "image/png" )
        );
        try
        {
            $trans->transform( $this->testFiles["nonexistent"], $this->getTempPath() );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return;
        }
        $this->fail( "Expected exception not thrown." );

    }

    // Test for bug #8137: ImageConversion - ezcImageTransformation fails on
    public function testMultiTransform()
    {
        $mimeOut = array( "image/jpeg" );
        $trans = new ezcImageTransformation( $this->converter, "test", $this->testFiltersSuccess[0], $mimeOut );

        $trans->transform( $this->testFiles["jpeg"], $this->getTempPath( "jpeg" ) );
        $trans->transform( $this->testFiles["png"], $this->getTempPath( "png" ) );

        $this->assertImageSimilar(
            $this->getReferencePath( "jpeg" ),
            $this->getTempPath( "jpeg" ),
            "Transformation did not produce correct output.",
            2000
        );
        $this->assertImageSimilar(
            $this->getReferencePath( "png" ),
            $this->getTempPath( "png" ),
            "Transformation did not produce correct output.",
            2000
        );
    }
    
    // Test for bug #10949: rename php error if file allread exists
    public function testDoubleTransform()
    {
        $mimeOut = array( "image/jpeg" );
        $trans = new ezcImageTransformation( $this->converter, "test", $this->testFiltersSuccess[0], $mimeOut );

        $resFile = $this->getTempPath( "jpeg" );
        $trans->transform( $this->testFiles["jpeg"], $resFile );
        $trans->transform( $this->testFiles["jpeg"], $resFile );
        
        // Should not fail or produce a notice
    }

    public function testTransformQualityLow()
    {
        $mimeOut = array( "image/jpeg" );
        $opts = new ezcImageSaveOptions();
        $opts->quality     = 0;
        // irrelevant, but set!
        $opts->compression = 9;
        $dstPath =  $this->getTempPath( "jpeg" );
        
        $trans = new ezcImageTransformation( $this->converter, "test", array(), $mimeOut, $opts );
        $trans->transform( $this->testFiles["png"], $dstPath );

        $this->assertThat(
            filesize( $dstPath ),
            $this->lessThan( 2000 ),
            "File saved with too high quality."
        );
    }

    public function testTransformQualityHigh()
    {
        $mimeOut = array( "image/jpeg" );
        $opts = new ezcImageSaveOptions();
        $opts->quality     = 100;
        // irrelevant, but set!
        $opts->compression = 9;
        $dstPath =  $this->getTempPath( "jpeg" );
        
        $trans = new ezcImageTransformation( $this->converter, "test", array(), $mimeOut, $opts );
        $trans->transform( $this->testFiles["png"], $dstPath );

        $this->assertThat(
            filesize( $dstPath ),
            $this->greaterThan( 30000 ),
            "File saved with too low quality."
        );
    }

    public function testTransformCompressionLow()
    {
        $mimeOut = array( "image/png" );
        $opts = new ezcImageSaveOptions();
        $opts->compression = 0;
        // irrelevant, but set!
        $opts->quality     = 100;
        $dstPath =  $this->getTempPath( "png" );
        
        $trans = new ezcImageTransformation( $this->converter, "test", array(), $mimeOut, $opts );
        $trans->transform( $this->testFiles["png"], $dstPath );

        $this->assertThat(
            filesize( $dstPath ),
            $this->greaterThan( 100000 ),
            "File saved with too high compression."
        );
    }

    public function testTransformCompressionHigh()
    {
        $mimeOut = array( "image/png" );
        $opts = new ezcImageSaveOptions();
        $opts->compression = 9;
        // irrelevant, but set!
        $opts->quality     = 100;
        $dstPath =  $this->getTempPath( "png" );
        
        $trans = new ezcImageTransformation( $this->converter, "test", array(), $mimeOut, $opts );
        $trans->transform( $this->testFiles["png"], $dstPath );

        $this->assertThat(
            filesize( $dstPath ),
            $this->lessThan( 40000 ),
            "File saved with too low compression."
        );
    }

    public function testApplyTransformationFailureFileNotReadable()
    {
        $tmpDir  = $this->createTempDir( __CLASS__ );
        $srcFile = "$tmpDir/non_readable_png.png";

        copy( $this->testFiles['png'], $srcFile );
        chmod( $srcFile, 0000 );

        $trans = new ezcImageTransformation( $this->converter, "test", array(), array( 'image/jpeg' ) );
        try
        {
            $trans->transform( $srcFile, $srcFile );
            $this->fail( 'Exception not throwen with unreadable file.' );
        }
        catch ( ezcBaseFilePermissionException $e )
        {}

        $this->removeTempDir();
    }

    public function testApplyTransformationFailureDestinationNotOverwriteable()
    {
        $tmpDir  = $this->createTempDir( __CLASS__ );
        $dstFile = "$tmpDir/non_writeable_png.png";

        touch( $dstFile );
        chmod( dirname( $dstFile ), 0555 );
        clearstatcache();

        $trans = new ezcImageTransformation( $this->converter, "test", array(), array( 'image/jpeg' ) );
        try
        {
            $trans->transform( $this->testFiles['png'], $dstFile );
            $this->fail( 'Exception not throwen with not writeable file.' );
        }
        catch ( ezcImageFileNotProcessableException $e )
        {}
        
        chmod( dirname( $dstFile ), 0777 );
        clearstatcache();

        $this->removeTempDir();
    }

    public function testCreateTransformationFailureInvalidFilters()
    {
        $filters   = $this->testFiltersSuccess[0];
        $filters[] = new stdClass();

        try
        {
            $trans = new ezcImageTransformation( $this->converter, 'test', $filters, array( 'image/jpeg' ) );
            $this->fail( 'Exception not throwen on invalid filter in initial filter array.' );
        }
        catch ( ezcBaseSettingValueException $e )
        {}
    }

    public function testAddFilterBefore()
    {
        $newFilter = new ezcImageFilter(
            'scale',
            array( 'width' => 10, 'height' => 10 )
        );
        $filtersBefore = $this->testFiltersSuccess[0];
        $filtersAfter  = $filtersBefore;
        array_splice( $filtersAfter, 1, 0, array( $newFilter ) );

        $trans = new ezcImageTransformation( $this->converter, 'test', $filtersBefore, array( 'image/jpeg' ) );

        $trans->addFilter( $newFilter, 1 );            

        $this->assertAttributeEquals(
            $filtersAfter,
            'filters',
            $trans
        );
    }

    public function testTransformationChangingHandlersForFilters()
    {
        $gdSettings = new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' );
        $imSettings = new ezcImageHandlerSettings( 'IM', 'ezcImageImagemagickHandler');
        try
        {
            $gd = new ezcImageGdHandler( $gdSettings );
            $im = new ezcImageImagemagickHandler( $imSettings );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            $this->markTestSkipped( 'Needs both image handlers.' );
        }

        $conv = new ezcImageConverter(
            new ezcImageConverterSettings(
                array( $gdSettings, $imSettings )
            )
        );

        $trans = new ezcImageTransformation(
            $conv,
            'test',
            array(
                new ezcImageFilter(
                    'scale',
                    array( 'width' => 100, 'height' => 100 )
                ),
                new ezcImageFilter(
                    'swirl',
                    array( 'value' => 100 )
                ),
            ),
            array( 'image/png' )
        );


        $trans->transform( $this->testFiles['png'], $this->getTempPath() );

        $this->assertImageSimilar(
            $this->getReferencePath(),
            $this->getTempPath(),
            "Image  not generated successfully",
            500
        );
    }

    public function testTransformationChangingHandlersForConversion()
    {
        $gdSettings = new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' );
        $imSettings = new ezcImageHandlerSettings( 'IM', 'ezcImageImagemagickHandler');
        try
        {
            $gd = new ezcImageGdHandler( $gdSettings );
            $im = new ezcImageImagemagickHandler( $imSettings );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            $this->markTestSkipped( 'Needs both image handlers.' );
        }

        $conv = new ezcImageConverter(
            new ezcImageConverterSettings(
                array( $gdSettings, $imSettings )
            )
        );

        $trans = new ezcImageTransformation(
            $conv,
            'test',
            array(
                new ezcImageFilter(
                    'scale',
                    array( 'width' => 100, 'height' => 100 )
                ),
            ),
            array( 'image/g3fax' )
        );


        $trans->transform( $this->testFiles['png'], $this->getTempPath() );

        // No assertion, must simply not throw an exception and just raises code coverage
    }

}
?>

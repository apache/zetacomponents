<?php
/**
 * ezcImageConversionConverterTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . "/test_case.php";

/**
 * Test suite for ImageConverter class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionConverterTest extends ezcImageConversionTestCase
{
    
    protected $converter;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionConverterTest" );
	}

    protected function setUp()
    {
        try
        {
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

    // Constructor tests

    public function testConstructSingleHandlerSuccess()
    {
        $conversionsIn = array(
            "image/gif"  => "image/png",
            "image/xpm"  => "image/jpeg",
            "image/wbmp" => "image/jpeg",
        );
        if ( ezcBaseFeatures::os() === 'Windows' )
        {
            unset( $conversionsIn["image/xpm"] );
        }
        try
        {
            $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( "GD", "ezcImageGdHandler" ) ),
                                                       $conversionsIn );
            $converter = new ezcImageConverter( $settings );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $handlers = $this->readAttribute( $converter, "handlers" );
        $settings = $this->readAttribute( $converter, "settings" );

        $this->assertType(
            "ezcImageGdHandler",
            $handlers["GD"],
            "Handler <GD> is not an instance of ezcImageGdHandler."
        );
        $this->assertEquals(
            $conversionsIn,
            $settings->conversions,
            "Conversions not registered successfully."
        );
    }
    
    public function testConstructFailureInvalidSettings()
    {
        $conversionsIn = array(
            "image/gif"  => "image/png",
            "image/xpm"  => "image/jpeg",
            "image/wbmp" => "image/jpeg",
        );
        if ( ezcBaseFeatures::os() === 'Windows' )
        {
            unset( $conversionsIn["image/xpm"] );
        }
        try
        {
            $settings = new ezcImageConverterSettings(
                array( new stdClass() ),
                $conversionsIn
            );
            $converter = new ezcImageConverter( $settings );
            $this->fail( 'Exception not thrown on invalid handler settings.' );
        }
        catch ( ezcImageHandlerSettingsInvalidException $e )
        {}
    }

    public function testConstructSingleHandlerFailureOutputMimeTypeNotSupported()
    {
        $conversionsIn = array(
            "image/gif"  => "image/png",
            "image/xpm"  => "application/ezc",
            "image/wbmp" => "image/jpeg",
        );
        $settings = new ezcImageConverterSettings(
            array( new ezcImageHandlerSettings( "GD", "ezcImageGdHandler" ) ),
            $conversionsIn
        );
        try
        {
            $converter = new ezcImageConverter( $settings );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Expected excption not thrown when creating ezcImageConverter with unsupported conversion." );
    }

    public function testConstructSingleHandlerFailureInputMimeTypeNotSupported()
    {
        $conversionsIn = array(
            "image/gif"  => "image/png",
            "image/ezc"  => "image/jpeg",
            "image/wbmp" => "image/jpeg",
        );
        $settings = new ezcImageConverterSettings( 
            array( new ezcImageHandlerSettings( "GD", "ezcImageGdHandler" ) ),
            $conversionsIn 
        );

        try
        {
            $converter = new ezcImageConverter( $settings );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Expected excption not thrown when creating ezcImageConverter with unsupported conversion." );
    }

    public function testConstructSingleHandlerFailureHandlerNotAvailable()
    {
        $conversionsIn = array(
            "image/gif"  => "image/png",
            "image/xpm"  => "image/jpeg",
            "image/wbmp" => "image/jpeg",
        );
        $settings = new ezcImageConverterSettings( 
            array( new ezcImageHandlerSettings( "Toby", "fooImageHandlerToby" ) ),
            $conversionsIn
        );
        try
        {
            $converter = new ezcImageConverter( $settings );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Expected excption not thrown when creating ezcImageConverter with unsupported handler." );
    }

    // Transformation tests

    public function testCreateTransformation()
    {
        $transformation = $this->converter->createTransformation( "thumbnail", array(), array() );
        $this->assertType(
            "ezcImageTransformation",
            $transformation,
            "Converter does not return created transformation."
        );
    }

    // Issue #12667: ezcImageConverter doesn't pass saveOptions to
    // ezcImageTransformation.'
    public function testCreateTransformationWithSaveOptions()
    {
        $options = new ezcImageSaveOptions();
        $transformation = $this->converter->createTransformation( "thumbnail", array(), array(), $options );
        $this->assertAttributeSame(
            $options,
            'saveOptions',
            $transformation,
            "Converter did not pass save options correctly."
        );
    }

    // MIME type tests

    public function testAllowsInputSuccess()
    {
        $this->assertTrue(
            $this->converter->allowsInput( "image/jpeg" ),
            "Converter does not allow input MIME type <image/jpeg>. This sounds impossible..."
        );
    }

    public function testAllowsInputFailure()
    {
        $this->assertFalse(
            $this->converter->allowsInput( "application/ezc" ),
            "Converter allows input MIME type <application/ezc>. This sounds impossible..."
        );
    }

    public function testAllowsOutputSuccess()
    {
        $this->assertTrue(
            $this->converter->allowsOutput( "image/jpeg" ),
            "Converter does not allow output MIME type <image/jpeg>. This sounds impossible..."
        );
    }

    public function testAllowsOutputFailure()
    {
        $this->assertFalse(
            $this->converter->allowsOutput( "application/ezc" ),
            "Converter allows output MIME type <application/ezc>. This sounds impossible..."
        );
    }

    public function testGetMimeOutSuccessConversionPerformed()
    {
        $this->assertEquals(
            "image/png",
            $this->converter->getMimeOut( "image/gif" ),
            "Converter converted MIME type incorrectly."
        );
    }

    public function testGetMimeOutSuccessNoConversionPerformed()
    {
        $this->assertEquals(
            "image/jpeg",
            $this->converter->getMimeOut( "image/jpeg" ),
            "Converter converted MIME type incorrectly."
        );
    }

    public function testGetMimeOutFailure()
    {
        try
        {
            $this->converter->getMimeOut( "application/ezc" );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( "Expected exception not thrown when getting output MIME type for invalid input type." );
    }

    // Filter tests

    public function testHasFilterSuccess()
    {
        $this->assertTrue(
            $this->converter->hasFilter( "scale" ),
            "Converter does not have filter <scale>. This sounds impossible..."
        );
    }

    public function testHasFilterFailure()
    {
        $this->assertFalse(
            $this->converter->hasFilter( "ezc" ),
            "Converter has filter <ezc>. This sounds impossible..."
        );
    }

    public function testGetFilterNamesIncluded()
    {
        $standardFilters = array(
             "scale",
             "scaleWidth",
             "scaleHeight",
             "scalePercent",
             "scaleExact",
             "crop",
             "colorspace",
        );
        $this->assertEquals(
            array_intersect( $standardFilters, $this->converter->getFilterNames() ),
            $standardFilters,
            "Converter seems not to support standard filters from GD."
        );
    }

    public function testGetFilterNamesExcluded()
    {
        $impossibleFilters = array(
            "__construct",
            "__destruct",
            "__get",
            "__set",
            "__call",
        );
        $this->assertEquals(
            array_intersect( $impossibleFilters, $this->converter->getFilterNames() ),
            array(),
            "Converter seems to support impossible filters."
        );
    }

    // Conversion tests

    public function testApplyFilterSuccessScale()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();


        $this->converter->applyFilter( 
            new ezcImageFilter( 
                "scale", 
                array( "width" => 10, "height" => 10, "direction" => ezcImageGeometryFilters::SCALE_DOWN ) 
            ),
            $srcPath,
            $dstPath
        );

        $this->assertImageSimilar(
            $this->getReferencePath(),
            $dstPath,
            "Image comparison failed.",
            2000
        );
    }

    public function testApplyFilterSuccessColorspace()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();
        

        $this->converter->applyFilter( new ezcImageFilter( "colorspace", array( "space" => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME ) ),
                                       $srcPath, $dstPath );

        $this->assertImageSimilar(
            $this->getReferencePath(),
            $dstPath,
            "Image comparison failed.",
            2000
        );
    }
    
    public function testApplyFilterSuccessColorspaceDefinedHandler()
    {
        $srcPath = $this->testFiles['jpeg'];
        $dstPath = $this->getTempPath();
        

        $this->converter->applyFilter(
            new ezcImageFilter(
                'colorspace',
                array(
                    'space' => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME
                )
            ),
            $srcPath,
            $dstPath,
            'GD'
        );

        $this->assertImageSimilar(
            $this->getReferencePath(),
            $dstPath,
            "Image comparison failed.",
            2000
        );
    }

    public function testApplyFilterFailureHandlerNotAvailable()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        try
        {
            $this->converter->applyFilter(
                new ezcImageFilter( "colorspace", array( "space" => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME ) ),
                $srcPath,
                $dstPath, 
                "ezc" 
            );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Converter did not throw exception on not available handler while applying filter." );
    }

    public function testApplyFilterFailurewFilterNotAvailable()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        try
        {
            $this->converter->applyFilter(
                new ezcImageFilter( "ezc", array() ),
                $srcPath,
                $dstPath 
            );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Converter did not throw exception on not available filter while applying filter." );
    }

    // Handler retrieval tests

    public function testGetHandlerSuccessNoFilterNoInNoOut()
    {
        $this->assertType(
            "ezcImageHandler",
            $this->converter->getHandler(),
            "Returned object is not an ezcImageHandler."
        );
    }

    public function testGetHandlerSuccessFilterNoInNoOut()
    {
        $this->assertType(
            "ezcImageHandler",
            $this->converter->getHandler( "scale" ),
            "Returned object is not an ezcImageHandler."
        );
    }

    public function testGetHandlerSuccessNoFilterInNoOut()
    {
        $this->assertType(
            "ezcImageHandler",
            $this->converter->getHandler( null, "image/jpeg" ),
            "Returned object is not an ezcImageHandler."
        );
    }

    public function testGetHandlerSuccessNoFilterNoInOut()
    {
        $this->assertType(
            "ezcImageHandler",
            $this->converter->getHandler( null, null, "image/jpeg" ),
            "Returned object is not an ezcImageHandler."
        );
    }

    public function testGetHandlerSuccessFilterInOut()
    {
        $this->assertType(
            "ezcImageHandler",
            $this->converter->getHandler( "scale", "image/jpeg", "image/jpeg" ),
            "Returned object is not an ezcImageHandler."
        );
    }

    public function testGetHandlerFailureFilterNoInNoOut()
    {
        try
        {
            $this->converter->getHandler( "ezc" );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Converter did not throw exception on request of impossible handler." );
    }

    public function testGetHandlerFailureNoFilterInNoOut()
    {
        try
        {
            $this->converter->getHandler( null, "application/ezc" );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Converter did not throw exception on request of impossible handler." );
    }

    public function testGetHandlerFailureNoFilterNoInOut()
    {
        try
        {
            $this->converter->getHandler( null, null, "application/ezc" );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Converter did not throw exception on request of impossible handler." );
    }

    public function testGetHandlerFailureNotAvailableFilterInOut()
    {
        try
        {
            $this->converter->getHandler( "ezc", "application/ezc", "application/ezc" );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( "Converter did not throw exception on request of impossible handler." );
    }

    public function testCreateTransformationFailureCreatedTwice()
    {
        $this->converter->createTransformation( 'foo', array(), array() );

        try
        {
            $this->converter->createTransformation( 'foo', array(), array() );
            $this->fail( 'Expected not thrown on double created transformation.' );
        }
        catch ( ezcImageTransformationAlreadyExistsException $e )
        {}
    }

    public function testRemoveTransformationSuccess()
    {
        $this->converter->createTransformation( 'foo', array(), array() );
        $transformations = $this->readAttribute( $this->converter, "transformations" );

        $this->assertEquals(
            1,
            count( $transformations )
        );
        
        $this->converter->removeTransformation( 'foo' );

        $transformations = $this->readAttribute( $this->converter, "transformations" );
        $this->assertEquals(
            0,
            count( $transformations )
        );
    }

    public function testRemoveTransformationFailureNotExists()
    {
        try
        {
            $this->converter->removeTransformation( 'foo' );
            $this->fail( 'Expected not thrown on remove of non-existent transformation.' );
        }
        catch ( ezcImageTransformationNotAvailableException $e )
        {}
    }

    public function testApplyTransformationSuccess()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $this->converter->createTransformation(
            'foo',
            array(
                new ezcImageFilter(
                    "colorspace",
                    array(
                        "space" => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME
                    )
                ),
            ),
            array( 'image/jpeg' )
        );
        $this->converter->transform( 'foo', $srcPath, $dstPath );
    }

    public function testApplyTransformationFailureNonExistent()
    {
        try
        {
            $this->converter->transform( 'foo', '', '' );
            $this->fail( 'Expected not thrown when non-existent transformation should be applied.' );
        }
        catch ( ezcImageTransformationNotAvailableException $e )
        {}
    }
}
?>

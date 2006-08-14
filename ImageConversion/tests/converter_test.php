<?php
/**
 * ezcImageConversionConverterTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ImageConverter class.
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionConverterTest extends ezcTestCase
{
    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

    protected $converter;

	public static function suite()
	{
		return new ezcTestSuite( "ezcImageConversionConverterTest" );
	}

    /**
     * setUp
     *
     * @access public
     */
    public function setUp()
    {
        static $i = 1;
        $this->basePath = dirname( __FILE__ ) . '/data/';
        $this->testPath = $this->createTempDir('ezcImageConversionHandlerTest_' . sprintf( '%03d', $i++ ) . '_' ) . '/';
        $conversionsIn = array(
            'image/gif'  => 'image/png',
            'image/xpm'  => 'image/jpeg',
            'image/wbmp' => 'image/jpeg',
        );

        try
        {
            $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' ) ),
                                                   $conversionsIn );
            $this->converter = new ezcImageConverter( $settings );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
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
        $this->removeTempDir();
    }

    public function testConstructSingleHandlerSuccess()
    {
        $conversionsIn = array(
            'image/gif'  => 'image/png',
            'image/xpm'  => 'image/jpeg',
            'image/wbmp' => 'image/jpeg',
        );
        $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' ) ),
                                                   $conversionsIn );
        $converter = new ezcImageConverter( $settings );

        $converterArr = (array)$converter;
        $handlers = $converterArr["\0*\0handlers"];
        $settings = $converterArr["\0*\0settings"];

        $this->assertTrue(
            $handlers['GD'] instanceof ezcImageGdHandler,
            'Handler <GD> is not an instance of ezcImageGdHandler.'
        );
        $this->assertEquals(
            $conversionsIn,
            $settings->conversions,
            'Conversions not registered successfully.'
        );
    }

    public function testConstructSingleHandlerFailure_1()
    {
        $conversionsIn = array(
            'image/gif'  => 'image/png',
            'image/xpm'  => 'application/php',
            'image/wbmp' => 'image/jpeg',
        );
        $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' ) ),
                                                   $conversionsIn );
        try
        {
            $converter = new ezcImageConverter( $settings );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( 'Expected excption not thrown when creating ezcImageConverter with unsupported conversion.' );
    }

    public function testConstructSingleHandlerFailure_2()
    {
        $conversionsIn = array(
            'image/gif'  => 'image/png',
            'image/toby'  => 'image/jpeg',
            'image/wbmp' => 'image/jpeg',
        );
        $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'GD', 'ezcImageGdHandler' ) ),
                                                   $conversionsIn );
        try
        {
            $converter = new ezcImageConverter( $settings );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( 'Expected excption not thrown when creating ezcImageConverter with unsupported conversion.' );
    }

    public function testConstructSingleHandlerFailure_3()
    {
        $conversionsIn = array(
            'image/gif'  => 'image/png',
            'image/xpm'  => 'image/jpeg',
            'image/wbmp' => 'image/jpeg',
        );
        $settings = new ezcImageConverterSettings( array( new ezcImageHandlerSettings( 'Toby', 'ezcImageHandlerToby' ) ),
                                                   $conversionsIn );
        try
        {
            $converter = new ezcImageConverter( $settings );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Expected excption not thrown when creating ezcImageConverter with unsupported handler.' );
    }

    public function testCreateTransformation()
    {
        $transformation = $this->converter->createTransformation( "thumbnail", array(), array() );
        $this->assertEquals(
            "ezcImageTransformation",
            get_class( $transformation ),
            'Converter does not return created transformation.'
        );
    }

    public function testAllowsInputSuccess()
    {
        $this->assertTrue(
            $this->converter->allowsInput( 'image/jpeg' ),
            'Converter does not allow input MIME type <image/jpeg>. This sounds impossible...'
        );
    }

    public function testAllowsInputFailure()
    {
        $this->assertFalse(
            $this->converter->allowsInput( 'application/toby' ),
            'Converter allows input MIME type <application/toby>. This sounds impossible...'
        );
    }

    public function testAllowsOutputSuccess()
    {
        $this->assertTrue(
            $this->converter->allowsOutput( 'image/jpeg' ),
            'Converter does not allow output MIME type <image/jpeg>. This sounds impossible...'
        );
    }

    public function testAllowsOutputFailure()
    {
        $this->assertFalse(
            $this->converter->allowsOutput( 'application/toby' ),
            'Converter allows output MIME type <application/toby>. This sounds impossible...'
        );
    }

    public function testGetMimeOutSuccess_1()
    {
        $this->assertEquals(
            'image/png',
            $this->converter->getMimeOut( 'image/gif' ),
            'Converter converted MIME type incorrectly.'
        );
    }

    public function testGetMimeOutSuccess_2()
    {
        $this->assertEquals(
            'image/jpeg',
            $this->converter->getMimeOut( 'image/jpeg' ),
            'Converter converted MIME type incorrectly.'
        );
    }

    public function testGetMimeOutFailure()
    {
        try
        {
            $this->converter->getMimeOut( 'application/toby' );
        }
        catch ( ezcImageMimeTypeUnsupportedException $e )
        {
            return;
        }
        $this->fail( 'Expected exception not thrown when getting output MIME type for invalid input type.' );
    }

    public function testHasFilterSuccess()
    {
        $this->assertTrue(
            $this->converter->hasFilter( 'scale' ),
            'Converter does not have filter <scale>. This sounds impossible...'
        );
    }

    public function testHasFilterFailure()
    {
        $this->assertFalse(
            $this->converter->hasFilter( 'toby' ),
            'Converter has filter <toby>. This sounds impossible...'
        );
    }

    public function testGetFilterNames_1()
    {
        $standardFilters = array(
             'scale',
             'scaleWidth',
             'scaleHeight',
             'scalePercent',
             'scaleExact',
             'crop',
             'colorspace',
        );
        $this->assertEquals(
            array_intersect( $standardFilters, $this->converter->getFilterNames() ),
            $standardFilters,
            'Converter seems not to support standard filters from GD.'
        );
    }

    public function testGetFilterNames_2()
    {
        $impossibleFilters = array(
            '__construct',
            '__destruct',
            '__get',
            '__set',
            '__call',
        );
        $this->assertEquals(
            array_intersect( $impossibleFilters, $this->converter->getFilterNames() ),
            array(),
            'Converter seems to support impossible filters.'
        );
    }

    public function testApplyFilterSuccess_1()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $this->converter->applyFilter( new ezcImageFilter( 'scale', array( 'width' => 10, 'height' => 10, 'direction' => ezcImageGeometryFilters::SCALE_DOWN ) ),
                                       $srcPath, $dstPath );

        $this->assertTrue(
            file_exists( $dstPath ),
            'Applying filter through converter failed.'
        );
    }

    public function testApplyFilterSuccess_2()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $this->converter->applyFilter( new ezcImageFilter( 'colorspace', array( 'space' => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME ) ),
                                       $srcPath, $dstPath );

        $this->assertEquals(
            'c2acebb7bde3a516ca4eb13a342ec63f',
            md5_file( $dstPath ),
            'Applying filter through converter produced incorrect result.'
        );
    }

    public function testApplyFilterFailure_1()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        try
        {
            $this->converter->applyFilter( new ezcImageFilter( 'colorspace', array( 'space' => ezcImageColorspaceFilters::COLORSPACE_MONOCHROME ) ),
                                           $srcPath, $dstPath, 'toby' );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Converter did not throw exception on not available handler while applying filter.' );
    }

    public function testApplyFilterFailure_2()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        try
        {
            $this->converter->applyFilter( new ezcImageFilter( 'toby', array() ),
                                           $srcPath, $dstPath );
        }
        catch ( ezcImageFilterNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Converter did not throw exception on not available filter while applying filter.' );
    }

    public function testGetHandlerSuccess_1()
    {
        $this->assertType(
            'ezcImageHandler',
            $this->converter->getHandler(),
            'Returned object is not an ezcImageHandler.'
        );
    }

    public function testGetHandlerSuccess_2()
    {
        $this->assertType(
            'ezcImageHandler',
            $this->converter->getHandler( 'scale' ),
            'Returned object is not an ezcImageHandler.'
        );
    }

    public function testGetHandlerSuccess_3()
    {
        $this->assertType(
            'ezcImageHandler',
            $this->converter->getHandler( null, 'image/jpeg' ),
            'Returned object is not an ezcImageHandler.'
        );
    }

    public function testGetHandlerSuccess_4()
    {
        $this->assertType(
            'ezcImageHandler',
            $this->converter->getHandler( null, null, 'image/jpeg' ),
            'Returned object is not an ezcImageHandler.'
        );
    }

    public function testGetHandlerSuccess_5()
    {
        $this->assertType(
            'ezcImageHandler',
            $this->converter->getHandler( 'scale', 'image/jpeg', 'image/jpeg' ),
            'Returned object is not an ezcImageHandler.'
        );
    }

    public function testGetHandlerFailure_1()
    {
        try
        {
            $this->converter->getHandler( 'toby' );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Converter did not throw exception on request of impossible handler.' );
    }

    public function testGetHandlerFailure_2()
    {
        try
        {
            $this->converter->getHandler( null, 'application/toby' );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Converter did not throw exception on request of impossible handler.' );
    }

    public function testGetHandlerFailure_3()
    {
        try
        {
            $this->converter->getHandler( null, null, 'application/toby' );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Converter did not throw exception on request of impossible handler.' );
    }

    public function testGetHandlerFailure_4()
    {
        try
        {
            $this->converter->getHandler( 'toby', 'application/toby', 'application/toby' );
        }
        catch ( ezcImageHandlerNotAvailableException $e )
        {
            return;
        }
        $this->fail( 'Converter did not throw exception on request of impossible handler.' );
    }
}
?>

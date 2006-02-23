<?php
/**
 * ezcImageConversionHandlerTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ImageHandler class.
 * This class contains all tests that are common between backend handlers.
 * This test suite assumes, that every handler
 *
 * - implements the geometry filter
 * - allows input and output of the MIME type image/jpeg
 * - disallows input and output of MIME type foo/bar
 *
 * @package ImageConversion
 * @version //autogentag//
 */
class ezcImageConversionHandlerTest extends ezcTestCase
{
    protected $basePath;

    protected $testPath;

    protected $handlerClass;

    protected $handler;

    protected $testFiles = array(
        'jpeg'          => 'jpeg.jpg',
        'nonexistant'   => 'nonexisting.jpg',
        'invalid'       => 'text.txt',
    );

	public static function suite()
	{
		return new ezcTestSuite( "ezcImageConversionHandlerTest" );
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
        $this->testPath = $this->createTempDir(get_class($this) . '_' . sprintf( '%03d', $i++ ) . '_' ) . '/';
        $this->handler  = new $this->handlerClass( call_user_func( array( $this->handlerClass, 'defaultSettings' ) ) );
    }

    /**
     * tearDown
     *
     * @access public
     */
    public function tearDown()
    {
        $this->removeTempDir();
    }

    public function testSaveOldfileNoconvert()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        copy( $srcPath, $dstPath );

        $ref = $this->handler->load( $dstPath );

        unlink( $dstPath );

        $this->handler->save( $ref );

        $this->assertTrue(
            file_exists( $dstPath ),
            'File not correctly saved to old destination.'
        );
        $this->handler->close( $ref );
        $this->removeTempDir();
    }

    public function testSaveNewfileNoconvert()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $ref = $this->handler->load( $srcPath );
        $this->handler->save( $ref, $dstPath );

        $this->assertTrue(
            file_exists( $dstPath ),
            'File not correctly saved to new destination.'
        );
        $this->handler->close( $ref );
        $this->removeTempDir();
    }

    public function testSaveNewfileConvert()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $dstPath = $this->testPath . __METHOD__;

        $ref = $this->handler->load( $srcPath );
        $this->handler->save( $ref, $dstPath, 'image/png' );

        $analyzer = new ezcImageAnalyzer( $dstPath );

        $this->assertTrue(
            $analyzer->mime === 'image/png',
            'File not correctly saved to new destination.'
        );
        $this->handler->close( $ref );
        $this->removeTempDir();
    }

    public function testCloseSuccess()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        $ref = $this->handler->load( $srcPath );
        $this->handler->close( $ref );

        $handleArr = (array)$this->handler;
        $refProp = $handleArr["\0ezcImageMethodcallHandler\0references"];

        $this->assertFalse(
            isset( $refProp[$ref] ),
            'Reference not freed successfully.'
        );
    }

    public function testCloseFailure()
    {
        $srcPath = $this->basePath . $this->testFiles['jpeg'];
        try
        {
            $this->handler->close( 'abc' );
        }
        catch ( ezcImageInvalidReferenceException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on close of invalid reference.' );
    }

    public function testAllowsInputSuccess()
    {
        $this->assertTrue(
            $this->handler->allowsInput( 'image/jpeg' ),
            "Handler <{$this->handlerClass}> does not allow input of <image/jpeg> MIME type."
        );
    }

    public function testAllowsInputFailure()
    {
        $this->assertFalse(
            $this->handler->allowsInput( 'foo/bar' ),
            "Handler <{$this->handlerClass}> does allow input of weired <foo/bar> MIME type."
        );
    }

    public function testAllowsOutputSuccess()
    {
        $this->assertTrue(
            $this->handler->allowsOutput( 'image/jpeg' ),
            "Handler <{$this->handlerClass}> does not allow input of <image/jpeg> MIME type."
        );
    }

    public function testAllowsOutputFailure()
    {
        $this->assertFalse(
            $this->handler->allowsOutput( 'foo/bar' ),
            "Handler <{$this->handlerClass}> does allow input of weired <foo/bar> MIME type."
        );
    }

    public function testHasFilterSuccess()
    {
        $this->assertTrue(
            $this->handler->hasFilter( 'scale' ),
            'Does not every handler support the scale filter?'
        );
    }

    public function testHasFilterFailure()
    {
        $this->assertFalse(
            $this->handler->hasFilter( 'toby' ),
            'Hey, who implements a filter called "toby"??'
        );
    }

    public function testGetFilterNamesSuccess()
    {
        $availFilters = $this->handler->getFilterNames();
        $geometryFilters = get_class_methods( 'ezcImageGeometryFilters' );
        foreach ( $geometryFilters as $id => $filter )
        {
            if ( substr( $filter, 0, 1 ) === '_' )
            {
                unset( $geometryFilters[$id] );
            }
        }

        $this->assertEquals(
            array_intersect( $geometryFilters, $availFilters  ),
            $geometryFilters,
            "Geometry filters seem not to be available in the filters for <{$this->handlerClass}>."
        );
    }

    public function testGetFilterNamesFailure()
    {
        $availFilters = $this->handler->getFilterNames();
        $unavailFilters = array( 'toby', 'derick', 'frederick', '__construct', '__destruct', '_whatever' );

        $this->assertEquals(
            array_intersect( $unavailFilters, $availFilters  ),
            array(),
            "Weird filters seem not to be available in the filters for <{$this->handlerClass}>."
        );
    }
}
?>

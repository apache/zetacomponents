<?php
/**
 * ezcImageConversionHandlerTest
 *
 * @package ImageConversion
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . "/test_case.php";

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
class ezcImageConversionHandlerTest extends ezcImageConversionTestCase
{

    protected $handlerClass;

    protected $handler;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcImageConversionHandlerTest" );
	}

    protected function setUp()
    {
        $this->handler  = new $this->handlerClass( call_user_func( array( $this->handlerClass, "defaultSettings" ) ) );
    }

    protected function getReferences()
    {
        $handlerArr = ( array ) $this->handler;
        $references = $handlerArr["\0ezcImageMethodcallHandler\0references"];
        return $references;
    }

    public function testSaveOldfileNoconvert()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        copy( $srcPath, $dstPath );

        $ref = $this->handler->load( $dstPath );

        unlink( $dstPath );

        $this->handler->save( $ref );

        $this->assertTrue(
            file_exists( $dstPath ),
            "File not correctly saved to old destination."
        );
        $this->handler->close( $ref );
    }

    public function testSaveNewfileNoconvert()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $ref = $this->handler->load( $srcPath );
        $this->handler->save( $ref, $dstPath );

        $this->assertTrue(
            file_exists( $dstPath ),
            "File not correctly saved to new destination."
        );
        $this->handler->close( $ref );
    }

    public function testSaveNewfileConvert()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath();

        $ref = $this->handler->load( $srcPath );
        $this->handler->save( $ref, $dstPath, "image/png" );

        $analyzer = new ezcImageAnalyzer( $dstPath );

        $this->assertEquals(
            "image/png",
            $analyzer->mime,
            "File not correctly saved to new destination."
        );
        $this->handler->close( $ref );
    }

    public function testSaveIllegalFileNameFailure()
    {
        $srcPath = $this->testFiles["jpeg"];
        $dstPath = $this->getTempPath() . "$";

        $ref = $this->handler->load( $srcPath );

        $exceptionCaught = false;
        try
        {
            $this->handler->save( $ref, $dstPath, "image/png" );
        }
        catch ( ezcImageFileNameInvalidException $e )
        {
            $this->handler->close( $ref );
            return;
        }
        $this->fail( "ezcImageFileNameInvalidException not thrown on illigal character $." );
    }

    public function testCloseFailure()
    {
        try
        {
            $this->handler->close( "abc" );
        }
        catch ( ezcImageInvalidReferenceException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on close of invalid reference." );
    }

    public function testAllowsInputSuccess()
    {
        $this->assertTrue(
            $this->handler->allowsInput( "image/jpeg" ),
            "Handler <{$this->handlerClass}> does not allow input of <image/jpeg> MIME type."
        );
    }

    public function testAllowsInputFailure()
    {
        $this->assertFalse(
            $this->handler->allowsInput( "foo/bar" ),
            "Handler <{$this->handlerClass}> does allow input of weired <foo/bar> MIME type."
        );
    }

    public function testAllowsOutputSuccess()
    {
        $this->assertTrue(
            $this->handler->allowsOutput( "image/jpeg" ),
            "Handler <{$this->handlerClass}> does not allow input of <image/jpeg> MIME type."
        );
    }

    public function testAllowsOutputFailure()
    {
        $this->assertFalse(
            $this->handler->allowsOutput( "foo/bar" ),
            "Handler <{$this->handlerClass}> does allow input of weired <foo/bar> MIME type."
        );
    }

    public function testHasFilterSuccess()
    {
        $this->assertTrue(
            $this->handler->hasFilter( "scale" ),
            "Does not every handler support the scale filter?"
        );
    }

    public function testHasFilterFailure()
    {
        $this->assertFalse(
            $this->handler->hasFilter( "ezc" ),
            "Hey, who implements a filter called <ezc>??"
        );
    }

    public function testGetFilterNamesSuccess()
    {
        $availFilters = $this->handler->getFilterNames();
        $geometryFilters = get_class_methods( "ezcImageGeometryFilters" );
        foreach ( $geometryFilters as $id => $filter )
        {
            if ( substr( $filter, 0, 1 ) === "_" )
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
        $unavailFilters = array( "toby", "derick", "frederick", "ray", "__construct", "__destruct", "_whatever" );

        $this->assertEquals(
            array_intersect( $unavailFilters, $availFilters  ),
            array(),
            "Weird filters seem not to be available in the filters for <{$this->handlerClass}>."
        );
    }
}
?>

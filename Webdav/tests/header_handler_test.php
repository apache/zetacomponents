<?php
/**
 * Test case for the ezcWebdavHeaderHandler class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Tests for ezcWebdavHeaderHandler class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavHeaderHandlerTest extends ezcWebdavTestCase
{
    private $oldServer;

    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $this->oldServer = $_SERVER;
        $_SERVER         = array();
    }

    public function tearDown()
    {
        $_SERVER = $this->oldServer;
    }

    /**
     * testParseAuthorizationHeader 
     * 
     * @param mixed $headerContent 
     * @param mixed $expectedValue 
     * @return void
     *
     * @dataProvider provideAuthorizationHeaderSets
     */
    public function testParseAuthorizationHeader( $headerContent, $expectedValue )
    {
        $_SERVER['HTTP_AUTHORIZATION'] = $headerContent;

        $headerHandler = new ezcWebdavHeaderHandler();
        $value = $headerHandler->parseHeader( 'Authorization' );

        $this->assertEquals(
            $expectedValue,
            $value,
            'Value for Authorization not parsed correctly.'
        );

    }

    /**
     * testParseDepthHeader 
     * 
     * @param mixed $headerContent 
     * @param mixed $expectedValue 
     * @return void
     *
     * @dataProvider provideDepthTestSets
     */
    public function testParseDepthHeader( $headerContent, $expectedValue )
    {
        $_SERVER['HTTP_DEPTH'] = $headerContent;

        $headerHandler = new ezcWebdavHeaderHandler();
        $value = $headerHandler->parseHeader( 'Depth' );

        $this->assertEquals(
            $expectedValue,
            $value,
            'Value for Depth not parsed correctly.'
        );

    }

    /**
     * testParseIfMatchHeaderCorrect 
     * 
     * @param mixed $headerContent 
     * @param mixed $expectedValue 
     * @return void
     *
     * @dataProvider provideIfMatchTestSets
     */
    public function testParseIfMatchHeaderCorrect( $headerContent, $expectedValue )
    {
        $_SERVER['HTTP_IF_MATCH'] = $headerContent;

        $headerHandler = new ezcWebdavHeaderHandler();
        $value = $headerHandler->parseHeader( 'If-Match' );

        $this->assertEquals(
            $expectedValue,
            $value,
            'Value for If-Match-Header not parsed correctly.'
        );
    }

    /**
     * testParseIfNoneMatchHeaderCorrect 
     * 
     * @param mixed $headerContent 
     * @param mixed $expectedValue 
     * @return void
     *
     * @dataProvider provideIfMatchTestSets
     */
    public function testParseIfNoneMatchHeaderCorrect( $headerContent, $expectedValue )
    {
        $_SERVER['HTTP_IF_NONE_MATCH'] = $headerContent;

        $headerHandler = new ezcWebdavHeaderHandler();
        $value = $headerHandler->parseHeader( 'If-None-Match' );

        $this->assertEquals(
            $expectedValue,
            $value,
            'Value for If-None-Match-Header not parsed correctly.'
        );
    }

    public function testParseHeaderFailure()
    {
        $headerHandler = new ezcWebdavHeaderHandler();

        try
        {
            $headerHandler->parseHeader( 'Some Header' );
            $this->fail( 'Exception not thrown on request to parse unknown header.' );
        }
        catch ( ezcWebdavUnknownHeaderException $e ) {}
    }

    public function testParseHeaderNotAvailable()
    {
        $_SERVER = array();

        $headerHandler = new ezcWebdavHeaderHandler();
        
        $this->assertNull(
            $headerHandler->parseHeader( 'Depth' )
        );
    }

    public function testParseHeaderWithAlternatives()
    {
        $headerHandler = new ezcWebdavHeaderHandler();

        $_SERVER = array(
            'HTTP_CONTENT_LENGTH' => 23,
        );
        
        $this->assertEquals(
            23,
            $headerHandler->parseHeader( 'Content-Length' )
        );

        $_SERVER = array(
            'CONTENT_LENGTH' => 23,
        );
        
        $this->assertEquals(
            23,
            $headerHandler->parseHeader( 'Content-Length' )
        );

        $_SERVER = array();
        
        $this->assertNull(
            $headerHandler->parseHeader( 'Content-Length' )
        );
    }

    /**
     * testParseHeaders 
     * 
     * @param array $serverArr 
     * @param array $desiredHeaders 
     * @param array $expectedResult 
     * @return void
     *
     * @dataProvider provideParseHeadersTestSets
     */
    public function testParseHeaders( array $serverArr, array $desiredHeaders, array $expectedResult )
    {
        $_SERVER = $serverArr;
        
        $headerHandler = new ezcWebdavHeaderHandler();
        $result = $headerHandler->parseHeaders( $desiredHeaders );

        $this->assertEquals(
            $expectedResult,
            $result,
            'Headers not parsed correctly.'
        );
    }
    
    // Data providers

    public static function provideAuthorizationHeaderSets()
    {
        return array(
            array( 'Basic Zm9vOmJhcg==', new ezcWebdavBasicAuth( 'foo', 'bar' ) ),
            array( 'Basic     dXNlcjpwYXNz   ', new ezcWebdavBasicAuth( 'user', 'pass' ) ),
            array( 'Basic dXNlcjpwYXNzd2l0aDppbml0', new ezcWebdavBasicAuth( 'user', 'passwith:init' ) ),
        );
    }

    public static function provideDepthTestSets()
    {
        return array(
            array( '0', ezcWebdavRequest::DEPTH_ZERO ),
            array( '1', ezcWebdavRequest::DEPTH_ONE ),
            array( 'infinity', ezcWebdavRequest::DEPTH_INFINITY ),
            array( '  0    ', ezcWebdavRequest::DEPTH_ZERO ),
            array( ' 1   ', ezcWebdavRequest::DEPTH_ONE ),
            array( ' infinity     ', ezcWebdavRequest::DEPTH_INFINITY ),
            array( 'some misc test', 'some misc test' ),
        );
    }

    public static function provideIfMatchTestSets()
    {
        return array(
            array( '"Simple tag"', array( 'Simple tag' ) ),
            array( '"one tag", "another tag", "a third tag"', array( "one tag", "another tag", "a third tag" ) ),
            array( '"abc", "xyz"', array( 'abc', 'xyz' ) ),
            array( '"with empty", "", "tag"', array( 'with empty', '', 'tag' ) ),
            array( '  "with additional"  ,  "characters", ..  "in it"', array( 'with additional', 'characters', 'in it' ) ),
            array( '*', true ),
            array( '  * ', true ),
        );
    }

    public static function provideParseHeadersTestSets()
    {
        return array(
            // Set 1
            array(
                array(
                    'HTTP_DEPTH' => 0,
                ),
                array(
                    'Depth',
                ),
                array(
                    'Depth' => ezcWebdavRequest::DEPTH_ZERO,
                ),
            ),
            // Set 2
            array(
                array(
                    'HTTP_DEPTH' => 0,
                ),
                array(
                    'Depth',
                    'Content-Type',
                ),
                array(
                    'Depth' => ezcWebdavRequest::DEPTH_ZERO,
                ),
            ),
            // Set 3
            array(
                array(
                    'HTTP_DEPTH'      => 1,
                    'CONTENT_TYPE'    => 'text/plain; charset=utf-8',
                    'HTTP_LOCK_TOKEN' => 'abc'
                ),
                array(
                    'Depth',
                ),
                array(
                    'Depth' => ezcWebdavRequest::DEPTH_ONE,
                ),
            ),
            // Set 4
            array(
                array(
                    'HTTP_DEPTH'      => 1,
                    'CONTENT_TYPE'    => 'text/plain; charset=utf-8',
                    'HTTP_LOCK_TOKEN' => 'abc'
                ),
                array(
                    'Depth',
                    'Content-Type',
                    'Lock-Token',
                ),
                array(
                    'Depth'        => ezcWebdavRequest::DEPTH_ONE,
                    'Content-Type' => 'text/plain; charset=utf-8',
                    'Lock-Token'   => 'abc'
                ),
            ),
            // Set 4
            array(
                array(
                    'HTTP_DEPTH'      => 1,
                    'CONTENT_TYPE'    => 'text/plain; charset=utf-8',
                    'HTTP_LOCK_TOKEN' => 'abc',
                    'HTTP_IF_MATCH'   => '"foo", "bar", "baz"',
                ),
                array(
                    'Depth',
                    'Content-Type',
                    'Lock-Token',
                ),
                array(
                    'Depth'        => ezcWebdavRequest::DEPTH_ONE,
                    'Content-Type' => 'text/plain; charset=utf-8',
                    'Lock-Token'   => 'abc',
                    'If-Match'     => array( 'foo', 'bar', 'baz' ),
                ),
            ),
            // Set 5
            array(
                array(
                    'HTTP_DEPTH'      => 1,
                    'CONTENT_TYPE'    => 'text/plain; charset=utf-8',
                    'HTTP_LOCK_TOKEN' => 'abc',
                    'HTTP_IF_MATCH'   => '"foo", "bar", "baz"',
                    'HTTP_IF_NONE_MATCH'   => '"bar"',
                ),
                array(
                    'Depth',
                    'Content-Type',
                    'Lock-Token',
                ),
                array(
                    'Depth'        => ezcWebdavRequest::DEPTH_ONE,
                    'Content-Type' => 'text/plain; charset=utf-8',
                    'Lock-Token'   => 'abc',
                ),
            ),
        );
    }
}


?>

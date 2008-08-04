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
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
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
        $_SERVER                  = array();
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
        $_SERVER                       = array();
        $_SERVER['HTTP_IF_NONE_MATCH'] = $headerContent;

        $headerHandler = new ezcWebdavHeaderHandler();
        $value = $headerHandler->parseHeader( 'If-None-Match' );

        $this->assertEquals(
            $expectedValue,
            $value,
            'Value for If-None-Match-Header not parsed correctly.'
        );
    }
}


?>

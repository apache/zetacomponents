<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

include_once( 'Authentication/tests/test.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationUrlTest extends ezcAuthenticationTest
{
    public static $url = "http://ezc.myopenid.com";
    public static $urlIncomplete = "ezc.myopenid.com";
    public static $urlNonexistent = "xxx";
    public static $urlWithPort = "http://www.google.com:80";
    public static $urlWithQuery = "http://www.myopenid.com/server?action=login";
    public static $urlNoHost = "/server";
    public static $urlEmpty = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationUrlTest" );
    }

    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testOpenidUrlNormalizeUrl()
    {
        $url = self::$url;

        $result = ezcAuthenticationUrl::normalize( $url );
        $expected = 'http://ezc.myopenid.com';
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidUrlNormalizeUrlIncomplete()
    {
        $url = self::$urlIncomplete;

        $result = ezcAuthenticationUrl::normalize( $url );
        $expected = 'http://ezc.myopenid.com';
        $this->assertEquals( $expected, $result );
    }

    public function testOpenidUrlNormalizeUrlNonexistent()
    {
        $url = self::$urlNonexistent;

        $result = ezcAuthenticationUrl::normalize( $url );
        $expected = 'http://xxx';
        $this->assertEquals( $expected, $result );
    }

    public function testUrlAppendQueryWithPort()
    {
        $url = self::$urlWithPort;

        $result = ezcAuthenticationUrl::appendQuery( $url, 'nonce', '123456' );
        $expected = 'http://www.google.com:80/?nonce=123456';
        $this->assertEquals( $expected, $result );
    }

    public function testUrlAppendQueryNoQuery()
    {
        $url = self::$url;

        $result = ezcAuthenticationUrl::appendQuery( $url, 'nonce', '123456' );
        $expected = 'http://ezc.myopenid.com/?nonce=123456';
        $this->assertEquals( $expected, $result );
    }

    public function testUrlAppendQueryExistingQuery()
    {
        $url = self::$urlWithQuery;

        $result = ezcAuthenticationUrl::appendQuery( $url, 'nonce', '123456' );
        $expected = 'http://www.myopenid.com/server?action=login&nonce=123456';
        $this->assertEquals( $expected, $result );
    }

    public function testUrlAppendQueryNoHost()
    {
        $url = self::$urlNoHost;

        $result = ezcAuthenticationUrl::appendQuery( $url, 'nonce', '123456' );
        $expected = '/server?nonce=123456';
        $this->assertEquals( $expected, $result );
    }

    public function testUrlAppendQueryEmpty()
    {
        $url = self::$urlEmpty;

        $result = ezcAuthenticationUrl::appendQuery( $url, 'nonce', '123456' );
        $expected = '?nonce=123456';
        $this->assertEquals( $expected, $result );
    }

    public function testUrlFetchQueryNoQuery()
    {
        $url = self::$url;

        $result = ezcAuthenticationUrl::fetchQuery( $url, 'nonce' );
        $expected = null;
        $this->assertEquals( $expected, $result );
    }

    public function testUrlFetchQueryWithQuery()
    {
        $url = self::$urlWithQuery;

        $result = ezcAuthenticationUrl::fetchQuery( $url, 'action' );
        $expected = 'login';
        $this->assertEquals( $expected, $result );
    }
}
?>

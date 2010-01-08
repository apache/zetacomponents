<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
    protected static $queriesParseQueryString = array( // original URL, parse result, http_build_query() result

        array( '',                              array(),                                                     '' ),
        array( 'foo',                           array( 'foo'    => null ),                                    'foo=' ),

        array( 'foo=bar',                       array( 'foo'    => 'bar' ),                                   'foo=bar' ),
        array( 'foo[]=bar',                     array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[][]=bar',                   array( 'foo'    => array( array( 'bar' ) ) ),                 'foo[0][0]=bar' ),
        array( 'foo[][][]=bar',                 array( 'foo'    => array( array( array( 'bar' ) ) ) ),        'foo[0][0][0]=bar' ),

        array( 'foo[][]=bar&foo=baz',           array( 'foo'    => 'baz' ),                                   'foo=baz' ),
        array( 'foo[][]=bar&foo[]=baz',         array( 'foo'    => array( array( 'bar' ), 'baz' ) ),          'foo[0][0]=bar&foo[1]=baz' ),
        array( 'foo[]=bar&foo[][]=baz',         array( 'foo'    => array( 'bar', array( 'baz' ) ) ),          'foo[0]=bar&foo[1][0]=baz' ),
        array( 'foo[][]=bar&foo[][]=baz',       array( 'foo'    => array( array( 'bar' ), array( 'baz' ) ) ), 'foo[0][0]=bar&foo[1][0]=baz' ),
        array( 'foo=bar&answer=42',             array( 'foo'    => 'bar', 'answer' => '42' ),                 'foo=bar&answer=42' ),
        array( 'foo[]=bar&answer=42',           array( 'foo'    => array( 'bar' ), 'answer' => '42' ),        'foo[0]=bar&answer=42' ),
        array( 'foo[]=bar&answer=42&foo[]=baz', array( 'foo'    => array( 'bar', 'baz' ), 'answer' => '42' ), 'foo[0]=bar&foo[1]=baz&answer=42' ),

        array( 'foo=bar&amp;answer=42',         array( 'foo'    => 'bar', 'amp;answer' => '42' ),             'foo=bar&amp;answer=42' ),

        array( 'foo[0]=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[1]=bar',                    array( 'foo'    => array( 1 => 'bar' ) ),                     'foo[1]=bar' ),
        array( 'foo[0]=bar&foo[0]=baz',         array( 'foo'    => array( 'baz' ) ),                          'foo[0]=baz' ),
        array( 'foo[0][0]=bar&foo[0]=baz',      array( 'foo'    => array( 'baz' ) ),                          'foo[0]=baz' ),

        array( 'foo=ba+r',                      array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba%20r',                    array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba r',                      array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba.r',                      array( 'foo'    => 'ba.r' ),                                  'foo=ba.r' ),

        array( 'fo.o=bar',                      array( 'fo.o'   => 'bar' ),                                   'fo.o=bar' ),
        array( 'fo.o[]=bar',                    array( 'fo.o'   => array( 'bar' ) ),                          'fo.o[0]=bar' ),
        array( 'fo:o=bar',                      array( 'fo:o'   => 'bar' ),                                   'fo:o=bar' ),
        array( 'fo;o=bar',                      array( 'fo;o'   => 'bar' ),                                   'fo;o=bar' ),
        array( 'foo()=bar',                     array( 'foo()'  => 'bar' ),                                   'foo()=bar' ),
        array( 'foo{}=bar',                     array( 'foo{}'  => 'bar' ),                                   'foo{}=bar' ),

        array( 'fo.o=bar&answer=42',            array( 'fo.o'   => 'bar', 'answer' => 42 ),                   'fo.o=bar&answer=42' ),

        array( 'foo[=bar',                      array( 'foo_'   => 'bar' ),                                   'foo_=bar' ),
        array( 'foo[[=bar',                     array( 'foo_['  => 'bar' ),                                   'foo_[=bar' ),
        array( 'foo]=bar',                      array( 'foo]'   => 'bar' ),                                   'foo]=bar' ),
        array( 'foo]]=bar',                     array( 'foo]]'  => 'bar' ),                                   'foo]]=bar' ),
        array( 'foo][=bar',                     array( 'foo]_'  => 'bar' ),                                   'foo]_=bar' ),
        array( 'foo[[]=bar',                    array( 'foo'    => array( '[' => 'bar' ) ),                   'foo[[]=bar' ),
        array( 'foo][]=bar',                    array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[][=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[]]=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo][[=bar',                    array( 'foo]_[' => 'bar' ),                                   'foo]_[=bar' ),

        array( 'fo[o=bar',                      array( 'fo_o'   => 'bar' ),                                   'fo_o=bar' ),
        array( 'fo[[o=bar',                     array( 'fo_[o'  => 'bar' ),                                   'fo_[o=bar' ),
        array( 'fo]o=bar',                      array( 'fo]o'   => 'bar' ),                                   'fo]o=bar' ),
        array( 'fo]]o=bar',                     array( 'fo]]o'  => 'bar' ),                                   'fo]]o=bar' ),
        array( 'fo][o=bar',                     array( 'fo]_o'  => 'bar' ),                                   'fo]_o=bar' ),
        array( 'foo[[]o=bar',                   array( 'foo'    => array( '[' => 'bar' ) ),                   'foo[[]=bar' ),
        array( 'foo][]o=bar',                   array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[][o=bar',                   array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[]]o=bar',                   array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'fo[]o=bar',                     array( 'fo'     => array( 'bar' ) ),                          'fo[0]=bar' ),
        array( 'fo][[o=bar',                    array( 'fo]_[o' => 'bar' ),                                   'fo]_[o=bar' ),

        array( 'foo[[0]o=bar',                  array( 'foo'    => array( '[0' => 'bar' ) ),                  'foo[[0]=bar' ),
        array( 'foo][0]o=bar',                  array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[0][o=bar',                  array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[0]]o=bar',                  array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'fo[0]o=bar',                    array( 'fo'     => array( 'bar' ) ),                          'fo[0]=bar' ),
        );

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

    public function testParseQueryString()
    {
        foreach ( self::$queriesParseQueryString as $query )
        {
            $params = ezcAuthenticationUrl::parseQueryString( $query[0] );

            $this->assertEquals( $query[1], $params, "Failed parsing '{$query[0]}'" );
            $this->assertEquals( $query[2], urldecode( http_build_query( $params ) ), "Failed building back the query '{$query[0]}' to '{$query[2]}'" );
        }
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

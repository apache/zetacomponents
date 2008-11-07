<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/testclasses.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsHttpResponseWriterTest extends ezcTestCase
{
    public function setUp()
    {
        if ( !extension_loaded( 'xdebug' ) )
        {
            self::markTestSkipped( "Xdebug is required." );
        }
    }

    public static function doTest( $response )
    {
        $writer = new ezcMvcHttpResponseWriter( $response );

        ob_start();
        $writer->handleResponse();
        $contents = ob_get_contents();
        ob_end_clean();

        return array( xdebug_get_headers(), $contents );
    }

    public static function testSimple()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testGenerator()
    {
        $result = new ezcMvcResult;
        $response = new ezcMvcResponse;
        $response->generator = "Albert";
        $response->body = "Ze body.";
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: Albert",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testCookie()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->cookies[] = new ezcMvcResultCookie( 'simple', 'one' );
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            'Content-Length: 8',
            "Set-Cookie: simple=one",
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testCookies()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->cookies[] = new ezcMvcResultCookie( 'simple', 'one' );
        $response->cookies[] = new ezcMvcResultCookie(
            'complex', 'e=mc^2', new DateTime( 'August 30th, 2008 UTC' ),
            'ez.no', '/test', true, true );
        $response->cookies[] = new ezcMvcResultCookie(
            'speed', 'v=9.8*(m/s^2)', null, '', '', false, true );
        $response->cookies[] = new ezcMvcResultCookie( 'warp', 'G=(8*pi/c^4)GT' );
        $response->cookies[3]->expire = new DateTime( 'Dec 12, 2034 UTC' );
        $response->cookies[3]->secure = true;
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            'Content-Length: 8',
            "Set-Cookie: simple=one",
            "Set-Cookie: complex=e%3Dmc%5E2; expires=Sat, 30-Aug-2008 00:00:00 GMT; path=/test; domain=ez.no; secure; httponly",
            "Set-Cookie: speed=v%3D9.8%2A%28m%2Fs%5E2%29; httponly",
            "Set-Cookie: warp=G%3D%288%2Api%2Fc%5E4%29GT; expires=Tue, 12-Dec-2034 00:00:00 GMT; secure",
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }


    public static function testDate()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->date = new DateTime( '2008-07-22 15:03 Europe/Oslo' );
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: Tue, 22 Jul 2008 13:03:00 GMT",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testCache()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->cache = new ezcMvcResultCache;
        $response->cache->vary = '*';
        $response->cache->expire = new DateTime( '2008-12-22 09:15 Europe/Amsterdam' );
        $response->cache->controls = array( 'no-cache', 'must-revalidate' );
        $response->cache->pragma = 'no-cache';
        $response->cache->lastModified = new DateTime( '2008-07-22 09:15 Europe/Amsterdam' );
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            "Vary: *",
            "Expires: Mon, 22 Dec 2008 08:15:00 GMT",
            "Cache-Control: no-cache, must-revalidate",
            "Pragma: no-cache",
            "Last-Modified: Tue, 22 Jul 2008 07:15:00 GMT",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testContentLanguage()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->content = new ezcMvcResultContent;
        $response->content->language = 'en-GB';
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            "Content-Language: en-GB",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testContentLanguage2()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->content = new ezcMvcResultContent;
        $response->content->language = 'en-US';
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            "Content-Language: en-US",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testContentTypeCharset1()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->content = new ezcMvcResultContent;
        $response->content->type = 'text/html+test';
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            "Content-type: text/html+test;charset=utf-8",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testContentTypeCharset2()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->content = new ezcMvcResultContent;
        $response->content->type = 'text/html+test';
        $response->content->charset = 'latin1';
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            "Content-Type: text/html+test; charset=latin1",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function testContentTypeCharset3()
    {
        $response = new ezcMvcResponse;
        $response->body = "Ze body.";
        $response->content = new ezcMvcResultContent;
        $response->content->charset = 'utf-8';
        
        list( $headers, $body ) = self::doTest( $response );

        $expectedHeaders = array(
            "X-Powered-By: eZ Components MvcTools",
            "Date: " . date_create("UTC")->format( 'D, d M Y H:i:s \G\M\T'  ),
            "Content-Type: text/html; charset=utf-8",
            'Content-Length: 8',
        );

        self::assertSame( $expectedHeaders, $headers );
        self::assertSame( "Ze body.", $body );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

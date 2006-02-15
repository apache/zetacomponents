<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Http
 * @subpackage Tests
 */

/**
 * @package Http
 * @subpackage Tests
 */
class ezcHttpUrlTest extends ezcTestCase
{
    public function testMiscURLs()
    {
        $this->checkUrl( 'http://ez.no' );
        $this->checkUrl( 'https://my.com:81/path/to/the_cript.php?a=v1&b=v2#top' );
        $this->checkUrl( 'www.linux.org/home' ); // this will be treated ath path, not host/path.
    }

    public function testPrepend()
    {
        ezcHttpUrl::addPrefix( 'site', '/mysite/' );
        ezcHttpUrl::addPrefix( 'image', '/mysite/images/' );

        $uri = ezcHttpUrl::prepend( 'image', 'icons/arrow.png' );
        $this->assertEquals( '/mysite/images/icons/arrow.png', $uri );

        $uri = ezcHttpUrl::prepend( 'image', 'home.png' );
        $this->assertEquals( '/mysite/images/home.png', $uri );

        $uri = ezcHttpUrl::prepend( 'site', 'company/about' );
        $this->assertEquals( '/mysite/company/about', $uri );
    }

    private function checkUrl( $referenceUrlString )
    {
        $url = new ezcHttpUrl( $referenceUrlString );
        $restortedUrlString = $url->build();
        $this->AssertEquals( $referenceUrlString, $restortedUrlString );
    }

    public static function suite()
    {
         return new ezcTestSuite( 'ezcHttpUrlTest' );
    }
}

?>

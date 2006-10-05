<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlTest extends ezcTestCase
{
    protected function setUp()
    {
        if ( version_compare( phpversion(), '5.2.0dev', '>=' ) )
        {
            $this->markTestSkipped( "This test does not work with PHP 5.2 or later." );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcUrlTest" );
    }

    public function testConstructor()
    {
        $url = new ezcUrl( 'http://user:password@www.example.com:82/index.php/other/stuff?me=you&arr[0]=yes&arr[1]=no#cat' );
        $this->assertEquals( 'http', $url->scheme );
        $this->assertEquals( 'www.example.com', $url->host );
        $this->assertEquals( 'user', $url->user );
        $this->assertEquals( 'password', $url->pass );
        $this->assertEquals( 82, $url->port );
        $this->assertEquals( array( 'index.php', 'other', 'stuff' ), $url->path );
        $this->assertEquals( array( 'me' => 'you', 'arr' => array( 'yes', 'no' ) ), $url->query );
        $this->assertEquals( 'cat', $url->fragment );
    }

    public function testBuildUrlFromScratch()
    {
        $reference = "http://user:pass@www.example.com:82/first/second?me=you&you=me#cat";
        $url = new ezcUrl();
        $url->scheme = 'http';
        $url->user = 'user';
        $url->pass = 'pass';
        $url->host = 'www.example.com';
        $url->port = '82';
        $url->path[0] = 'first';
        $url->path[1] = 'second';
        $url->query['me'] = 'you';
        $url->query['you'] = 'me';
        $url->fragment = 'cat';
        $this->assertEquals( $reference, $url->toString() );
    }

    public function testToString()
    {
        $urlStrings = array();
        $urlStrings[] = 'http://www.example.com';
        $urlStrings[] = 'http://www.example.com/index.php';
        $urlStrings[] = 'http://www.example.com/index.php/other/stuff#cat';
        $urlStrings[] = 'http://www.example.com:82/index.php/other/stuff#cat';
        $urlStrings[] = 'http://user:password@www.example.com:82/index.php/other/stuff#cat';
        $urlStrings[] = 'http://user:password@www.example.com:82/index.php/other/stuff?me=you&arr[0]=yes&arr[1]=no#cat';

        foreach( $urlStrings as $urlString )
        {
            $url = new ezcUrl( $urlString );
//            echo $url->toString() . "\n";
            $this->assertEquals( $urlString, $url->toString() );
        }

    }

    public function testGetPathElementsCount()
    {
        $url = new ezcUrl( 'http://www.example.com/one/two/three/four/five/six#anchor' );
//        var_dump( $url->path );
//        $url->path[3] = "This works!";
//        print_r( $url );
        $this->assertEquals( 6, $url->getPathElementsCount() );
    }

    public function testPrefixPathStringAbsoluteConstructor()
    {
        $reference = 'http://www.example.com/var/images/image.jpg';
        ezcUrl::registerPrefix( 'images', '/var/images/' );
        $url = new ezcUrl( 'http://www.example.com/image.jpg', 'images' );
        $this->assertEquals( $reference, $url->toString() );
    }

    public function testPrefixPathStringAbsolute()
    {
        $reference = 'http://www.example.com/var/images/image.jpg';
        ezcUrl::registerPrefix( 'images', '/var/images/' );
        $url = new ezcUrl( 'http://www.example.com/image.jpg' );
        $url->prefix( 'images' );
        $this->assertEquals( $reference, $url->toString() );
    }

    public function testPrefixPathStringRelative()
    {
        $reference = '/var/images/image.jpg';
        ezcUrl::registerPrefix( 'images', '/var/images/' );
        $this->assertEquals( $reference, ezcUrl::prefixPathString( 'images', 'image.jpg' ) );
    }

    public function testPrefixPathStringFailure()
    {
        try
        {
            ezcUrl::prefixPathString( 'no_such_prefix', 'image.jpg' );
        }catch( ezcUrlPrefixNotFoundException $e ) { return; }
        $this->fail( "Did not get exception when it was expected" );
    }

    public function testPrefixPathStringConstructorFailure()
    {
        try
        {
            $url = new ezcUrl( "http://www.example.com", 'no_such_prefix' );
        }catch( ezcUrlPrefixNotFoundException $e ) { return; }
        $this->fail( "Did not get exception when it was expected" );
    }

    public function testIsRelativeFalse()
    {
        $url = new ezcUrl( "http://www.example.com/blah/index.php"  );
        $this->assertEquals( false, $url->isRelative() );
    }

    public function testIsRelativeTrue()
    {
        $url = new ezcUrl( "blah/index.php"  );
        $this->assertEquals( true, $url->isRelative() );
    }

    public function testNamePathElement()
    {
        $url = new ezcUrl( "http://www.example.com/one/two/three/index.php"  );
        $url->namePathElement( 0, 'first' );
        $this->assertEquals( 'one', $url->path['first'] );

        $url->path['first'] = 'the_one';
        $this->assertEquals( 'the_one', $url->path[0] );
    }
}

?>

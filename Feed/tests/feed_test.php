<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

include_once( 'Feed/tests/test.php' );

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedTest extends ezcFeedTestCase
{
    public function testGetSupportedTypes()
    {
        $types = ezcFeed::getSupportedTypes();
        $expected = array( 'rss1', 'rss2', 'atom' );
        $this->assertEquals( $expected, $types );
    }

    public function testCreateFeedSupported()
    {
        $feed = new ezcFeed( 'rss1' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
    }

    public function testCreateFeedNotSupported()
    {
        try
        {
            $feed = new ezcFeed( 'molecule' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedTypeException $e )
        {
            $this->assertEquals( "The feed type 'molecule' is not supported.", $e->getMessage() );
        }
    }

    public function testAddModuleSupported()
    {
        $feed = new ezcFeed( 'rss2' );
        $this->assertEquals( false, isset( $feed->DublinCore ) );
        $feed->addModule( 'ezcFeedModuleDublinCore' );
        $this->assertEquals( true, isset( $feed->DublinCore ) );
    }

    public function testAddModuleNotSupported()
    {
        $feed = new ezcFeed( 'rss2' );
        try
        {
            $feed->addModule( 'stdClass' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedModuleException $e )
        {
            $this->assertEquals( "The module 'stdClass' is not supported.", $e->getMessage() );
        }
    }

    public function testFeedNonExistentLocal()
    {
        try
        {
            $feed = ezcFeed::parse( 'not-here.xml' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file 'not-here.xml' could not be found.", $e->getMessage() );
        }
    }

    public function testFeedNonExistentRemote()
    {
        try
        {
            $feed = ezcFeed::parse( 'http://ez.no/not-here.xml' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file 'http://ez.no/not-here.xml' could not be found.", $e->getMessage() );
        }
    }

    public function testFeedExistsRemote()
    {
        $feed = ezcFeed::parse( 'http://ez.no/rss/feed/communitynews' );
    }

    public function testParseContentBroken()
    {
        try
        {
            $feed = ezcFeed::parseContent( 'bad XML document' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedParseErrorException $e )
        {
            $this->assertEquals( "Parse error while parsing feed: Content is no valid XML.", $e->getMessage() );
        }
    }

    public function testParseContentNotRecognized()
    {
        try
        {
            $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><xxx>Content</xxx>' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedCanNotParseException $e )
        {
            $expected = "' could not be parsed: Feed type not recognized.";
            $result = substr( $e->getMessage(), strlen( $e->getMessage() ) - 48 );
            $this->assertEquals( $expected, $result );
        }
    }

    public function testFeedProperties()
    {
        $feed = new ezcFeed( 'rss2' );

        $this->readonlyPropertyTest( $feed, 'items' );
        $this->readonlyPropertyTest( $feed, 'image' );

        try
        {
            $value = $feed->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }

    public function testFeedItemProperties()
    {
        $feed = new ezcFeed( 'rss2' );
        $feedItem = $feed->newItem();

        try
        {
            $value = $feedItem->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }

    public function testFeedImageProperties()
    {
        $feed = new ezcFeed( 'rss2' );
        $feedImage = $feed->newImage();

        $feedImage = $feed->image;

        try
        {
            $value = $feedImage->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }

    public function testFeedItemSetMetaDataFail()
    {
        $feed = new ezcFeed( 'rss2' );
        $feedItem = $feed->newItem();

        try
        {
            $feedItem->setMetaData( 'title', array() );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcFeedOnlyOneValueAllowedException $e )
        {
            $this->assertEquals( "The attribute 'title' supports only singular values.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcFeedTest" );
    }
}

?>

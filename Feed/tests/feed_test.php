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
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testGetSupportedTypes()
    {
        $types = ezcFeed::getSupportedTypes();
        $expected = array( 'rss1', 'rss2', 'atom' );
        $this->assertEquals( $expected, $types );
    }

    public function testCreateFeedSupportedRss1()
    {
        $feed = new ezcFeed( 'rss1' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'rss1', $feed->getFeedType() );
        $this->assertEquals( 'application/rss+xml', $feed->getContentType() );
    }

    public function testCreateFeedSupportedRss2()
    {
        $feed = new ezcFeed( 'rss2' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'application/rss+xml', $feed->getContentType() );
    }

    public function testCreateFeedSupportedAtom()
    {
        $feed = new ezcFeed( 'atom' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );
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

    public function testParseBroken()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}rss2{$dot}regression{$dot}parse{$dot}incomplete{$dot}broken.in";

        try
        {
            $feed = ezcFeed::parse( $file );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedCanNotParseException $e )
        {
            $this->assertEquals( "The feed '{$file}' could not be parsed: {$file} is not a valid XML file.", $e->getMessage() );
        }
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

    public function testParseAtom1()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}atom{$dot}data{$dot}atom_example_from_specs.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );
    }

    public function testParseAtom2()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}atom{$dot}data{$dot}atom_multiple_entries.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'atom', $feed->getFeedType() );
        $items = $feed->items;
        $expectedTitles = array(
            'Atom-Powered Robots Run Amok 1',
            'Atom-Powered Robots Run Amok 2',
            );

        $titles = array();
        foreach ( $items as $item )
        {
            $titles[] = $item->title->__toString();
        }

        $this->assertEquals( $expectedTitles, $titles );
    }

    public function testParseRss1()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}rss1{$dot}data{$dot}rss1_example_from_specs.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'rss1', $feed->getFeedType() );
        $this->assertEquals( 'application/rss+xml', $feed->getContentType() );
    }

    public function testParseRss2()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}rss2{$dot}data{$dot}rss2_example_from_specs.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'application/rss+xml', $feed->getContentType() );
    }

    public function testParseRss2Podcast1()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}rss2{$dot}data{$dot}librivox_podcast.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'LibriVox Audiobooks', $feed->title->__toString() );
    }

    public function testParseRss2Podcast2()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}rss2{$dot}data{$dot}woodsongs_old_time_radio_hour.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'The Woodsongs Old Time Radio Hour Podcast', $feed->title->__toString() );
    }
}
?>

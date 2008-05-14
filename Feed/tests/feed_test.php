<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
        catch ( ezcFeedParseErrorException $e )
        {
            $this->assertEquals( "Parse error while parsing feed '{$file}': It is not a valid XML file.", $e->getMessage() );
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
        catch ( ezcFeedParseErrorException $e )
        {
            $expected = "Feed type not recognized.";
            $result = substr( $e->getMessage(), strlen( $e->getMessage() ) - 25 );
            $this->assertEquals( $expected, $result );
        }
    }

    public function testParseRss2NoVersion()
    {
        try
        {
            $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><rss><channel><title>RSS no version</title><item><title>Item no version</title></item></channel></rss>' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedParseErrorException $e )
        {
            $expected = "Feed type not recognized.";
            $result = substr( $e->getMessage(), strlen( $e->getMessage() ) - 25 );
            $this->assertEquals( $expected, $result );
        }
    }

    public function testParseRss2UnsupportedVersion()
    {
        try
        {
            $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><rss version="unsupported version"><channel><title>RSS unsupported version</title><item><title>Item unsupported version</title></item></channel></rss>' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedParseErrorException $e )
        {
            $expected = "Feed type not recognized.";
            $result = substr( $e->getMessage(), strlen( $e->getMessage() ) - 25 );
            $this->assertEquals( $expected, $result );
        }
    }

    public function testParseModuleNotRecognized()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><feed xmlns="http://www.w3.org/2005/Atom"><unsupported_module:element>Content</unsupported_module:element></feed>' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );
    }

    public function testParseContentModuleElementNotRecognized()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/"><entry><content:unsupported_element>Content</content:unsupported_element></entry></feed>' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );
    }

    public function testParseContentModuleWrongNamespace()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/dc/elements/1.1/"><entry><content:encoded>Content</content:encoded></entry></feed>' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );

        // The Content module should not appear in any entry because it has a wrong namespace
        foreach ( $feed->item as $item )
        {
            $this->assertEquals( false, $item->hasModule( 'Content' ) );
        }
    }

    public function testParseDCModuleElementNotRecognized()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><feed xmlns="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/"><entry><dc:unsupported_element>Content</dc:unsupported_element></entry></feed>' );
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );
    }

    public function testParseAtomUnsupportedModule()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}atom{$dot}data{$dot}atom_example_from_specs.xml";

        $feed = ezcFeed::parse( $file );

        try
        {
            $module = $feed->unsupported_module;
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedModuleException $e )
        {
            $this->assertEquals( "The module 'unsupported_module' is not supported.", $e->getMessage() );
        }
    }

    public function testParseAtomUndefinedModule()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}atom{$dot}data{$dot}atom_example_from_specs.xml";

        $feed = ezcFeed::parse( $file );

        try
        {
            $module = $feed->iTunes;
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUndefinedModuleException $e )
        {
            $this->assertEquals( "The module 'iTunes' is not defined yet.", $e->getMessage() );
        }
    }

    public function testParseAtom1()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}atom{$dot}data{$dot}atom_example_from_specs.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'atom', $feed->getFeedType() );
        $this->assertEquals( 'application/atom+xml', $feed->getContentType() );
        $this->assertEquals( false, isset( $feed->skipDays ) );
        $this->assertEquals( false, isset( $feed->unsupportedModule ) );
    }

    public function testParseAtom2()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}atom{$dot}data{$dot}atom_multiple_entries.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'atom', $feed->getFeedType() );
        $items = $feed->item;
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

        $modules = $feed->getModules();
        $this->assertEquals( true, isset( $modules['iTunes'] ) );
    }

    public function testParseRss2Podcast2()
    {
        $dot = DIRECTORY_SEPARATOR;
        $file = dirname( __FILE__ ) . "{$dot}rss2{$dot}data{$dot}woodsongs_old_time_radio_hour.xml";

        $feed = ezcFeed::parse( $file );

        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'The Woodsongs Old Time Radio Hour Podcast', $feed->title->__toString() );
    }

    public function testParseRss2Version091()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><rss version="0.91"><channel><title>RSS 0.91</title><item><title>Item 0.91</title></item></channel></rss>' );
        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'RSS 0.91', $feed->title->__toString() );
        $this->assertEquals( 'Item 0.91', $feed->item[0]->title->__toString() );
    }

    public function testParseRss2Version092()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><rss version="0.92"><channel><title>RSS 0.92</title><item><title>Item 0.92</title></item></channel></rss>' );
        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'RSS 0.92', $feed->title->__toString() );
        $this->assertEquals( 'Item 0.92', $feed->item[0]->title->__toString() );
    }

    public function testParseRss2Version093()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><rss version="0.93"><channel><title>RSS 0.93</title><item><title>Item 0.93</title></item></channel></rss>' );
        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'RSS 0.93', $feed->title->__toString() );
        $this->assertEquals( 'Item 0.93', $feed->item[0]->title->__toString() );
    }

    public function testParseRss2Version094()
    {
        $feed = ezcFeed::parseContent( '<?xml version="1.0" encoding="utf-8"?><rss version="0.94"><channel><title>RSS 0.94</title><item><title>Item 0.94</title></item></channel></rss>' );
        $this->assertEquals( 'rss2', $feed->getFeedType() );
        $this->assertEquals( 'RSS 0.94', $feed->title->__toString() );
        $this->assertEquals( 'Item 0.94', $feed->item[0]->title->__toString() );
    }

    public function testCreateModuleNotSupported()
    {
        try
        {
            $module = ezcFeedModule::create( 'unsupported_module' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedModuleException $e )
        {
            $this->assertEquals( "The module 'unsupported_module' is not supported.", $e->getMessage() );
        }
    }

    public function testAddElementNotSupported()
    {
        $feed = new ezcFeed( 'rss2' );
        $item = $feed->add( 'item' );
        try
        {
            $item->add( 'unsupported_element' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedElementException $e )
        {
            $this->assertEquals( "The feed element 'unsupported_element' is not supported.", $e->getMessage() );
        }
    }

    public function testAddElementNotSupportedInModule()
    {
        $feed = new ezcFeed( 'rss2' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'Content' );
        try
        {
            $module->add( 'unsupported_element' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedElementException $e )
        {
            $this->assertEquals( "The feed element 'unsupported_element' is not supported.", $e->getMessage() );
        }
    }

    public function testGetItemModules()
    {
        $feed = new ezcFeed( 'rss2' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'Content' );
        $modules = $item->getModules();
        $this->assertEquals( 'ezcFeedContentModule', get_class( $modules['Content'] ) );
    }

    public function testGetItemModuleNotDefinedYet()
    {
        $feed = new ezcFeed( 'rss2' );
        $item = $feed->add( 'item' );
        try
        {
            $module = $item->Content;
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUndefinedModuleException $e )
        {
            $this->assertEquals( "The module 'Content' is not defined yet.", $e->getMessage() );
        }
    }
}
?>

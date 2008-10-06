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
class ezcFeedExtendTest extends ezcFeedTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testGetSupportedTypes()
    {
        $types = ezcFeed::getSupportedTypes();
        $expected = array(
            'rss1' => 'ezcFeedRss1',
            'rss2' => 'ezcFeedRss2',
            'atom' => 'ezcFeedAtom'
            );
        $this->assertEquals( $expected, $types );
    }

    public function testGetSupportedModules()
    {
        $types = ezcFeed::getSupportedModules();
        $expected = array(
            'Content'         => 'ezcFeedContentModule',
            'CreativeCommons' => 'ezcFeedCreativeCommonsModule',
            'DublinCore'      => 'ezcFeedDublinCoreModule',
            'Geo'             => 'ezcFeedGeoModule',
            'iTunes'          => 'ezcFeedITunesModule'
            );
        $this->assertEquals( $expected, $types );
    }

    public function testGetSupportedModulesPrefixes()
    {
        $types = ezcFeed::getSupportedModulesPrefixes();
        $expected = array(
            'content'         => 'Content',
            'creativeCommons' => 'CreativeCommons',
            'dc'              => 'DublinCore',
            'geo'             => 'Geo',
            'itunes'          => 'iTunes'
            );
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

    public function testCreateFeedEmpty()
    {
        $feed = new ezcFeed();
        $this->assertEquals( 'ezcFeed', get_class( $feed ) );
        $this->assertEquals( null, $feed->getFeedType() );
        $this->assertEquals( null, $feed->getContentType() );
    }

    public function testGenerateRss2()
    {
        $feed = new ezcFeed();
        $feed->title = 'xxx';
        $feed->link = 'xxx';
        $feed->description = 'xxx';
        $expected = <<<EOL
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>xxx</title>
    <link>xxx</link>
    <description>xxx</description>
    <pubDate>XXX</pubDate>
    <generator>XXX</generator>
    <docs>http://www.rssboard.org/rss-specification</docs>
  </channel>
</rss>
EOL;
        $generated = $feed->generate( 'rss2' );
        $generated = preg_replace( '@<pubDate>.*?</pubDate>@', '<pubDate>XXX</pubDate>', $generated );
        $generated = preg_replace( '@<lastBuildDate>.*?</lastBuildDate>@', '<lastBuildDate>XXX</lastBuildDate>', $generated );
        $generated = preg_replace( '@<generator.*?>.*?</generator>@', '<generator>XXX</generator>', $generated );
        $generated = str_replace( "\n", PHP_EOL, $generated );
        $this->assertEquals( trim( $expected ), trim( $generated ) );
    }

    public function testCreateModuleContent()
    {
        $feed = new ezcFeed( 'atom' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'Content' );
        $this->assertEquals( 'Content', $module->getModuleName() );
        $this->assertEquals( 'http://purl.org/rss/1.0/modules/content/', $module->getNamespace() );
        $this->assertEquals( 'content', $module->getNamespacePrefix() );
    }

    public function testCreateModuleCreativeCommons()
    {
        $feed = new ezcFeed( 'atom' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'CreativeCommons' );
        $this->assertEquals( 'CreativeCommons', $module->getModuleName() );
        $this->assertEquals( 'http://backend.userland.com/creativeCommonsRssModule', $module->getNamespace() );
        $this->assertEquals( 'creativeCommons', $module->getNamespacePrefix() );
    }

    public function testCreateModuleDublinCore()
    {
        $feed = new ezcFeed( 'atom' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'DublinCore' );
        $this->assertEquals( 'DublinCore', $module->getModuleName() );
        $this->assertEquals( 'http://purl.org/dc/elements/1.1/', $module->getNamespace() );
        $this->assertEquals( 'dc', $module->getNamespacePrefix() );
    }

    public function testCreateModuleGeo()
    {
        $feed = new ezcFeed( 'atom' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'Geo' );
        $this->assertEquals( 'Geo', $module->getModuleName() );
        $this->assertEquals( 'http://www.w3.org/2003/01/geo/wgs84_pos#', $module->getNamespace() );
        $this->assertEquals( 'geo', $module->getNamespacePrefix() );
    }

    public function testCreateModuleITunes()
    {
        $feed = new ezcFeed( 'atom' );
        $item = $feed->add( 'item' );
        $module = $item->addModule( 'iTunes' );
        $this->assertEquals( 'iTunes', $module->getModuleName() );
        $this->assertEquals( 'http://www.itunes.com/dtds/podcast-1.0.dtd', $module->getNamespace() );
        $this->assertEquals( 'itunes', $module->getNamespacePrefix() );
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

    public function testRegisterNewFeedType()
    {
        ezcFeed::registerFeed( 'opml', 'myOpmlHandler' );
        $types = ezcFeed::getSupportedTypes();
        $expected = array(
            'rss1' => 'ezcFeedRss1',
            'rss2' => 'ezcFeedRss2',
            'atom' => 'ezcFeedAtom',
            'opml' => 'myOpmlHandler'
            );
        $this->assertEquals( $expected, $types );
        ezcFeed::unregisterFeed( 'opml' );
    }

    public function testRegisterNewModuleType()
    {
        ezcFeed::registerModule( 'Slash', 'mySlashHandler', 'slash' );

        $types = ezcFeed::getSupportedModules();
        $expected = array(
            'Content'         => 'ezcFeedContentModule',
            'CreativeCommons' => 'ezcFeedCreativeCommonsModule',
            'DublinCore'      => 'ezcFeedDublinCoreModule',
            'Geo'             => 'ezcFeedGeoModule',
            'iTunes'          => 'ezcFeedITunesModule',
            'Slash'           => 'mySlashHandler'
            );
        $this->assertEquals( $expected, $types );

        $types = ezcFeed::getSupportedModulesPrefixes();
        $expected = array(
            'content'         => 'Content',
            'creativeCommons' => 'CreativeCommons',
            'dc'              => 'DublinCore',
            'geo'             => 'Geo',
            'itunes'          => 'iTunes',
            'slash'           => 'Slash'
            );
        $this->assertEquals( $expected, $types );
        ezcFeed::unregisterModule( 'Slash' );
    }
}
?>

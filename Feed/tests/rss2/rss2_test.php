<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedRss2Test extends ezcTestCase
{
    protected function setup()
    {
        date_default_timezone_set( 'Europe/Oslo' );
    }

    public function testSimpleEmpty1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-01.xml" );
        self::assertEquals( $expected, preg_replace( '@<pubDate>.*?</pubDate>@', '<pubDate>XXXX</pubDate>', $feed->generate() ) );
    }

    public function testSimpleEmpty2()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->published = "1148633131"; // strtotime( "Fri May 26, 10:45:31 2006" );
        $feed->updated = "Fri May 26, 10:45:31 2006";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-03.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testSimpleEmptyWithError1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";

        try
        {
            $feed->generate();
            self::assertEquals( 'Expected exception not thrown' );
        }
        catch ( ezcFeedRequiredMetaDataMissingException $e )
        {
            self::assertEquals( "There was no data submitted for required channel attribute 'description'.", $e->getMessage() );
        }
    }

    public function testSimpleEmptyWithError2()
    {
        $feed = new ezcFeed( 'rss2' );

        try
        {
            $feed->generate();
            self::assertEquals( 'Expected exception not thrown' );
        }
        catch ( ezcFeedRequiredMetaDataMissingException $e )
        {
            self::assertEquals( "There was no data submitted for required channel attribute 'title'.", $e->getMessage() );
        }
    }

    public function testSimpleWithItems1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 10:46:31 2006 PDT";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->link = "http://components.ez.no/1";
        $item->description = "This is the first item";

        $item = $feed->newItem();
        $item->title = "Second Item";
        $item->link = "http://components.ez.no/2";
        $item->description = "This is the second item";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-02.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testSimpleWithItems2()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->webMaster = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 08:46:31 2006 UTC";
        $feed->category = "eZ Components";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->link = "http://components.ez.no/1";
        $item->description = "This is the first item";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-04.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testSimpleWithItems3NoLink()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 10:46:31 2006 PDT";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->description = "This is the first item";

        $item = $feed->newItem();
        $item->title = "Second Item";
        $item->description = "This is the second item";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-02_no_link.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testSimpleWithItemsWithError1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->webMaster = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 08:46:31 2006 UTC";
        $feed->category = "eZ Components";

        $item = $feed->newItem();

        try
        {
            $feed->generate();
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedAtLeastOneItemDataRequiredException $e )
        {
            self::assertEquals( "At least one of these attributes is required: title, description.", $e->getMessage() );
        }
    }

    public function testComplex1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->webMaster = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 08:46:31 2006 UTC";
        $feed->category = "test";
        $feed->category = "eZ Components";
        $feed->language = "nl";
        $feed->copyright = "eZ systems";
        $feed->generator = "eZ Components TEST";
        $feed->ttl = 86400;

        $image = $feed->newImage();
        $image->url = "http://ez.no/var/ezno/storage/images/download/other_downloads/powered_by_ez_components_logos/108x31/472645-3-eng-GB/108x31.png";
        $image->title = "Downloads";
        $image->link = "http://ez.no/download";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->link = "http://components.ez.no/1";
        $item->description = "This is the first item";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-05.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testComplex1WithOptional()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->webMaster = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 08:46:31 2006 UTC";
        $feed->category = "test";
        $feed->category = "eZ Components";
        $feed->language = "nl";
        $feed->copyright = "eZ systems";
        $feed->generator = "eZ Components TEST";
        $feed->ttl = 86400;

        $image = $feed->newImage();
        $image->url = "http://ez.no/var/ezno/storage/images/download/other_downloads/powered_by_ez_components_logos/108x31/472645-3-eng-GB/108x31.png";
        $image->title = "Downloads";
        $image->link = "http://ez.no/download";
        $image->description = "Newest versions are available for download.";
        $image->width = "176";
        $image->height = "62";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->link = "http://components.ez.no/1";
        $item->description = "This is the first item";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-05_optional.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testComplex1MissingRequired()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->webMaster = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 08:46:31 2006 UTC";
        $feed->category = "test";
        $feed->category = "eZ Components";
        $feed->language = "nl";
        $feed->copyright = "eZ systems";
        $feed->generator = "eZ Components TEST";
        $feed->ttl = 86400;

        $image = $feed->newImage();
        $image->url = "http://ez.no/var/ezno/storage/images/download/other_downloads/powered_by_ez_components_logos/108x31/472645-3-eng-GB/108x31.png";

        try
        {
            $feed->generate();
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcFeedRequiredItemDataMissingException $e )
        {
            self::assertEquals( "There was no data submitted for required attribute 'title'.", $e->getMessage() );
        }
    }

    public function testComplex2()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 10:46:31 2006 CEST";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->link = "http://components.ez.no/1";
        $item->description = "This is the first item";
        $item->author = 'xx1@ez.no (Derick)';
        $item->category = 'Tests';
        $item->category = 'eZ Components';
        $item->comments = 'http://components.ez.no/1/comments';
        $item->guid = "http://components.ez.no/1";
        $item->published = "Fri May 26, 10:46:31 2006 CEST";

        $item = $feed->newItem();
        $item->title = "Second Item";
        $item->link = "http://components.ez.no/2";
        $item->description = "This is the second item";
        $item->guid = "components.ez.no/2";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-06.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testIterator1()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-07.xml" );
        $returned = array();
        foreach ( $feed as $item )
        {
            $returned[] = array( $item->title, $item->link, $item->description );
            $keys[] = $feed->key();
        }
        $expected = array (
  0 =>
  array (
    0 => 'eZ Components 1.1rc1',
    1 => 'http://ez.no/community/news/ez_components_1_1rc1',
    2 => '
<p>
We just released the first release for eZ Components 1.1. In this release you will find updated packages for many of the packages. The main changes are they way how options are handled for components. The Mail and Template package are the ones with the other major changes.
</p>
',
  ),
  1 =>
  array (
    0 => 'Community newsletter 26/05/2006',
    1 => 'http://ez.no/community/news/community_newsletter_26_05_2006',
    2 => '
<p>
The big news this week is the release of the eZ publish 3.9 feature request list. Also, read about eZ publish 4.0 development progress, an interview with eZ crew member Tobias Schlitt and an update on the specification for a new Project section on ez.no. The newsletter also includes an update on the current bug status.
</p>
',
  ),
  2 =>
  array (
    0 => 'Feature request list for eZ publish 3.9',
    1 => 'http://ez.no/community/news/feature_request_list_for_ez_publish_3_9',
    2 => '
<p>
We have posted a <a href="/community/developer/specs/feature_request_list_for_ez_publish_3_9" target="_self">feature request list for eZ publish 3.9</a> in the <br /><a href="/community/developer/specs" target="_self">specification section</a>.<br />
</p>
',
  ),
  3 =>
  array (
    0 => 'Community newsletter 19/05/2006',
    1 => 'http://ez.no/community/news/community_newsletter_19_05_2006',
    2 => '
<p>
This week we bring you an update on the eZ publish 4.0 development process, news about the new article &quot;Building a custom template for a news portal&quot; and an update on the current bug status.
</p>
',
  ),
  4 =>
  array (
    0 => 'Community newsletter 12/05/2006',
    1 => 'http://ez.no/community/news/community_newsletter_12_05_2006',
    2 => '
<p>
In this week\'s newsletter, we bring you news about the beta 2 version of eZ Components and an update on eZ publish 4.0 development. We also have news about eZ publish sub-releases and an announcement of the first release candidate of the Online Editor version 4.1. The newsletter also includes an update on the current bug status.
</p>
',
  ),
);
        self::assertEquals( $expected, $returned );
        self::assertEquals( array_keys( $expected ), $keys );
    }

    public function testWithModule1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->addModule( 'DublinCore' );

        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->updated = "Fri May 26, 10:46:31 2006 CEST";
        $feed->DublinCore->date = "Fri May 26, 10:46:31 2006 CEST";
        $feed->DublinCore->description = "<p>This is a richer <i>description</i> supported by dublin code.</p>";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-08.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testComplexWithModule1()
    {
        $feed = new ezcFeed( 'rss2' );
        $feed->addModule( 'DublinCore' );

        $feed->title = "eZ Components test";
        $feed->link = "http://components.ez.no";
        $feed->description = "This is a test for the eZ Components Feed Generator";
        $feed->author = "xx@ez.no (Derick Rethans)";
        $feed->published = 1148633191;
        $feed->DublinCore->description = "<p>This is a richer <i>description</i> supported by dublin code.</p>";

        $item = $feed->newItem();
        $item->title = "First Item";
        $item->link = "http://components.ez.no/1";
        $item->description = "This is the first item";
        $item->guid = "http://components.ez.no/1";
        $item->published = "Fri May 26, 10:46:31 2006 CEST";
        $item->DublinCore->date = "Sat May 27, 10:46:42 2006 CEST";
        $item->DublinCore->rights = "CreativeCommons";

        $item = $feed->newItem();
        $item->title = "Second Item";
        $item->link = "http://components.ez.no/2";
        $item->description = "This is the second item";
        $item->guid = "http://components.ez.no/2";
        $item->published = "Fri May 26, 10:46:31 2006 CEST";
        $item->DublinCore->rights = "Copyright only.";

        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-09.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testParseImage1()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-05.xml" );
        self::assertEquals( "http://ez.no/var/ezno/storage/images/download/other_downloads/powered_by_ez_components_logos/108x31/472645-3-eng-GB/108x31.png", $feed->image->url );
        self::assertEquals( "Downloads", $feed->image->title );
        self::assertEquals( "http://ez.no/download", $feed->image->link );
    }

    public function testParseImage1OptionalAttributes()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-05_optional.xml" );
        self::assertEquals( "http://ez.no/var/ezno/storage/images/download/other_downloads/powered_by_ez_components_logos/108x31/472645-3-eng-GB/108x31.png", $feed->image->url );
        self::assertEquals( "Downloads", $feed->image->title );
        self::assertEquals( "http://ez.no/download", $feed->image->link );
        self::assertEquals( "Newest versions are available for download.", $feed->image->description );
        self::assertEquals( "176", $feed->image->width );
        self::assertEquals( "62", $feed->image->height );
    }

    public function testParseComplexWithModule1()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-09.xml" );
        self::assertEquals( "<p>This is a richer <i>description</i> supported by dublin code.</p>", $feed->DublinCore->description );
        self::assertEquals( "CreativeCommons", $feed->items[0]->DublinCore->rights );
        self::assertEquals( "This is the second item", $feed->items[1]->description );
        self::assertEquals( "Copyright only.", $feed->items[1]->DublinCore->rights );
    }

    public function testParseComplexWithModuleFromVariable()
    {
        $feed = ezcFeed::parseContent( file_get_contents( dirname( __FILE__ ) . "/data/rss2-09.xml" ) );
        self::assertEquals( "<p>This is a richer <i>description</i> supported by dublin code.</p>", $feed->DublinCore->description );
        self::assertEquals( "CreativeCommons", $feed->items[0]->DublinCore->rights );
        self::assertEquals( "This is the second item", $feed->items[1]->description );
        self::assertEquals( "Copyright only.", $feed->items[1]->DublinCore->rights );
    }

    public function testParseAll()
    {
        $basePath = dirname( __FILE__ ) . "/data";
        $files = scandir( $basePath );
        foreach ( $files as $file )
        {
            if ( substr( $file, 0, 1 ) !== '.' && is_file( "{$basePath}/{$file}" ) )
            {
                try
                {
                    $feed = ezcFeed::parse( "{$basePath}/{$file}" );
                }
                catch ( ezcFeedUnsupportedModuleElementException $e )
                {
                    $this->assertEquals( "The element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
                }
                catch ( ezcFeedUnsupportedModuleItemElementException $e )
                {
                    $this->assertEquals( "The feed item element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
                }
            }
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcFeedRss2Test" );
    }
}
?>

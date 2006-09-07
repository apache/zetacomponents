<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 * @subpackage Tests
 */

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedRss2ContentTest extends ezcTestCase
{
    public function setup()
    {
        date_default_timezone_set( 'Europe/Oslo' );
    }

    static private function normalizeString( $str )
    {
        return trim( preg_replace( '@\s+@', ' ', $str ) );
    }

    public function testParseWithFullContent()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-content-01.xml" );
        self::assertEquals( array( 'php', 'work' ), $feed->category );
        self::assertEquals( self::normalizeString( '<p>
While checking whether the <a href="http://components.ez.no">eZ
components</a> would run with the latest PHP 5.2 release candidate we
noticed that there are some things that are not backwards compatible
with PHP 5.1.
</p>' ), self::normalizeString( $feed->items[0]->Content->encoded ) );
    }

    public function testParseWithFullContentGenerate()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-content-01.xml" );
        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-content-02.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testParseWithUnknownContentModuleElement()
    {
        try
        {
            $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-02.xml" );
            self::fail( 'The expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleElementException $e )
        {
            self::assertEquals( 'The element <bullshit> does not exist for the module <DublinCore>.', $e->getMessage() );
        }
    }

    public function testParseWithUnknownContentItemElement()
    {
        try
        {
            $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-03.xml" );
            self::fail( 'The expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleItemElementException $e )
        {
            self::assertEquals( 'The feed item element <bullshit> does not exist for the module <DublinCore>.', $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcFeedRss2ContentTest" );
    }
}

?>

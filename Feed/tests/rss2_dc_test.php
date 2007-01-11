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
class ezcFeedRss2DCTest extends ezcTestCase
{
    protected function setup()
    {
        date_default_timezone_set( 'Europe/Oslo' );
    }

    public function testParseWithFullDC()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-01.xml" );
        self::assertEquals( "<p>This is a richer <i>description</i> supported by dublin code.</p>", $feed->DublinCore->description );
        self::assertEquals( "CreativeCommons", $feed->items[0]->DublinCore->rights );
        self::assertEquals( "This is the first item", $feed->items[0]->description );
    }

    public function testParseWithFullDCGenerate()
    {
        $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-01.xml" );
        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-dc-04.xml" );
        self::assertEquals( $expected, $feed->generate() );
    }

    public function testParseWithUnknownDCModuleElement()
    {
        try
        {
            $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-02.xml" );
            self::fail( 'The expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleElementException $e )
        {
            self::assertEquals( "The element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
        }
    }

    public function testParseWithUnknownDCItemElement()
    {
        try
        {
            $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-03.xml" );
            self::fail( 'The expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleItemElementException $e )
        {
            self::assertEquals( "The feed item element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcFeedRss2DCTest" );
    }
}

?>

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
    protected static $dataDir;

    public static function suite()
    {
        date_default_timezone_set( 'Europe/Oslo' );
        self::$dataDir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;

        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testParseWithFullDC()
    {
        $feed = ezcFeed::parse( self::$dataDir . "rss2-dc-01.xml" );
        $this->assertEquals( "<p>This is a richer <i>description</i> supported by dublin code.</p>", $feed->DublinCore->description );
        $this->assertEquals( "CreativeCommons", $feed->items[0]->DublinCore->rights );
        $this->assertEquals( "This is the first item", $feed->items[0]->description );
    }

    public function testParseWithFullDCGenerate()
    {
        $feed = ezcFeed::parse( self::$dataDir . "rss2-dc-01.xml" );
        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-dc-04.xml" );
        $this->assertEquals( $expected, $feed->generate() );
    }

    public function testParseWithUnknownDCModuleElement()
    {
        try
        {
            $feed = ezcFeed::parse( self::$dataDir . "rss2-dc-02.xml" );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleElementException $e )
        {
            $this->assertEquals( "The element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
        }
    }

    public function testParseWithUnknownDCItemElement()
    {
        try
        {
            $feed = ezcFeed::parse( self::$dataDir . "rss2-dc-03.xml" );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleItemElementException $e )
        {
            $this->assertEquals( "The feed item element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
        }
    }
}
?>

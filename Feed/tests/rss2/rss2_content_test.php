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
class ezcFeedRss2ContentTest extends ezcTestCase
{
    protected static $dataDir;

    public static function suite()
    {
        date_default_timezone_set( 'Europe/Oslo' );
        self::$dataDir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;

        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected static function normalizeString( $str )
    {
        return trim( preg_replace( '@\s+@', ' ', $str ) );
    }

    public function testParseWithFullContent()
    {
        $feed = ezcFeed::parse( self::$dataDir . "rss2-content-01.xml" );
        self::assertEquals( array( 'php', 'work' ), $feed->category );
        $this->assertEquals( self::normalizeString( '<p>
While checking whether the <a href="http://components.ez.no">eZ
components</a> would run with the latest PHP 5.2 release candidate we
noticed that there are some things that are not backwards compatible
with PHP 5.1.
</p>' ), self::normalizeString( $feed->items[0]->Content->encoded ) );
    }

    public function testParseWithFullContentGenerate()
    {
        $feed = ezcFeed::parse( self::$dataDir . "rss2-content-01.xml" );
        $expected = file_get_contents( dirname( __FILE__ ) . "/data/rss2-content-02.xml" );
        $this->assertEquals( $expected, $feed->generate() );
    }

    public function testParseWithUnknownContentModuleElement()
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

    public function testParseWithUnknownContentItemElement()
    {
        try
        {
            $feed = ezcFeed::parse( dirname( __FILE__ ) . "/data/rss2-dc-03.xml" );
            $this->fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcFeedUnsupportedModuleItemElementException $e )
        {
            $this->assertEquals( "The feed item element 'bullshit' does not exist for the module 'DublinCore'.", $e->getMessage() );
        }
    }
}
?>

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
class ezcFeedTest extends ezcTestCase
{
    public function testGetSupportedTypes()
    {
        $types = ezcFeed::getSupportedTypes();
        $expected = array( 'rss1', 'rss2', 'atom' );
        self::assertEquals( $expected, $types );
    }

    public function testCreateFeedSupported()
    {
        $feed = ezcFeed::create( 'rss1' );
        self::assertEquals( 'ezcFeed', get_class( $feed ) );
    }

    public function testCreateFeedNotSupported()
    {
        try
        {
            $feed = ezcFeed::create( 'molecule' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedTypeException $e )
        {
            self::assertEquals( "The feed type <molecule> is not supported.", $e->getMessage() );
        }
    }

    public function testAddModuleSupported()
    {
        $feed = ezcFeed::create( 'rss2' );
        $feed->addModule( 'DublinCore' );
    }

    public function testAddModuleNotSupported()
    {
        $feed = ezcFeed::create( 'rss2' );
        try
        {
            $feed->addModule( 'DublinBase' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcFeedUnsupportedModuleException $e )
        {
            self::assertEquals( "The module <DublinBase> is not supported.", $e->getMessage() );
        }
    }

    public function testFeedNonExistentLocal()
    {
        try
        {
            $feed = ezcFeed::parse( 'not-here.xml' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            self::assertEquals( "The file <not-here.xml> could not be found.", $e->getMessage() );
        }
    }

    public function testFeedNonExistentRemote()
    {
        try
        {
            $feed = ezcFeed::parse( 'http://ez.no/not-here.xml' );
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            self::assertEquals( "The file <http://ez.no/not-here.xml> could not be found.", $e->getMessage() );
        }
    }

    public function testFeedExistsRemote()
    {
        $feed = ezcFeed::parse( 'http://ez.no/rss/feed/communitynews' );
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcFeedTest" );
    }
}

?>

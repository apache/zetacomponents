<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'feed_test.php';
require_once 'rss2_test.php';
require_once 'rss2_content_test.php';
require_once 'rss2_dc_test.php';

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Feed' );

        $this->addTest( ezcFeedTest::suite() );
        $this->addTest( ezcFeedRss2Test::suite() );
        $this->addTest( ezcFeedRss2ContentTest::suite() );
        $this->addTest( ezcFeedRss2DCTest::suite() );
    }

    public static function suite()
    {
        return new ezcFeedSuite();
    }
}

?>

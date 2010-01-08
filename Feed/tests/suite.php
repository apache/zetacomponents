<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
require_once 'extend_test.php';

require_once 'atom/atom_regression_generate_test.php';
require_once 'atom/atom_regression_parse_test.php';

require_once 'rss1/rss1_regression_generate_test.php';
require_once 'rss1/rss1_regression_parse_test.php';

require_once 'rss2/rss2_regression_generate_test.php';
require_once 'rss2/rss2_regression_parse_test.php';

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Feed' );

        $this->addTest( ezcFeedTest::suite() );
        $this->addTest( ezcFeedExtendTest::suite() );

        $this->addTest( ezcFeedAtomRegressionGenerateTest::suite() );
        $this->addTest( ezcFeedAtomRegressionParseTest::suite() );

        $this->addTest( ezcFeedRss1RegressionGenerateTest::suite() );
        $this->addTest( ezcFeedRss1RegressionParseTest::suite() );

        $this->addTest( ezcFeedRss2RegressionGenerateTest::suite() );
        $this->addTest( ezcFeedRss2RegressionParseTest::suite() );
    }

    public static function suite()
    {
        return new ezcFeedSuite();
    }
}

?>

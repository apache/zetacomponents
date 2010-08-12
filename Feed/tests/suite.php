<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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

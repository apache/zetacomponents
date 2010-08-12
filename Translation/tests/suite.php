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
 * @package Translation
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'translation_test.php';
require_once 'translation_backend_ts_test.php';
require_once 'translation_filter_borkify_test.php';
require_once 'translation_filter_leetify_test.php';
require_once 'translation_manager_test.php';

/**
 * @package Translation
 * @subpackage Tests
 */
class ezcTranslationSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Translation");

        $this->addTest( ezcTranslationTest::suite() );
        $this->addTest( ezcTranslationTsBackendTest::suite() );
        $this->addTest( ezcTranslationManagerTest::suite() );
        $this->addTest( ezcTranslationFilterBorkifyTest::suite() );
        $this->addTest( ezcTranslationFilterLeetifyTest::suite() );
    }

    public static function suite()
    {
        return new ezcTranslationSuite();
    }
}

?>

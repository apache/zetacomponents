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
 * @package Search
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require 'managers/embedded_test.php';
require 'managers/xml_test.php';
require 'handlers/solr_test.php';
require 'handlers/zend_lucene_test.php';
require 'build_query_test.php';
require 'zend_lucene_test.php';
require 'session_test.php';

/**
 * @package Search
 * @subpackage Tests
 */
class ezcSearchSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'Search' );

        $this->addTest( ezcSearchEmbeddedDefinitionManager::suite() );
        $this->addTest( ezcSearchXmlDefinitionManager::suite() );
        $this->addTest( ezcSearchBuildSearchQueryTest::suite() );
        $this->addTest( ezcSearchHandlerSolrTest::suite() );
        $this->addTest( ezcSearchHandlerZendLuceneTest::suite() );
        $this->addTest( ezcSearchSessionZendLuceneTest::suite() );
        $this->addTest( ezcSearchSessionTest::suite() );
    }

    public static function suite()
    {
        return new ezcSearchSuite();
    }
}

?>

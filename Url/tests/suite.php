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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "url_test.php" );
require_once( "url_configuration_test.php" );
require_once( "url_creator_test.php" );
require_once( "url_tools_test.php" );

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Url" );

        $this->addTest( ezcUrlTest::suite() );
        $this->addTest( ezcUrlConfigurationTest::suite() );
        $this->addTest( ezcUrlCreatorTest::suite() );
        $this->addTest( ezcUrlToolsTest::suite() );
    }

    public static function suite()
    {
        return new ezcUrlSuite();
    }
}
?>

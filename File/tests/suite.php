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
 * @package File
 * @subpackage Tests
 */

/**
 * Require the test cases
 */
require_once 'file_find_recursive_test.php';
require_once 'file_remove_recursive_test.php';
require_once 'file_calculate_relative_path_test.php';

/**
 * @package File
 * @subpackage Tests
 */
class ezcFileSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("File");

        $this->addTest( ezcFileFindRecursiveTest::suite() );
        $this->addTest( ezcFileRemoveRecursiveTest::suite() );
        $this->addTest( ezcFileCalculateRelativePathTest::suite() );
    }

    public static function suite()
    {
        return new ezcFileSuite();
    }
}
?>

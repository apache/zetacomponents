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
 * @package Base
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once( "base_test.php");
require_once( "base_init_test.php");
require_once( "features_unix_test.php");
require_once( "features_windows_test.php");
require_once( "base_options_test.php");
require_once( "struct_test.php");
require_once 'metadata_pear_test.php';
require_once 'file_find_recursive_test.php';
require_once 'file_is_absolute_path.php';
require_once 'file_copy_recursive_test.php';
require_once 'file_remove_recursive_test.php';
require_once 'file_calculate_relative_path_test.php';

/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseSuite extends PHPUnit_Framework_TestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName("Base");

        $this->addTest( ezcBaseTest::suite() );
        $this->addTest( ezcBaseInitTest::suite() );
        $this->addTest( ezcBaseFeaturesUnixTest::suite() );
        $this->addTest( ezcBaseFeaturesWindowsTest::suite() );
        $this->addTest( ezcBaseOptionsTest::suite() );
        $this->addTest( ezcBaseStructTest::suite() );
        $this->addTest( ezcBaseMetaDataPearTest::suite() );
        $this->addTest( ezcBaseFileCalculateRelativePathTest::suite() );
        $this->addTest( ezcBaseFileFindRecursiveTest::suite() );
        $this->addTest( ezcBaseFileIsAbsoluteTest::suite() );
        $this->addTest( ezcBaseFileCopyRecursiveTest::suite() );
        $this->addTest( ezcBaseFileRemoveRecursiveTest::suite() );
    }

    public static function suite()
    {
        return new ezcBaseSuite();
    }
}
?>

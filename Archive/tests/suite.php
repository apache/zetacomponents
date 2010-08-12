<?php
/**
 * File containing the ezcArchiveSuite class.
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
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "file/block_file_test.php");
require_once( "file/character_file_test.php");
require_once( "tar/v7_tar_test.php");
require_once( "tar/ustar_tar_test.php");
require_once( "tar/pax_tar_test.php");
require_once( "tar/gnu_tar_test.php");
require_once( "compressed_archives/zlib_test.php");
require_once( "compressed_archives/bzip2_test.php");

require_once( "zip/zip_test.php");

require_once( "archive_test.php");
require_once( "file_type.php");
require 'archive_options_test.php';

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveSuite extends PHPUnit_Framework_TestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName( "Archive" );

		$this->addTest( ezcArchiveOptionsTest::suite() );
		$this->addTest( ezcArchiveTest::suite() );
		$this->addTest( ezcArchiveFileTypeTest::suite() );
		$this->addTest( ezcArchiveBlockFileTest::suite() );
		$this->addTest( ezcArchiveCharacterFileTest::suite() );
		$this->addTest( ezcArchiveV7TarTest::suite() );
		$this->addTest( ezcArchiveUstarTarTest::suite() );
		$this->addTest( ezcArchivePaxTarTest::suite() );
		$this->addTest( ezcArchiveGnuTarTest::suite() );
		$this->addTest( ezcArchiveZipTest::suite() );
		$this->addTest( ezcArchiveZlibTest::suite() );
		$this->addTest( ezcArchiveBZip2Test::suite() );
	}

    public static function suite()
    {
        return new ezcArchiveSuite();
    }
}
?>

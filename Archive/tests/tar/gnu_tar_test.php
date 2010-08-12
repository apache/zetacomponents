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
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once( "pax_tar_test.php" );

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveGnuTarTest extends ezcArchivePaxTarTest // use the Pax tests
{
    protected function setUp()
    {
        date_default_timezone_set( "UTC" );
        $this->tarFormat = "gnu";
        $this->tarMimeFormat = ezcArchive::TAR_GNU;
        $this->canWrite = false;

        $this->createTempDir( "ezcArchive_" );

        $this->file = $this->createTempFile( "tar_gnu_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $this->archive = new ezcArchiveGnuTar( $blockFile );

        $this->complexFile = $this->createTempFile( "tar_gnu_file_dir_symlink_link.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->complexFile );
        $this->complexArchive = new ezcArchiveGnuTar( $blockFile );

        $this->setUsersGid();
    }

    protected function tearDown()
    {
        unset( $this->archive );
        unset( $this->file );
        unset( $this->complexArchive );
        unset( $this->complexFile );
        $this->removeTempDir();
    }

    // test for bug #13501
    public function testLongLinkAndFileName()
    {
        $dir = $this->getTempDir();

        $filename = $this->createTempFile( 'linktest.tar' );
        $archive = ezcArchive::open( $filename );
        foreach ( $archive as $entry )
        {
            $archive->extractCurrent( $dir );
        }
        self::assertEquals( true, file_exists( "{$dir}/var/ezwebin_site/storage/images/eu/biofoul/lobster-plant/galleri-3-bilder/photo-1/1225-1-eng-GB/Photo-1_sidebar_large.jpg" ) );
        self::assertEquals( true, file_exists( "{$dir}/var/ezwebin_site/storage/images/eu/lobster-plant/galleri-3-bilder/photo-1/1225-1-eng-GB/Photo-1_sidebar_large.jpg" ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

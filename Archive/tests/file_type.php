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

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveFileTypeTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->createTempDir( "ezcArchive_" );
        date_default_timezone_set("UTC"); 
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testRecognizeGzip()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/tar_gnu_2_textfiles.tar", "$dir/my.tar" );
        exec( "gzip $dir/my.tar" );

        $this->assertEquals( ezcArchive::GZIP, ezcArchiveFileType::detect( "$dir/my.tar.gz" ) );
    }

    public function testRecognizeBzip2()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/tar_gnu_2_textfiles.tar", "$dir/my.tar" );
        exec( "bzip2 $dir/my.tar" );

        $this->assertEquals( ezcArchive::BZIP2, ezcArchiveFileType::detect( "$dir/my.tar.bz2" ) );
    }

    public function testRecognizeZip()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/infozip_2_textfiles.zip", "$dir/my.zip" );

        $this->assertEquals( ezcArchive::ZIP, ezcArchiveFileType::detect( "$dir/my.zip" ) );
    }

    public function testRecognizeTarUstar()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/my.tar" );

        $this->assertEquals( ezcArchive::TAR_USTAR, ezcArchiveFileType::detect( "$dir/my.tar" ) );
    }

    public function testRecognizeTarV7()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/tar_v7_2_textfiles.tar", "$dir/my.tar" );

        $this->assertEquals( ezcArchive::TAR_V7, ezcArchiveFileType::detect( "$dir/my.tar" ) );
    }

    public function testRecognizeTarPax()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/tar_pax_2_textfiles.tar", "$dir/my.tar" );

        $this->assertEquals( ezcArchive::TAR_PAX, ezcArchiveFileType::detect( "$dir/my.tar" ) );
    }

    public function testRecognizeTarGnu()
    {
        $dir = $this->getTempDir();
        copy ( dirname( __FILE__ ) . "/data/tar_gnu_2_textfiles.tar", "$dir/my.tar" );

        $this->assertEquals( ezcArchive::TAR_GNU, ezcArchiveFileType::detect( "$dir/my.tar" ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

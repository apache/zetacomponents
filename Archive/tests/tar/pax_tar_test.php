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

require_once( "ustar_tar_test.php" );

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchivePaxTarTest extends ezcArchiveUstarTarTest // Extend the Ustar tests
{
    protected function setUp()
    {
        date_default_timezone_set( "UTC" );
        $this->tarFormat = "posix";
        $this->tarMimeFormat = ezcArchive::TAR_PAX;
        $this->canWrite = false;

        $this->createTempDir( "ezcArchive_" );

        $this->file = $this->createTempFile( "tar_pax_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $this->archive = new ezcArchivePaxTar( $blockFile );

        $this->complexFile = $this->createTempFile( "tar_pax_file_dir_symlink_link.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->complexFile );
        $this->complexArchive = new ezcArchivePaxTar( $blockFile );

        $this->setUsersGid();
    }

    protected function tearDown()
    {
        unset( $this->archive );
        unset( $this->file );
        unset( $this->complexArchive ) ;
        unset( $this->complexFile );
        $this->removeTempDir();
    }

    // Skip character device. It is most probably the same as in Ustar.
    public function testExtractCharacterDevice() { }

    // Skip fifo. It is most probably the same as in Ustar.
    public function testExtractFifo() { }

    public function testReallyLongFileName ()
    {
        $dir = $this->getTempDir();

        if ( $this->isWindows() )
        {
            $dirname = "aaaaabbbbbaaaaabbbbbaaaaabbbbb"; // 30 char. max paths shorter in Windows
            $filename = "cccccdddddcccccdddddcccccddddd"; // 30 char. max paths shorter in Windows
            mkdir( "$dir\\$dirname\\$dirname\\$dirname", 0777, true );
            touch( "$dir\\$dirname\\$dirname\\$dirname\\$filename" );
        }
        else
        {
            $dirname = "aaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbb"; // 60 char.
            $filename = "ccccccccccddddddddddccccccccccddddddddddccccccccccdddddddddd"; // 60 char.
            mkdir( "$dir/$dirname/$dirname/$dirname", 0777, true );
            touch( "$dir/$dirname/$dirname/$dirname/$filename" );
        }

        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir $dirname" );

        unlink("$dir/$dirname/$dirname/$dirname/$filename" );
        rmdir( "$dir/$dirname/$dirname/$dirname" );
        rmdir( "$dir/$dirname/$dirname" );
        rmdir( "$dir/$dirname" );

        // Extract it:
        $bf = new ezcArchiveBlockFile( "$dir/gnutar.tar" );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        foreach ( $archive as $entry )
        {
            $archive->extractCurrent( $dir );
        }

        $this->assertTrue( file_exists( "$dir/$dirname/$dirname/$dirname/$filename" ) );

        unset( $bf );
    }

    public function testExtractLongLinkName()
    {
        $dir = $this->getTempDir();

        if ( $this->isWindows() )
        {
            $dirname = "aaaaabbbbbaaaaabbbbbaaaaabbbbb"; // 30 char. max paths shorter in Windows
            $filename = "cccccdddddcccccdddddcccccddddd"; // 30 char. max paths shorter in Windows
            mkdir( "$dir\\$dirname\\$dirname\\$dirname", 0777, true );
            touch( "$dir\\$dirname\\$dirname\\$dirname\\$filename" );

            copy( "$dir\\$dirname\\$dirname\\$dirname\\$filename", "$dir/mylink" );
        }
        else
        {
            $dirname = "aaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbb"; // 60 char.
            mkdir( "$dir/$dirname/$dirname/$dirname", 0777, true );

            $filename = "ccccccccccddddddddddccccccccccddddddddddccccccccccdddddddddd"; // 60 char.
            touch( "$dir/$dirname/$dirname/$dirname/$filename" );

            symlink( "$dirname/$dirname/$dirname/$filename", "$dir/mylink" );
        }

        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir mylink" );

        unlink( "$dir/$dirname/$dirname/$dirname/$filename" );
        rmdir( "$dir/$dirname/$dirname/$dirname" );
        rmdir( "$dir/$dirname/$dirname" );
        rmdir( "$dir/$dirname" );

        // Extract it:
        $bf = new ezcArchiveBlockFile( "$dir/gnutar.tar" );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        foreach ( $archive as $entry )
        {
            $archive->extractCurrent( $dir );
        }

        $this->assertTrue( is_link( "$dir/mylink" ) );
        $this->assertEquals( "$dirname/$dirname/$dirname/$filename", readlink( "$dir/mylink" ) );
        unset( $bf );
    }

    public function testExtractHugeFile()
    {
        // TODO.
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once( dirname( __FILE__ ) . "/../archive_test_case.php" );

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveV7TarTest extends ezcArchiveTestCase
{
    protected $canWrite = true;

    protected $archive;
    protected $complexArchive;

    protected $file;
    protected $complexFile;
    protected $tarFormat;
    protected $tarMimeFormat;
    protected $usersGid;

    public function createTempFile( $file )
    {
        $original = dirname(__FILE__) . "/../data/$file";

        $tmpFile = $this->getTempDir() . "/$file";
        copy( $original, $tmpFile );

        return $tmpFile;
    }

    protected function setUp()
    {
        date_default_timezone_set( "UTC" );
        $this->tarFormat = "v7";
        $this->tarMimeFormat = ezcArchive::TAR_V7;

        $this->createTempDir( "ezcArchive_" );

        $this->file = $this->createTempFile( "tar_v7_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $this->archive = new ezcArchiveV7Tar( $blockFile );
        unset( $blockFile );

        $this->complexFile = $this->createTempFile( "tar_v7_file_dir_symlink_link.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->complexFile );
        $this->complexArchive = new ezcArchiveV7Tar( $blockFile );
        unset( $blockFile );

        $this->setUsersGid();
    }

    protected function setUsersGid()
    {
        // figure out the GID for "users" for tests
        $this->usersGid = 1000; // default
        if ( posix_geteuid() === 0 && function_exists( 'posix_getgrnam' ) )
        {
            $info = posix_getgrnam( 'users' );
            $this->usersGid = $info['gid'];
        }
    }

    protected function tearDown()
    {
        unset( $this->archive );
        unset( $this->complexArchive );
        $this->removeTempDir();
    }

    protected function isWindows()
    {
        return ( substr( php_uname( 's' ), 0, 7 ) == 'Windows' ) ? true : false;
    }

    // FIXME
    // Move method to the archiveTest.
    /*
    public function testGetEntryFromFile()
    {
        $this->archive->extractCurrent( $this->getTempDir() );
        $entry = ezcArchive::getEntryFromFile( $this->getTempDir() . "/file1.txt" );

        $this->assertEquals( $this->getTempDir() . "/file1.txt", $entry->getPath() );
        $this->assertTrue( $entry->isFile() );
        $this->assertFalse( $entry->isDirectory() );
        // Probably okay.
    }

    // FIXME
    // Move method to the archiveTest.
    public function testGetEntryFromFilesWithHardlink()
    {
        $dir = $this->getTempDir();
        $this->complexArchive->seek( 4 ); // File.
        $this->complexArchive->extractCurrent( $dir );

        $this->complexArchive->seek(8); // Hardlink
        $this->complexArchive->extractCurrent( $dir );

        $entries = ezcArchive::getEntryFromFile( array( $dir . "/files/bla/file3.txt", $dir . "/files/file4.txt" ) );

        $this->assertEquals( 2, sizeof( $entries ), "Sizeof the entries array doesn't match." );
        $this->assertFalse( $entries[0]->isLink() );
        $this->assertTrue( $entries[1]->isLink() );

        $this->assertEquals( "$dir/files/bla/file3.txt", $entries[1]->getLink() );
    }
    */

    // FIXME
    // Move method to the archiveTest.
    /*
    public function testRemovePrefix()
    {
        $dir = $this->getTempDir();
        $total = $dir . "/lisa/ekdahl/";

        $without = ezcArchive::removePrefix( $total, $dir );
        $this->assertEquals( "lisa/ekdahl/", $without );
    }
    */

    public function testOpenArchive()
    {
        $entry = $this->archive->current();
        $this->assertEquals( "file1.txt", $entry->getPath() );
    }

    public function testEmptyArchive()
    {
        $file = $this->getTempDir() . "/file_does_not_exist.tar";
        $blockFile = new ezcArchiveBlockFile( $file, true );
        $archive = new ezcArchiveV7Tar( $blockFile );

        $this->assertFalse( $archive->current(), "Archive should be empty, so no file info available" );
        $this->assertFalse( $archive->valid(), "Archive should be empty, so no  file info available" );
        $this->assertFalse( $archive->next(), "Archive should be empty, so no file info available" );
        $this->assertFalse( $archive->next(), "Archive should be empty, so no file info available" );

        unset( $blockFile );
        unset( $archive );
    }

    public function testIteratorOperations()
    {
        $entry = $this->archive->current();
        $entry = $this->archive->current();
        $this->assertEquals( "file1.txt", $entry->getPath() );
        $this->assertTrue( $this->archive->valid(), "Expected a valid archive position." );

        $this->archive->rewind();
        $entry = $this->archive->current();
        $this->assertEquals( "file1.txt", $entry->getPath() );
        $this->assertEquals( 0, $this->archive->key() );
        $this->assertTrue( $this->archive->valid(), "Expected a valid archive position." );

        $this->assertTrue( $this->archive->next() !== false );
        $entry = $this->archive->current();
        $this->assertEquals( "file2.txt", $entry->getPath() );
        $this->assertEquals( 1, $this->archive->key() );
        $this->assertTrue( $this->archive->valid(), "Expected a valid archive position." );

        $this->assertFalse( $this->archive->next() );
        $this->assertFalse( $this->archive->current() );
        $this->assertFalse( $this->archive->valid() );
        $this->assertFalse( $this->archive->key() );

        $this->assertFalse( $this->archive->next() );
        $this->assertFalse( $this->archive->next() );
    }

    public function testForEaching()
    {
        for ( $i = 0; $i < 2; $i++ )
        {
            $loopNumber = 0;
            foreach ( $this->archive as $entryNumber => $entry )
            {
                if ( $loopNumber == 0 )
                {
                    $this->assertEquals( "file1.txt", $entry->getPath() );
                    $this->assertEquals( 0, $entryNumber );
                }
                else if ( $loopNumber == 1 )
                {
                    $this->assertEquals( "file2.txt", $entry->getPath() );
                    $this->assertEquals( 1, $entryNumber );
                }
                else
                {
                    $this->fail( "Didn't expect another entry in the archive" );
                }

                $loopNumber++;
            }
        }
    }

    public function testExtractCurrent()
    {
        $targetDir = $this->getTempDir() . "/";
        $this->archive->extractCurrent( $targetDir );

        $file1 = $this->getTempDir() . "/file1.txt";
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );

        // Remove the file, and extract again.
        unlink( $file1 );

        // Check whether the file is really removed (paranoia?).
        $fp = @fopen( $file1, "r" );
        if ( $fp )
        {
            $this->assertFail( "No noo nooo. The file shouldn't be here." );
        }

        $this->archive->extractCurrent( $targetDir );
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );

        // Move on.
        $entry = $this->archive->next();
        $this->assertTrue( $this->archive->valid(), "Second file is expected here." );

        $this->archive->extractCurrent( $targetDir );
        $file2 = $this->getTempDir() . "/file2.txt";
        $this->assertEquals( "Hello world.\nThe second file.\n", file_get_contents( $file2 ) );

        $this->assertFalse( $this->archive->next(), "No more files in the archive" );
    }

    public function testExtractCurrentOverwriteFile()
    {
        // Normally it will overwrite the file, if possible.
        $targetDir = $this->getTempDir() . "/";
        $this->archive->extractCurrent( $targetDir );

        $file1 = $this->getTempDir() . "/file1.txt";
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );

        $fp = @fopen( $file1, "w" );
        fwrite( $fp, "Garbage" );
        fclose( $fp );

        $this->assertEquals( "Garbage", file_get_contents( $file1 ) );

        $this->archive->extractCurrent( $targetDir );
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );
    }

    public function testExtractCurrentKeepExistingFile()
    {
        // Normally it will overwrite the file, if possible.
        $targetDir = $this->getTempDir() . "/";
        $this->archive->extractCurrent( $targetDir, true );

        $file1 = $this->getTempDir() . "/file1.txt";
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );

        $fp = @fopen( $file1, "w" );
        fwrite( $fp, "Garbage" );
        fclose( $fp );

        $this->assertEquals( "Garbage", file_get_contents( $file1 ) );

        $this->archive->extractCurrent( $targetDir, true );
        $this->assertEquals( "Garbage", file_get_contents( $file1 ) );
    }

    public function testExtractComplexArchive()
    {
        $dir =  $this->getTempDir();
        mkdir( $dir . "/php" );
        mkdir( $dir . "/gnu" );

        foreach ( $this->complexArchive as $entry )
        {
            $this->complexArchive->extractCurrent( $dir ."/php" );
        }

        exec( "tar -xf " . $this->complexFile . " -C $dir/gnu" );

        // make corrections that emulate symlink in Windows
        if ( $this->isWindows() )
        {
            exec( 'attrib -r ' . $dir . '\gnu\files\file3.txt.lnk' );
            exec( 'del "' . $dir . '\gnu\files\file3.txt.lnk"' );
            exec( 'copy "' . $dir . '\gnu\files\bla\file3.txt" "' . $dir . '\gnu\files\file3.txt"' );
        }
        $this->compareDirectories( "$dir/gnu", "$dir/php" );

        $stat = stat( "$dir/php/files/bla/file3.txt" );
        $this->assertEquals( 0644, $stat['mode'] & 07777 );
        $this->assertEquals( 1000, $stat['uid'] );
        $this->assertEquals( $this->usersGid, $stat['gid'] );
    }

    public function testExtractComplexArchiveModPerms()
    {
        $options = new ezcArchiveOptions;
        $options->extractCallback = new testExtractCallback;

        $this->complexArchive->setOptions( $options );
        $dir =  $this->getTempDir();
        mkdir( $dir . "/php" );
        mkdir( $dir . "/gnu" );

        foreach ( $this->complexArchive as $entry )
        {
            $this->complexArchive->extractCurrent( $dir ."/php" );
        }

        exec( "tar -xf " . $this->complexFile . " -C $dir/gnu" );

        // make corrections that emulate symlink in Windows
        if ( $this->isWindows() )
        {
            exec( 'attrib -r ' . $dir . '\gnu\files\file3.txt.lnk' );
            exec( 'del "' . $dir . '\gnu\files\file3.txt.lnk"' );
            exec( 'copy "' . $dir . '\gnu\files\bla\file3.txt" "' . $dir . '\gnu\files\file3.txt"' );
        }
        $this->compareDirectories( "$dir/gnu", "$dir/php" );
        $options->extractCallback = null;

        $stat = stat( "$dir/php/files/bla/file3.txt" );
        $this->assertEquals( 0600, $stat['mode'] & 07777 );
        $this->assertEquals( 1000, $stat['uid'] );
        $this->assertEquals( $this->usersGid, $stat['gid'] );

        $stat = stat( "$dir/php/files/bla" );
        $this->assertEquals( 0700, $stat['mode'] & 07777 );
        $this->assertEquals( 1000, $stat['uid'] );
        $this->assertEquals( $this->usersGid, $stat['gid'] );
    }

    public function testInvalidChecksum()
    {
        // Correct checksum.
        $ustarFile = new ezcArchiveBlockFile( dirname( __FILE__) . "/../data/tar_v7_2_textfiles.tar" );
        $tar = new ezcArchiveV7Tar( $ustarFile );

        // Incorrect checksum.
        try
        {
            $ustarFile = new ezcArchiveBlockFile( dirname( __FILE__) . "/../data/tar_v7_invalid_checksum.tar" );
            $tar = new ezcArchiveV7Tar( $ustarFile );
            $tar->current();

            $this->fail("Expected the checksum to fail.");
        }
        catch ( ezcArchiveChecksumException $e )
        {
        }

        unset( $tar );
        unset( $ustarFile );
    }

    public function testSeekPositions()
    {
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $this->complexArchive->seek( 2 ); // third file in archive.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $this->complexArchive->seek( 0 ); // first file in archive.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $this->complexArchive->seek( 6 );
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file2.txt", $entry->getPath() );

        $this->complexArchive->seek( 8 );
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $this->complexArchive->seek( 9 );
        $this->assertFalse( $this->complexArchive->current() );

        $this->complexArchive->seek( 0 );
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $this->complexArchive->seek( -1 );
        $this->assertFalse( $this->complexArchive->current() );
    }

    public function testSeekEndOfFile()
    {
        $this->complexArchive->seek( 0, SEEK_END ); // nineth and last file.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $this->complexArchive->seek( -2, SEEK_END ); // seventh file
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file2.txt", $entry->getPath() );

        $this->complexArchive->seek( -8, SEEK_END ); // first file
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $this->complexArchive->seek( 1, SEEK_END );  // invalid
        $this->assertFalse( $this->complexArchive->current() );

        $this->complexArchive->seek( 0, SEEK_END ); // nineth and last file.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $this->complexArchive->seek( -9, SEEK_END );  // invalid
        $this->assertFalse( $this->complexArchive->current() );
    }

    public function testSeekCur()
    {
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $this->complexArchive->seek( 2, SEEK_CUR ); // third file in archive.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $this->complexArchive->seek( 0, SEEK_CUR ); // Third file in archive.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $this->complexArchive->seek( 4, SEEK_CUR ); // Seventh file in the archive.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file2.txt", $entry->getPath() );

        $this->complexArchive->seek( 2, SEEK_CUR );  // nineth and last.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $this->complexArchive->seek( 1, SEEK_CUR );
        $this->assertFalse( $this->complexArchive->current() );

        $this->complexArchive->seek( 2 );
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $this->complexArchive->seek( -2, SEEK_CUR ); // First file.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $this->complexArchive->seek( -1, SEEK_CUR );  // And invalid again.
        $this->assertFalse( $this->complexArchive->current() );
    }

    public function testExtractOneDirectory()
    {
        // The subdirectory should be created automatically.
        $this->complexArchive->seek( 1 );
        $targetDir = $this->getTempDir() ;
        $this->complexArchive->extractCurrent( $targetDir );

        $this->assertTrue( file_exists( $targetDir . "/files/bla/" ), "Cannot find the extracted directory." );
    }

    public function testExtractOneFile()
    {
        // The directory should be created automatically.
        $this->complexArchive->seek( 4 ); // 5th file.
        $targetDir = $this->getTempDir();
        $this->complexArchive->extractCurrent( $targetDir );

        $this->assertTrue( file_exists( $targetDir . "/files/bla/file3.txt" ), "Cannot find the extracted file." );
        $this->assertEquals( "Hello world.\nThe third file.\n", file_get_contents( $targetDir . "/files/bla/file3.txt" ) );
    }

    public function testExtractOneSymbolicLink()
    {
        // this test a bit different in Windows as symlinks
        // simulated by copying
        if ( $this->isWindows() )
        {
            // The directory should be created automatically.
            // There is both link and link target extracted
            // and there are both the same file.
            $targetDir = $this->getTempDir();

            // extract target
            $this->complexArchive->seek( 4 );
            $this->complexArchive->extractCurrent( $targetDir );

            // "extract" link i.e. copy target
            $this->complexArchive->seek( 7 );
            $this->complexArchive->extractCurrent( $targetDir );
        }
        else
        {
            // The directory should be created automatically.
            // The link points to an non existing file.
            $this->complexArchive->seek( 7 );

            $targetDir = $this->getTempDir();

            $this->complexArchive->extractCurrent( $targetDir );
        }

        $this->assertTrue( is_array ( lstat( $targetDir . "/files/file3.txt" ) ) );
    }

    public function testExtractOneHardLinkException()
    {
        // Should throw an exception.
        $this->complexArchive->seek( 8 );
        $targetDir = $this->getTempDir();

        try
        {
            $this->complexArchive->extractCurrent( $targetDir );
            $this->fail( "Expected an exception" );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
        }
    }

    public function testExtractOneHardLink()
    {
        $this->complexArchive->seek( 4 );

        $targetDir = $this->getTempDir();

        $this->complexArchive->extractCurrent( $targetDir );

        $this->complexArchive->seek( 8 );
        $this->complexArchive->extractCurrent( $targetDir );

        $this->assertTrue( file_exists( $targetDir . "/files/bla/file3.txt" ) );
        $this->assertTrue( file_exists( $targetDir . "/files/file4.txt" ) );
    }

    public function testExtractComplexArchiveOverwrite()
    {
        $dir =  $this->getTempDir();
        mkdir( $dir . "/php" );
        mkdir( $dir . "/gnu" );

        // Extract once
        foreach ( $this->complexArchive as $entry )
        {
            $this->complexArchive->extractCurrent( $dir ."/php" );
        }

        // Extract with gnu tar.
        exec( "tar -xf " . $this->complexFile . " -C $dir/gnu" );

        // Truncate file1.txt
        $fp = fopen( $dir ."/php/files/file1.txt", "r+w" );
        ftruncate( $fp, 0 );
        fclose( $fp );

        // Change link.
        unlink( $dir . "/php/files/file3.txt" );

        if ( $this->isWindows() )
        {
            copy( $dir . "/php/files/file4.txt", $dir . "/php/files/file3.txt" );

            // make corrections of gnu tar output
            // replace .lnk file with copy of target file
            exec( 'attrib -r ' . $dir . '\gnu\files\file3.txt.lnk' );
            exec( 'del "' . $dir . '\gnu\files\file3.txt.lnk"' );
            exec( 'copy "' . $dir . '\gnu\files\bla\file3.txt" "' . $dir . '\gnu\files\file3.txt"' );
        }
        else
        {
            symlink( "file4.txt", $dir . "/php/files/file3.txt" );
        }

        // Truncate file4.txt (and also files/bla/file3.txt.
        $fp = fopen( $dir . "/php/files/file4.txt", "r+w" );
        ftruncate( $fp, 0 );
        fclose( $fp );

        foreach ( $this->complexArchive as $entry )
        {
            $this->complexArchive->extractCurrent( $dir . "/php" );
        }

        $this->compareDirectories( "$dir/gnu", "$dir/php" );
    }

    public function testExtractComplexArchiveKeepExisting()
    {
        $dir =  $this->getTempDir();
        mkdir( $dir . "/php" );
        mkdir( $dir . "/gnu" );

        // Extract once
        foreach ( $this->complexArchive as $entry )
        {
            $this->complexArchive->extractCurrent( $dir ."/php" );
        }

        // Extract with gnu tar.
        exec( "tar -xf " . $this->complexFile . " -C $dir/gnu" );

        // Truncate file1.txt
        $fp = fopen( $dir . "/php/files/file1.txt", "r+w" );
        ftruncate( $fp, 0 );
        fclose( $fp );

        // Change link.
        unlink( $dir . "/php/files/file3.txt" );

        if ( $this->isWindows() )
        {
            copy( $dir . "/php/files/file4.txt", $dir . "/php/files/file3.txt" );

            // make corrections of gnu tar output
            // replace .lnk file with copy of target file
            exec( 'attrib -r ' . $dir . '\gnu\files\file3.txt.lnk' );
            exec( 'del "' . $dir . '\gnu\files\file3.txt.lnk"' );
            exec( 'copy "' . $dir . '\gnu\files\bla\file3.txt" "' . $dir . '\gnu\files\file3.txt"' );
        }
        else
        {
            symlink( "file4.txt", $dir."/php/files/file3.txt");
        }

        // Truncate file4.txt (and also files/bla/file3.txt.
        $fp = fopen( $dir . "/php/files/file4.txt", "r+w" );
        ftruncate( $fp, 0 );
        fclose( $fp );

        foreach ( $this->complexArchive as $entry )
        {
            $this->complexArchive->extractCurrent( $dir . "/php", true );
        }

        $this->assertEquals( "", file_get_contents( $dir . "/php/files/file1.txt" ) );
        $this->assertEquals( "", file_get_contents( $dir . "/php/files/file3.txt" ) );
        $this->assertEquals( "", file_get_contents( $dir . "/php/files/file4.txt" ) );
        $this->assertEquals( "", file_get_contents( $dir . "/php/files/bla/file3.txt" ) );
    }

    // Write methods.

    public function testTruncate()
    {
        if ( !$this->canWrite )
        {
            try
            {
                $this->complexArchive->truncate();
                $this->fail( "Cannot write exception expected" );
            }
            catch ( ezcBaseFilePermissionException $e )
            {
                // Okay, some exception thrown.
            }

            return;
        }

        $this->complexArchive->truncate();
        $this->assertFalse( $this->complexArchive->valid(), "Truncated archive shouldn't contain any elements" );

        $this->complexArchive->seek( 0 );
        $this->assertFalse( $this->complexArchive->valid(), "Truncated archive shouldn't contain any elements" );

        $this->complexArchive->seek( 2 );
        $this->assertFalse( $this->complexArchive->valid(), "Truncated archive shouldn't contain any elements" );
    }

    public function testTruncatePart()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $this->complexArchive->truncate( 4 );

        // Without rewind.. should work since we truncated after our position.
        $entry = $this->complexArchive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $entry = $this->complexArchive->next();
        $this->assertEquals( "files/bla/", $entry->getPath() );

        $entry = $this->complexArchive->next();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $entry = $this->complexArchive->next();
        $this->assertEquals( "files/bla/bin/true", $entry->getPath() );

        $this->assertFalse( $this->complexArchive->next() );

        $this->complexArchive->seek( 6 );
        $this->assertFalse( $this->complexArchive->valid(), "Truncated archive shouldn't contain any elements" );
    }

    public function testTruncateLastFile()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        // Truncate after the last file, but don't write the null blocks.
        $this->archive->truncate( 2, false );

        // File should have 4 blocks.
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $i = 1;
        while ( $blockFile->next() )
        {
            $i++;
        }

        $this->assertEquals( 4, $i );

        unset( $blockFile );
    }

    public function testTruncateAmountOfBlocks()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $blockFile = new ezcArchiveBlockFile( $this->file );

        $i = 1;
        while ( $blockFile->next() ) $i++;
        $this->assertEquals( 20, $i, "Expected 20 blocks in the file." );

        $blockFile->seek( 2 );
        $this->assertFalse( $blockFile->isNullBlock(), "Didn't expect a null block." );

        $blockFile->seek( 3 );
        $this->assertFalse( $blockFile->isNullBlock(), "Didn't expect a null block." );

        $blockFile->seek( 4 );
        $this->assertTrue( $blockFile->isNullBlock(), "Expected a null block." );

        // Give the block File to the archive.
        $archive =  new ezcArchiveV7Tar( $blockFile );
        $entry = $archive->current();

        // A non rewinded block file, does that work?
        $this->assertEquals( "file1.txt", $entry->getPath() );

        $archive->truncate( 1 ); // keep the first file.
        $archive->close();

        $blockFile = new ezcArchiveBlockFile( $this->file );

        // Should be 20 blocks..
        $i = 1;
        while ( $blockFile->next() )
        {
            $i++;
        }

        $this->assertEquals( 20, $i, "Expected 20 blocks in the file." );

        $blockFile->seek( 0 );
        $this->assertFalse( $blockFile->isNullBlock(), "Didn't expect a null block." );

        $blockFile->seek( 1 );
        $this->assertFalse( $blockFile->isNullBlock(), "Didn't expect a null block." );

        $blockFile->seek( 2 );
        $this->assertTrue( $blockFile->isNullBlock(), "Expected a null block." );

        unset( $blockFile );
    }

    public function testAppendToCurrentNonExistingFile()
    {
        if ( !$this->canWrite )
        {
            try
            {
                $this->complexArchive->truncate();
                $this->fail( "Cannot write exception expected" );
            }
            catch ( ezcBaseFilePermissionException $e )
            {
                // Okay, some exception thrown.
            }

            return;
        }

        try
        {
            $this->archive->appendToCurrent( "file_does_not_exist", "/" );
            $this->fail( "Expected a 'file does not exist' exception." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
        }
    }

    public function testAppendToCurrentOnEmptyArchive()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $this->assertNotEquals( "\0\0a\0", "\0a\0\0", "Something wrong with the unit test system." );

        $this->archive->extractCurrent( $this->getTempDir() );

        $dir = $this->getTempDir();
        $emptyTar = "$dir/empty_archive.tar";
        $bf = new ezcArchiveBlockFile( $emptyTar, true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $this->assertFalse( $archive->valid() );
        $archive->appendToCurrent( "$dir/file1.txt", $dir );
        $archive->close();

        $this->assertEquals( 10240, strlen( file_get_contents( "$dir/empty_archive.tar" ) ), "Expected 20 blocks of 512 bytes" );

        // Do the same with gnu tar.
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file1.txt" );

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( "$dir/empty_archive.tar" ) );

        unset( $archive );
        unset( $bf );
    }

    public function testAppendToCurrentAtEndOfArchive()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();

        $bf = new ezcArchiveBlockFile( $this->file );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->extractCurrent( $dir );

        copy( $this->file, $dir."/gnutar.tar" );

        $archive->seek( 0, SEEK_END ); // File number two.
        $archive->appendToCurrent( "$dir/file1.txt", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -rf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file1.txt" );

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $this->file ) );

        unset( $archive );
        unset( $bf );
    }

    public function testAppendToCurrentInArchive()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();

        $bf = new ezcArchiveBlockFile( $this->file );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->extractCurrent( $dir );

        copy( $this->file, $dir."/gnutar.tar" );

        $archive->seek( 0 ); // After file number one.
        $archive->appendToCurrent( "$dir/file1.txt", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar --delete -f $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file2.txt" );
        exec( "tar -rf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file1.txt" );

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $this->file ) );

        unset( $bf );
    }

    public function testAppendToCurrentMultipleTimes()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        // Extract the archive.
        $dir = $this->getTempDir();

        $bf = new ezcArchiveBlockFile( $this->file );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->extractCurrent( $dir );
        $archive->next();
        $archive->extractCurrent( $dir );

        // Clear the archive.
        $archive->truncate();

        // Append the files again.
        $archive->appendToCurrent( $dir . "/file1.txt", $dir );
        // $this->assertTrue( $this->archive->next() !== false );
        $archive->appendToCurrent( $dir . "/file2.txt", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file1.txt file2.txt" );

        // Compare
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents($this->file ) );

        $bf = new ezcArchiveBlockFile( $this->file );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );

        // Append another file.
        $archive->append( $dir . "/file1.txt", $dir );
        $archive->close();

        exec( "tar -rf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file1.txt" );

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $this->file ) );
    }

    public function testAppendToCurrentDirectory()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();
        $this->complexArchive->extractCurrent( $dir );

        $emptyTar = "$dir/empty_archive.tar";
        $bf = new ezcArchiveBlockFile( $emptyTar, true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->appendToCurrent( $dir . "/files", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir files" );
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $emptyTar ) );
        unset( $bf );
    }

    public function testAppendToCurrentSymbolicLink()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        if ( $this->isWindows() )
        {
            return; // there is no sense to test it in Windows as its the same as appending file.
        }

        $dir = $this->getTempDir();
        $this->complexArchive->seek( 7 );
        $this->complexArchive->extractCurrent( $dir );

        $emptyTar = "$dir/empty_archive.tar";
        $bf = new ezcArchiveBlockFile( $emptyTar, true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->appendToCurrent( $dir . "/files/file3.txt", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir files/file3.txt" );
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $emptyTar ) );
        unset( $bf );
    }

    public function testAppendToCurrentHardLink()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();
        $this->complexArchive->seek( 4 ); // File.
        $this->complexArchive->extractCurrent( $dir );

        $this->complexArchive->seek( 8 ); // Hardlink
        $this->complexArchive->extractCurrent( $dir );

        $emptyTar = "$dir/empty_archive.tar";
        $bf = new ezcArchiveBlockFile( $emptyTar, true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->appendToCurrent( $dir . "/files/file4.txt", $dir );
        $archive->writeEnd();

        // Do the same with gnu tar.
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir files/file4.txt" );
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $emptyTar ) );

        // File was appended as a normal file.
        $archive->rewind();
        $archive->appendToCurrent( $dir . "/files/bla/file3.txt", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -rf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir files/bla/file3.txt" );

        // Appended as two separated files.
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $emptyTar ) );
        unset( $bf );
    }

    public function testAppendToCurrentHardLinkedFiles()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();
        $this->complexArchive->seek( 4 ); // File.
        $this->complexArchive->extractCurrent( $dir );

        $this->complexArchive->seek( 8 ); // Hardlink
        $this->complexArchive->extractCurrent( $dir );

        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir files/bla/file3.txt files/file4.txt" );

        $emptyTar = "$dir/empty_archive.tar";
        $bf = new ezcArchiveBlockFile( $emptyTar, true );

        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->appendToCurrent( array ( "$dir/files/bla/file3.txt", "$dir/files/file4.txt" ), $dir );
        $archive->close();

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $emptyTar ) );
        unset( $bf );
    }

    public function testAppendArchiveAtOnce()
    {
        if ( !$this->canWrite )
        {
            try
            {
                $this->complexArchive->truncate();
                $this->fail( "Cannot write exception expected" );
            }
            catch ( ezcBaseFilePermissionException $e )
            {
                // Okay, some exception thrown.
            }

            return;
        }

        $dir = $this->getTempDir();
        $src = $dir . "/src";
        mkdir ( $src );

        $files = array();
        do
        {
            $this->complexArchive->extractCurrent( $src );
            $files[] =  $src . '/'. $this->complexArchive->current()->getPath();
        } while ( $this->complexArchive->next() );

        $mytar = "$dir/my_archive.tar";
        $bf = new ezcArchiveBlockFile( $mytar, true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );
        $archive->appendToCurrent( $files, $src );
        $archive->close();
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $src files" );

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $mytar ) );
        unset( $archive );
        unset( $bf );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

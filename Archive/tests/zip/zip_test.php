<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once( dirname( __FILE__ ) . "/../testdata.php" );
require_once(dirname(__FILE__) . "/../archive_test_case.php");

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveZipTest extends ezcArchiveTestCase
{
    protected $td;
    protected $tempDir;

    protected function setUp()
    {
        date_default_timezone_set( "UTC" );

        $this->tempDir = $this->createTempDir( "ezcArchive_" );
        $dataDir = dirname( __FILE__ ) . "/../data/";

        $this->td = new ezcArchiveTestData( $dataDir, $this->tempDir, "zip", "infozip" );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    protected function isWindows()
    {
        return ( substr( php_uname( 's' ), 0, 7 ) == 'Windows' ) ? true : false;
    }

    public function testOpenArchive()
    {
        $archive = $this->td->getArchive( "2_textfiles" );
        $entry = $archive->current();
        $this->assertEquals( "file1.txt", $entry->getPath() );
    }

    public function testOttExtract()
    {
        $original = dirname(__FILE__) . "/../data/ezpublish.ott";
        $odtFile = $this->tempDir . "/ezpublish.ott";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );
        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "content.xml" ) );
        $this->assertEquals( 9695, filesize( $target . "content.xml" ) );
        $this->assertTrue( file_exists( $target . "Configurations2" ) );
        $this->assertTrue( file_exists( $target . "Configurations2/floater" ) );
        $this->assertEquals( 17723, filesize( $target . "styles.xml" ) );
        $this->assertEquals( 1693, filesize( $target . "Pictures/100000000000012C0000003CBE7676D8.gif" ) );

        $this->assertFalse( file_exists( $target . "Configurations2/file_does_not_exist" ) );
    }

    public function testOdtExtract()
    {
        $original = dirname(__FILE__) . "/../data/files_and_dirs.odt";
        $odtFile = $this->tempDir . "/files_and_dirs.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );
        $archive->extract($target);

        $this->assertTrue( file_exists( $target . "content.xml" ) );
        $this->assertEquals( 2553, filesize( $target . "content.xml" ) );
        $this->assertTrue( file_exists( $target . "Configurations2" ) );
        $this->assertTrue( file_exists( $target . "Configurations2/floater" ) );

        $this->assertFalse( file_exists( $target . "Configurations2/file_does_not_exist" ) );
    }

    public function testOdtSeekAndExtract()
    {
        $original = dirname(__FILE__) . "/../data/files_and_dirs.odt";
        $odtFile = $this->tempDir . "/files_and_dirs.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );

        $archive->seek( 4 ); // 5th file.
        $archive->extractCurrent( $target );
        $this->assertTrue( file_exists( $target . "Configurations2/popupmenu" ) );
    }

    public function testOdtAppend()
    {
        $original = dirname(__FILE__) . "/../data/files_and_dirs.odt";
        $odtFile = $this->tempDir . "/files_and_dirs.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );

        $archive->seek( 4 ); // 5th file.
        file_put_contents( $this->tempDir . "myfile.txt", "Hello world" );
        $archive->appendToCurrent( $this->tempDir . "myfile.txt", $this->tempDir );

        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "Configurations2/popupmenu" ) );
        $this->assertTrue( file_exists( $target . "myfile.txt" ) );
    }

    public function testOdtMac()
    {
        $original = dirname(__FILE__) . "/../data/mac_odt.odt";
        $odtFile = $this->tempDir . "/mac_odt.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );
        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "content.xml" ) );
        $this->assertTrue( file_exists( $target . "Configurations2" ) );
        $this->assertTrue( file_exists( $target . "Configurations2/floater" ) );

        $this->assertFalse( file_exists( $target . "Configurations2/file_does_not_exist" ) );
    }

    public function testOdtMacImg()
    {
        $original = dirname(__FILE__) . "/../data/mac_odt_with_img.odt";
        $odtFile = $this->tempDir . "/mac_odt_with_img.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );
        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "content.xml" ) );
        $this->assertTrue( file_exists( $target . "Configurations2" ) );
        $this->assertTrue( file_exists( $target . "Configurations2/floater" ) );
        $this->assertTrue( file_exists( $target . "Pictures/1000000000000168000000F05D0D62C6.png" ) );

        $this->assertFalse( file_exists( $target . "Configurations2/file_does_not_exist" ) );
    }

    public function testOdtWin()
    {
        $original = dirname(__FILE__) . "/../data/win_odt.odt";
        $odtFile = $this->tempDir . "/win_odt.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );
        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "content.xml" ) );
        $this->assertTrue( file_exists( $target . "Configurations2" ) );
        $this->assertTrue( file_exists( $target . "Configurations2/floater" ) );

        $this->assertFalse( file_exists( $target . "Configurations2/file_does_not_exist" ) );
    }

    public function testOdtWinImg()
    {
        $original = dirname(__FILE__) . "/../data/win_odt_with_img.odt";
        $odtFile = $this->tempDir . "/win_odt_with_img.odt";
        copy( $original, $odtFile );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $odtFile );
        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "content.xml" ) );
        $this->assertTrue( file_exists( $target . "Configurations2" ) );
        $this->assertTrue( file_exists( $target . "Configurations2/floater" ) );
        $this->assertTrue( file_exists( $target . "Pictures/10000000000001F4000001474F0889E4.jpg" ) );

        $this->assertFalse( file_exists( $target . "Configurations2/file_does_not_exist" ) );
    }


    public function testComments()
    {
        $original = dirname(__FILE__) . "/../data/infozip_comment.zip";
        $file = $this->tempDir . "/infozip_comment.zip";
        copy( $original, $file );
        $target = $this->tempDir . "/unzipped/";
        mkdir( $target );

        $archive = ezcArchive::open( $file );
        $archive->extract( $target );

        $this->assertTrue( file_exists( $target . "meta.xml" ) );
        $this->assertTrue( file_exists( $target . "mimetype" ) );
    }

    public function testEmptyArchive()
    {
        $archive = $this->td->getNewArchive( "does_not_exist" );

        $this->assertFalse( $archive->current(), "Archive should be empty, so no file info available" );
        $this->assertFalse( $archive->valid(), "Archive should be empty, so no  file info available" );
        $this->assertFalse( $archive->next(), "Archive should be empty, so no file info available" );
        $this->assertFalse( $archive->next(), "Archive should be empty, so no file info available" );

        if ( $this->isWindows() )
        {
            return; // avoid warning
        }

        unlink( 'does_not_exist' );
    }


    public function testIteratorOperations()
    {
        $archive  = $this->td->getArchive( "2_textfiles" );

        $entry = $archive->current();
        $entry = $archive->current();
        $this->assertEquals( "file1.txt", $entry->getPath() );
        $this->assertTrue( $archive->valid(), "Expected a valid archive position." );

        $archive->rewind();
        $entry = $archive->current();
        $this->assertEquals( "file1.txt", $entry->getPath() );
        $this->assertEquals( 0, $archive->key() );
        $this->assertTrue( $archive->valid(), "Expected a valid archive position." );


        $this->assertTrue( $archive->next() !== false );
        $entry = $archive->current();
        $this->assertEquals( "file2.txt", $entry->getPath() );
        $this->assertEquals( 1, $archive->key() );
        $this->assertTrue( $archive->valid(), "Expected a valid archive position." );

        $this->assertFalse( $archive->next() );
        $this->assertFalse( $archive->current() );
        $this->assertFalse( $archive->valid() );
        $this->assertFalse( $archive->key() );

        $this->assertFalse( $archive->next() );
        $this->assertFalse( $archive->next() );
    }

    public function testForEaching()
    {
        $archive = $this->td->getArchive( "2_textfiles" );

        for ( $i = 0; $i < 2; $i++ )
        {
            $loopNumber = 0;
            foreach ( $archive as $entryNumber => $entry )
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

        $archive = $this->td->getArchive( "2_textfiles" );
        $archive->extractCurrent( $targetDir );

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

        $archive->extractCurrent( $targetDir );
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );

        // Move on.
        $entry = $archive->next();

        $this->assertTrue( $archive->valid(), "Second file is expected here." );

        $archive->extractCurrent( $targetDir );
        $file2 = $this->getTempDir() . "/file2.txt";
        $this->assertEquals( "Hello world.\nThe second file.\n", file_get_contents( $file2 ) );

        $this->assertFalse( $archive->next(), "No more files in the archive" );
    }

    public function testExtractCurrentOverwriteFile()
    {
        $archive = $this->td->getArchive( "2_textfiles" );

        // Normally it will overwrite the file, if possible.
        $dir = $this->getTempDir() . "/";

        $archive->extractCurrent( $dir );
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( "$dir/file1.txt" ) );

        $fp = @fopen( "$dir/file1.txt", "w" );
        fwrite( $fp, "Garbage" );
        fclose( $fp );

        $this->assertEquals( "Garbage", file_get_contents( "$dir/file1.txt" ) );

        $archive->extractCurrent( $dir );
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( "$dir/file1.txt" ) );
    }

    public function testExtractCurrentKeepExistingFile()
    {
        $archive = $this->td->getArchive( "2_textfiles" );

        // Normally it will overwrite the file, if possible.
        $targetDir = $this->getTempDir() . "/";
        $archive->extractCurrent( $targetDir, true );

        $file1 = $this->getTempDir() . "/file1.txt";
        $this->assertEquals( "Hello world.\nThe first file.\n", file_get_contents( $file1 ) );

        $fp = @fopen( $file1, "w" );
        fwrite( $fp, "Garbage" );
        fclose( $fp );

        $this->assertEquals( "Garbage", file_get_contents( $file1 ) );

        $archive->extractCurrent( $targetDir, true );
        $this->assertEquals( "Garbage", file_get_contents( $file1 ) );
    }

    public function testSymlink()
    {
        if ( $this->isWindows() )
        {
            return; // symlinks extracted as files in Windows, so there is no sence to call is_link()
        }

        $dir = $this->getTempDir();
        $archive = $this->td->getArchive( "file_symlink" );

        foreach ( $archive as $entry )
        {
            $archive->extractCurrent( $dir );
        }

        $this->assertTrue( is_link( "$dir/mysym.txt" ) );
        $this->assertEquals( "file1.txt", readlink( "$dir/mysym.txt" ) );
    }

    public function testSeekPositions()
    {
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $archive->seek( 2 ); // third file in archive.
        $entry = $archive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $archive->seek( 0 ); // first file in archive.
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $archive->seek( 6 );
        $entry = $archive->current();
        $this->assertEquals( "files/file2.txt", $entry->getPath() );

        $archive->seek( 8 );
        $entry = $archive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $archive->seek( 9 );
        $this->assertFalse( $archive->current() );

        $archive->seek( 0 );
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $archive->seek( -1 );
        $this->assertFalse( $archive->current() );
    }

    public function testSeekEndOfFile()
    {
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $archive->seek( 0, SEEK_END ); // nineth and last file.
        $entry = $archive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $archive->seek( -2, SEEK_END ); // seventh file
        $entry = $archive->current();
        $this->assertEquals( "files/file2.txt", $entry->getPath() );

        $archive->seek( -8, SEEK_END ); // first file
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $archive->seek( 1, SEEK_END );  // invalid
        $this->assertFalse( $archive->current() );

        $archive->seek( 0, SEEK_END ); // nineth and last file.
        $entry = $archive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $archive->seek( -9, SEEK_END );  // invalid
        $this->assertFalse( $archive->current() );
    }

    public function testSeekCur()
    {
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $archive->seek( 2, SEEK_CUR ); // third file in archive.
        $entry = $archive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $archive->seek( 0, SEEK_CUR ); // Third file in archive.
        $entry = $archive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $archive->seek( 4, SEEK_CUR ); // Seventh file in the archive.
        $entry = $archive->current();
        $this->assertEquals( "files/file2.txt", $entry->getPath() );

        $archive->seek( 2, SEEK_CUR );  // nineth and last.
        $entry = $archive->current();
        $this->assertEquals( "files/file4.txt", $entry->getPath() );

        $archive->seek( 1, SEEK_CUR );
        $this->assertFalse( $archive->current() );

        $archive->seek( 2 );
        $entry = $archive->current();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $archive->seek( -2, SEEK_CUR ); // First file.
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $archive->seek( -1, SEEK_CUR );  // And invalid again.
        $this->assertFalse( $archive->current() );
    }

    public function testExtractOneDirectory()
    {
        // The subdirectory should be created automatically.
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $archive->seek( 1 );
        $targetDir = $this->getTempDir();
        $archive->extractCurrent( $targetDir );

        $this->assertTrue( file_exists( $targetDir . "/files/bla/" ), "Cannot find the extracted directory." );
    }

    public function testExtractOneFile()
    {
        // The directory should be created automatically.
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $archive->seek( 4 ); // 5th file.
        $targetDir = $this->getTempDir();
        $archive->extractCurrent( $targetDir );

        $this->assertTrue( file_exists( $targetDir . "/files/bla/file3.txt"), "Cannot find the extracted file." );
        $this->assertEquals( "Hello world.\nThe third file.\n", file_get_contents( $targetDir . "/files/bla/file3.txt" ) );
    }

    public function testExtractOneComprssedFile()
    {
        // The directory should be created automatically.
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $archive->seek( 3 ); // 5th file.
        $targetDir = $this->getTempDir();
        $archive->extractCurrent( $targetDir );

        $this->assertTrue( file_exists( $targetDir . "/files/bla/bin/true" ), "Cannot find the extracted file." );
    }

    // FIXME.. file is written, instead of a link.
    public function testExtractOneSymbolicLink()
    {
        // The directory should be created automatically.
        // The link points to an non existing file.
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $targetDir = $this->getTempDir() ;

        if ( $this->isWindows() ) // for windows we extract target file at first.
        {
            $archive->seek( 4 );
            $archive->extractCurrent( $targetDir );
        }

        $archive->seek( 7 );
        $archive->extractCurrent( $targetDir );
        $this->assertTrue( is_array (lstat( $targetDir."/files/file3.txt" ) ) );
    }

    public function testAppendNonExistingFile()
    {
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        try
        {
            $archive->appendToCurrent( "file_does_not_exist" , "/" );
            $this->fail( "Expected a 'file does not exist' exception." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
        }
    }

    public function testAppendEmptyDirectory()
    {
        $dir = $this->getTempDir();

        $archive = $this->td->getArchive( "2_textfiles" );
        $file = $this->td->getFileName( "2_textfiles" );

        copy( "$dir/$file", "$dir/done_with_infozip.zip" );

        $archive->next();

        $path = "$dir/directory/";
        mkdir( $path );
        $archive->append( $path, '' );

        $this->unzipAndTest( $dir, "done_with_infozip.zip", "$file" );
    }

    public function testAppendAtEndOfArchive()
    {
        $dir = $this->getTempDir();

        $archive = $this->td->getArchive( "2_textfiles" );
        $file = $this->td->getFileName( "2_textfiles" );

        copy( "$dir/$file", "$dir/done_with_infozip.zip" );

        $fp = @fopen( "$dir/file3.txt", "w" );
        fwrite( $fp, "This is the third file." );
        fclose( $fp );

        $archive->next();

        $archive->appendToCurrent( "$dir/file3.txt", $dir );

        // We got file1.txt, file2.txt, file3.txt.
        exec( "zip -g -j -y $dir/done_with_infozip.zip $dir/file3.txt " );

        $this->unzipAndTest( $dir, "done_with_infozip.zip", "$file" );
    }

    public function testAppendToCurrentInArchive()
    {
        $dir = $this->getTempDir();

        $archive = $this->td->getArchive( "2_textfiles" );
        $file = $this->td->getFileName( "2_textfiles" );

        copy( "$dir/$file", "$dir/done_with_infozip.zip" );

        $fp = @fopen( "$dir/file3.txt", "w" );
        fwrite( $fp, "This is the third file." );
        fclose( $fp );

        // No next.. so file1.txt and file3.txt should be here.
        $archive->appendToCurrent( "$dir/file3.txt", $dir );

        exec( "zip -d $dir/done_with_infozip.zip file2.txt " ); // Remove file2.txt
        exec( "zip -g -j -y $dir/done_with_infozip.zip $dir/file3.txt " );

        $this->unzipAndTest( $dir, "done_with_infozip.zip", "$file" );
    }

    public function testTruncate()
    {
        $archive = $this->td->getArchive( "2_textfiles" );
        $archive->truncate();
        $this->assertFalse( $archive->valid(), "Truncated archive shouldn't contain any elements" );

        $archive->seek( 0 );
        $this->assertFalse( $archive->valid(), "Truncated archive shouldn't contain any elements" );

        $archive->seek( 2 );
        $this->assertFalse( $archive->valid(), "Truncated archive shouldn't contain any elements" );
    }

    public function testTruncatePart()
    {
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $archive->truncate( 4 );

        // Without rewind.. should work since we truncated after our position.
        $entry = $archive->current();
        $this->assertEquals( "files/", $entry->getPath() );

        $entry = $archive->next();
        $this->assertEquals( "files/bla/", $entry->getPath() );

        $entry = $archive->next();
        $this->assertEquals( "files/bla/bin/", $entry->getPath() );

        $entry = $archive->next();
        $this->assertEquals( "files/bla/bin/true", $entry->getPath() );

        $this->assertFalse( $archive->next() );

        $archive->seek( 6 );
        $this->assertFalse( $archive->valid(), "Truncated archive shouldn't contain any elements" );
    }

    public function testTruncateAfterLastFile()
    {
        $archive = $this->td->getArchive( "2_textfiles" );
        $filename = $this->td->getFileName( "2_textfiles" );
        $orgSize = filesize( $this->getTempDir() . "/" .  $filename );

        $archive->truncate( 2 );
        clearstatcache();
        $this->assertEquals( $orgSize, filesize( $this->getTempDir() . "/" . $filename ) );

        $archive->truncate(1);
        clearstatcache();
        $this->assertTrue( $orgSize > filesize( $this->getTempDir() . "/" . $filename ) );
    }

    public function testAppendToEmptyArchive()
    {
        $dir = $this->getTempDir();

        $archive = $this->td->getArchive( "2_textfiles" );
        $file = $this->td->getFileName( "2_textfiles" );

        // copy( "$dir/$file", "$dir/done_with_infozip.zip" );

        $archive->extractCurrent( $dir );
        $archive->truncate();

        $fp = @fopen( "$dir/file3.txt", "w" );
        fwrite( $fp, "This is the third file." );
        fclose( $fp );

        $archive->appendToCurrent( "$dir/file1.txt", $dir );
        $this->assertTrue( $archive->valid() );
        $archive->appendToCurrent( "$dir/file3.txt", $dir );

        exec( "zip -j -y $dir/done_with_infozip.zip $dir/file1.txt $dir/file3.txt" );

        $this->unzipAndTest( $dir, "done_with_infozip.zip", "$file" );
    }

    public function testAppendArchiveAtOnce()
    {
        $dir = $this->getTempDir();
        $archive = $this->td->getArchive( "file_dir_symlink_link" );
        $file = $this->td->getFileName( "file_dir_symlink_link" );

        mkdir( "$dir/original" );
        mkdir( "$dir/myzip" );

        // Unzip all the files, and place them in the original directory.
        // Store the filepath of the extracted files.
        $files = array();
        do
        {
            $archive->extractCurrent( "$dir/original" );
            $files[] =  $dir . "/original/" . $archive->current()->getPath();
        } while ( $archive->next() );

        // Create a new archive
        $myzip = "$dir/my_archive.zip";
        $cf = new ezcArchiveCharacterFile( $myzip, true );
        $newArchive = new ezcArchiveZip( $cf );

        // Append all the extracted files.
        $newArchive->appendToCurrent( $files, $dir . "/original" );

        // Extract all (again).
        $newArchive->extract( "$dir/myzip" );

        // Compare the directories.
        $this->compareDirectories( "$dir/original", "$dir/myzip" );
    }

    // test for issue #13137
    public function testAppendToArchive()
    {
        try 
        {
            $name = $this->getTempDir() . DIRECTORY_SEPARATOR . 'my_archive.zip';
            $archive = ezcArchive::open( $name, ezcArchive::ZIP );
            $dir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'testfiles';

            $files = array(
                "$dir/test2.php",
                "$dir/test1.php",
                "$dir/test7.php",
                "$dir/unicode.php"
            );

            $archive->append( $files, '' );
            $archive->close();
        }
        catch ( Exception $e )
        {
            echo $e->__toString();
        }
    }


    public function unzipAndTest( $dir, $a, $b )
    {
        // They are probably not identical..
        // Extract both.
        mkdir( "$dir/infozip" ); // a
        mkdir( "$dir/ezczip" ); // b

        exec( "unzip $dir/$a -d $dir/infozip" );
        exec( "unzip $dir/$b -d $dir/ezczip" );

        $this->compareDirectories( "$dir/infozip", "$dir/ezczip" );
    }

//        $dir =  $this->getTempDir();
//        mkdir( $dir . "/php" );
//        mkdir( $dir . "/gnu" );
//
//        foreach ( $this->complexArchive as $entry )
//        {
//            $this->complexArchive->extractCurrent( $dir ."/php" );
//        }
//
//        exec( "tar -xf " . $this->complexFile . " -C $dir/gnu" );
//
//        $this->compareDirectories( "$dir/gnu", "$dir/php" );

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

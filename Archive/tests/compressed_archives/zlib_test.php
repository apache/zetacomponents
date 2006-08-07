<?php

require_once( dirname( __FILE__ ) . "/../testdata.php" );
require_once(dirname(__FILE__) . "/../archive_test_case.php");

class ezcArchiveZlibTest extends ezcArchiveTestCase
{
    public function setUp()
    {
        $this->createTempDir( "ezcArchive_" );
        date_default_timezone_set("UTC"); 
    }

    public function tearDown()
    {
        $this->removeTempDir();
    }

    public function testCreateTar()
    {
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( "$dir/mytar.tar", ezcArchive::TAR_USTAR);
        file_put_contents( "$dir/a.txt", "Hello world!" );
        $archive->append( "$dir/a.txt", $dir);
        $archive->close();

        exec("tar -cf $dir/gnutar.tar --format=ustar -C $dir a.txt");

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( "$dir/mytar.tar" ) );
    }


    public function testCreateGzippedTar()
    {
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( "compress.zlib://$dir/mytar.tar.gz", ezcArchive::TAR_USTAR);
        file_put_contents( "$dir/a.txt", "Hello world!" );
        $archive->append( "$dir/a.txt", $dir);
        $archive->close();

        exec("tar -cf $dir/gnutar.tar --format=ustar -C $dir a.txt");
        exec("gunzip $dir/mytar.tar.gz");

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( "$dir/mytar.tar" ) );
    }

    public function testWriteToExistingGzippedTar()
    {
        // Create an archive with one file.
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( "compress.zlib://$dir/mytar.tar.gz", ezcArchive::TAR_USTAR);
        file_put_contents( "$dir/a.txt", "Hello world!" );
        $archive->append( "$dir/a.txt", $dir);
        $archive->close();

        // Reopen it and append another file.
        $archive = ezcArchive::open( "compress.zlib://$dir/mytar.tar.gz", ezcArchive::TAR_USTAR);

        try 
        {
            $archive->append( "$dir/a.txt", $dir);
            $this->fail( "Expected a 'cannot-append' exception");
        } 
        catch( ezcArchiveException $e )
        {

        }
        $archive->close();
    }
  

    public function testCreateNewGzippedTarArchiveTogetherWithReadingEntries()
    {
        $dir = $this->getTempDir();

        // Create some test data.
        file_put_contents( "$dir/a.txt", "AAAAAAAAAAA" );
        file_put_contents( "$dir/b.txt", "BBBBBBBBBBB" );
        file_put_contents( "$dir/c.txt", "CCCCCCCCCCC" );


        // Create a new archive
        $archive = ezcArchive::open( "compress.zlib://$dir/mytar.tar.gz", ezcArchive::TAR_USTAR);
        $archive->append( "$dir/a.txt", $dir);
        $archive->rewind();
        $a = $archive->current();
        $this->assertEquals( "a.txt", $a->getPath(false) );

        $archive->rewind();
        $archive->append( "$dir/b.txt", $dir);

        $a = $archive->current();
        $this->assertEquals( "a.txt", $a->getPath(false) );

        $a = $archive->next();
        $this->assertEquals( "b.txt", $a->getPath(false) );

        $archive->rewind();
        $archive->close();


        // Reopen it and append another file.
        $archive = ezcArchive::open( "compress.zlib://$dir/mytar.tar.gz", ezcArchive::TAR_USTAR);

        try 
        {
            $archive->append( "$dir/a.txt", $dir);
            $this->fail( "Expected a 'cannot-append' exception");
        } 
        catch( ezcArchiveException $e )
        {

        }
        $archive->close();
    }

    public function testAppendToCurrentException()
    {
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( "compress.zlib://$dir/mytar.tar.gz", ezcArchive::TAR_USTAR);
        file_put_contents( "$dir/a.txt", "AAAAAAAAAAA" );

        try
        {
            $archive->appendToCurrent( "$dir/a.txt", $dir);
            $this->fail( "Except an exception that the file couldn't be appended.");
        }
        catch( ezcArchiveException $e )
        {
        }
    }


// AppendToCurrent Exception.
// Close exception.

/*
    public function testReadBzippedTar()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar");
        
        exec( "bzip2 $dir/mytar.tar" );
        $archive = ezcArchive::open( "compress.bzip2://$dir/mytar.tar.bz2" );
        //echo ( $archive );

        $archive->extract( $dir );
        $archive->rewind();

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }

    public function testReadBzippedTarAuto()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar");
        
        exec( "bzip2 $dir/mytar.tar" );
        $archive = ezcArchive::open( "$dir/mytar.tar.bz2" );

        $archive->extract( $dir );
        $archive->rewind();

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }

    public function readBzippedGzippedTar()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar");
        
        exec( "gzip $dir/mytar.tar" );
        exec( "bzip2 $dir/mytar.tar.gz" );
        $archive = ezcArchive::open( "$dir/mytar.tar.gz.bz2" );

        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }

 
    public function testTarIncorrectBlockSizeException()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/infozip_2_textfiles.zip", "$dir/mytar.tar");
        
        try
        {
            $archive = ezcArchive::open( "$dir/mytar.tar", ezcArchive::TAR_V7 );
            $entry = $archive->current();
            $this->fail("This is not an Tar, so throw an exception");
        } 
        catch ( ezcArchiveBlockSizeException $e )
        {
        }
    }

    public function testWriteBzippedTar()
    {
        $dir = $this->getTempDir();

        try
        {
            $archive = ezcArchive::open( "compress.bzip2://$dir/mytar.tar.bz2" );

            file_put_contents( "$dir/file3.txt", "Hahaha");
            $archive->appendToCurrent( "$dir/file3.txt", $dir);
            $this->fail( "Read only exception expected");
        }
        catch (ezcArchiveUnknownTypeException $e )
        {
        }
    }

    /*
    public function testWriteBzippedTarAuto()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar");
        
        exec( "bzip2 $dir/mytar.tar" );
        $archive = ezcArchive::open( "$dir/mytar.tar.bz2" );

        try
        {
            file_put_contents( "$dir/file3.txt", "Hahaha");
            $archive->appendToCurrent( "$dir/file3.txt", $dir);
            $this->fail( "Read only exception expected");
        }
        catch (ezcBaseFilePermissionException $e )
        {
            // Expect read-only exception.
        }
    }
     */


    /*
    public function testGzippedGzippedTar()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/tar_pax_2_textfiles.tar", "$dir/mytar.tar");
        
        exec( "gzip $dir/mytar.tar" );

        rename( "$dir/mytar.tar.gz", "$dir/mytar.tar.a");
        exec( "gzip $dir/mytar.tar.a" );
        $archive = ezcArchive::open( "$dir/mytar.tar.a.gz" );
        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }
    */
/*
    public function testForceUstarTar()
    {
        $dir = $this->getTempDir();

        // Filesize is smaller than the blocksize.
        copy(  dirname( __FILE__ ) . "/data/infozip_2_textfiles.zip", "$dir/myzip.zip");
        
        try
        {
            // File size too small.
            $archive = ezcArchive::open( "$dir/myzip.zip", ezcArchive::TAR_V7 );
            $archive->extract( $dir );
            $this->fail( "Exception expected since we cannot extract a Zip archive with the Tar handler. ");
        }
        catch (ezcArchiveException $e)
        {
            // Okay.
        }
    }

    public function testForceUstarTarPart2()
    {
        $dir = $this->getTempDir();
        copy(  dirname( __FILE__ ) . "/data/infozip_file_dir_symlink_link.zip", "$dir/myzip.zip");
        
        try
        {
            // CRC is incorrect.
            $archive = ezcArchive::open( "$dir/myzip.zip", ezcArchive::TAR_V7 );
            $archive->extract( $dir );

            $this->fail( "Exception expected since we cannot extract a Zip archive with the Tar handler. ");
        }
        catch (ezcArchiveException $e)
        {
            // Okay.
        }
    }

    public function testCreateNewArchive()
    {
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( "$dir/myzip.zip", ezcArchive::ZIP );
        file_put_contents( "$dir/bla.txt", "Hello world");
        file_put_contents( "$dir/bla2.txt", "Hello world2");
        $archive->append("$dir/bla.txt", "$dir");
        $archive->append("$dir/bla2.txt", "$dir");

        $archive->rewind();
        $this->assertEquals( "bla.txt", $archive->current()->getPath() );
        $this->assertEquals( "bla2.txt", $archive->next()->getPath() );
    }

    public function testCreateNewArchiveWithoutType()
    {
        $dir = $this->getTempDir();
        try
        {
            $archive = ezcArchive::open( "$dir/myzip.zip" );
            $this->fail( "Exception expected, because the type is missing");
        }
        catch ( ezcArchiveException $e )
        {
        }
    }
    
/* Doesn't work, because we cannot read and write to an gzipped file at the same time.
 */
    /*
    public function testCreateNewGzippedTar()
    {
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( "compress.zlib://$dir/my.tar.gz", ezcArchive::TAR );

        file_put_contents( "$dir/bla.txt", "Hello world");
        file_put_contents( "$dir/bla2.txt", "Hello world2");
        $archive->append("$dir/bla.txt", "$dir");
        $archive->append("$dir/bla2.txt", "$dir");

        // First check: okay in archive.
        $archive->rewind();
        $this->assertEquals( "bla.txt", $archive->current()->getPath() );
        $this->assertEquals( "bla2.txt", $archive->next()->getPath() );

        // Second check: Reread the archive..  and read it. 
        $archive = ezcArchive::open( "$dir/my.tar.gz" );
        $this->assertEquals( "bla.txt", $archive->current()->getPath() );
        $this->assertEquals( "bla2.txt", $archive->next()->getPath() );
    }
*/


    public static function suite()
    {
        return new ezcTestSuite( "ezcArchiveZlibTest" );
    }

}


?>

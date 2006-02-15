<?php

require_once( "ustar_tar_test.php" );

// Extend the Ustar tests.
class ezcArchivePaxTarTest extends ezcArchiveUstarTarTest
{
    public function setUp()
    {
        date_default_timezone_set("UTC"); 
        $this->tarFormat = "posix";
        $this->tarMimeFormat = ezcArchive::TAR_PAX;
        $this->canWrite = false;

        $this->createTempDir("ezcArchive_");

        $this->file = $this->createTempFile("tar_pax_2_textfiles.tar");
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $this->archive = new ezcArchivePaxTar( $blockFile );

        $this->complexFile = $this->createTempFile("tar_pax_file_dir_symlink_link.tar");
        $blockFile = new ezcArchiveBlockFile( $this->complexFile );
        $this->complexArchive = new ezcArchivePaxTar( $blockFile );
    }

    public function tearDown()
    {
        $this->removeTempDir();
    }

    // Skip character device. It is most probably the same as in Ustar. 
    public function testExtractCharacterDevice() { }

    // Skip fifo. It is most probably the same as in Ustar. 
    public function testExtractFifo() { }


    public function testReallyLongFileName ()
    {
        $dir = $this->getTempDir();

        $dirname = "aaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbb"; // 60 char.
        mkdir( "$dir/$dirname/$dirname/$dirname", 0777, true );

        $filename = "ccccccccccddddddddddccccccccccddddddddddccccccccccdddddddddd"; // 60 char.
        touch ( "$dir/$dirname/$dirname/$dirname/$filename" );

        exec("tar -cf $dir/gnutar.tar --format=".$this->tarFormat." -C $dir $dirname");

        unlink("$dir/$dirname/$dirname/$dirname/$filename" );
        rmdir( "$dir/$dirname/$dirname/$dirname" );
        rmdir( "$dir/$dirname/$dirname" );
        rmdir( "$dir/$dirname" );

        // Extract it.
        
        $bf = new ezcArchiveBlockFile( "$dir/gnutar.tar" );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        foreach ($archive as $entry )
        {
            $archive->extractCurrent( $dir );
        }

        $this->assertTrue( file_exists( "$dir/$dirname/$dirname/$dirname/$filename" ) );

    }

    public function testExtractLongLinkName()
    {
        $dir = $this->getTempDir();

        $dirname = "aaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbbaaaaaaaaaabbbbbbbbbb"; // 60 char.
        mkdir( "$dir/$dirname/$dirname/$dirname", 0777, true );

        $filename = "ccccccccccddddddddddccccccccccddddddddddccccccccccdddddddddd"; // 60 char.
        touch ( "$dir/$dirname/$dirname/$dirname/$filename" );

        symlink( "$dirname/$dirname/$dirname/$filename", "$dir/mylink" );

        exec("tar -cf $dir/gnutar.tar --format=".$this->tarFormat." -C $dir mylink");

        unlink("$dir/$dirname/$dirname/$dirname/$filename" );
        rmdir( "$dir/$dirname/$dirname/$dirname" );
        rmdir( "$dir/$dirname/$dirname" );
        rmdir( "$dir/$dirname" );

        // Extract it.
        $bf = new ezcArchiveBlockFile( "$dir/gnutar.tar" );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        foreach ($archive as $entry )
        {
            $archive->extractCurrent( $dir );
        }

        $this->assertTrue( is_link( "$dir/mylink" ) );
        $this->assertEquals( "$dirname/$dirname/$dirname/$filename", readlink("$dir/mylink")  );
    }

    public function testExtractHugeFile()
    {
        // TODO.
    }

    public static function suite()
    {
        return new ezcTestSuite("ezcArchivePaxTarTest");
    }
}

?>

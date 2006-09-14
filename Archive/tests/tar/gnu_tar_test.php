<?php

require_once( "pax_tar_test.php" );

// Use the pax tests.
class ezcArchiveGnuTarTest extends ezcArchivePaxTarTest
{
    protected function setUp()
    {
        date_default_timezone_set("UTC"); 
        $this->tarFormat = "gnu";
        $this->tarMimeFormat = ezcArchive::TAR_GNU;
        $this->canWrite = false;

        $this->createTempDir("ezcArchive_");

        $this->file = $this->createTempFile("tar_gnu_2_textfiles.tar");
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $this->archive = new ezcArchiveGnuTar( $blockFile );

        $this->complexFile = $this->createTempFile("tar_gnu_file_dir_symlink_link.tar");
        $blockFile = new ezcArchiveBlockFile( $this->complexFile );
        $this->complexArchive = new ezcArchiveGnuTar( $blockFile );
    }

    protected function tearDown()
    {
        unset( $this->archive );
        unset( $this->file );
        unset( $this->complexArchive ) ;
        unset( $this->complexFile );
        $this->removeTempDir();
    }

    public static function suite()
    {
        return new ezcTestSuite("ezcArchiveGnuTarTest");
    }
}

?>

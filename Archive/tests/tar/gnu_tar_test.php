<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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

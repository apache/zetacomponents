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
    }

    protected function tearDown()
    {
        unset( $this->archive );
        unset( $this->file );
        unset( $this->complexArchive );
        unset( $this->complexFile );
        $this->removeTempDir();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

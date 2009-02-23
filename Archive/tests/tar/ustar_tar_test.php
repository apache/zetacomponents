<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once( "v7_tar_test.php" );

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveUstarTarTest extends ezcArchiveV7TarTest // Extend the V7 tests (should work with Ustar also)
{
    protected function setUp()
    {
        date_default_timezone_set( "UTC" ); 
        $this->tarFormat = "ustar";
        $this->tarMimeFormat = ezcArchive::TAR_USTAR;

        $this->createTempDir( "ezcArchive_" );

        $this->file = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->file );
        $this->archive = new ezcArchiveUstarTar( $blockFile );

        $this->complexFile = $this->createTempFile( "tar_ustar_file_dir_symlink_link.tar" );
        $blockFile = new ezcArchiveBlockFile( $this->complexFile );
        $this->complexArchive = new ezcArchiveUstarTar( $blockFile );
        unset( $blockFile );
    }

    protected function tearDown()
    {
        unset( $this->archive );
        unset( $this->file );
        unset( $this->complexArchive ) ;
        unset( $this->complexFile );
        $this->removeTempDir();
    }

    /*
    public function testTarType()
    {
        $ustarFile = new ezcArchiveBlockFile( dirname( __FILE__) . "/../data/tar_ustar_2_textfiles.tar" );
        $v7File = new ezcArchiveBlockFile( dirname( __FILE__) . "/../data/tar_v7_2_textfiles.tar" );

        $this->assertEquals( ezcArchive::CAN_READ_AND_WRITE, ezcArchiveUstarTar::canHandle( $ustarFile ) );
        $this->assertEquals( ezcArchive::NONE, ezcArchiveUstarTar::canHandle( $v7File ) );
    }
    */

    public function testLongFileName()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();

        $filename = "";

        if ( $this->isWindows() )
        {
            $pathItemLen = 50;  // long but not looong path. Windows max path = 255.
        }
        else
        {
            $pathItemLen = 70;
        }

        for ( $i = 0; $i < $pathItemLen; $i++ )
        {
            $filename .= ( $i % 10 );
        }

        mkdir( "$dir/$filename" );
        mkdir( "$dir/$filename/$filename" );

        touch( "$dir/$filename/$filename/$filename" );

        $bf = new ezcArchiveBlockFile( "$dir/myarchive.tar", true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        $archive->appendToCurrent( "$dir/$filename/$filename/$filename", $dir );
        $archive->close();

        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir $filename/$filename/$filename" );
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( "$dir/myarchive.tar" ) );

        unset( $archive );
        unset( $bf );
    }

    public function testLongFilenameException()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();

        $filename = "";

        // $filename too long.
        for ( $i = 0; $i < 101; $i++ )
        {
            $filename .= ( $i % 10 );
        }

        touch( "$dir/$filename" );

        $bf = new ezcArchiveBlockFile( "$dir/myarchive.tar", true );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        try
        {
            $archive->appendToCurrent( "$dir/$filename", $dir );
            $this->fail( "Expected a 'filename too long' exception." );
        }
        catch ( ezcArchiveException $e )
        {
            // Okay.
        }
    }

    public function testExtractCharacterDevice()
    {
        $dir = $this->getTempDir();

        // Can we create a character device?
        if (!ezcBaseFeatures::hasFunction( 'posix_mknod' ) ||
            !posix_mknod( "$dir/can_create_character_device", POSIX_S_IFCHR | 0777, 5, 1 ) )
        {
            // Failed, skip the test.
            return;
        }

        unlink( "$dir/can_create_character_device" );

        $org = dirname(__FILE__) . "/../data/tar_ustar_character_device.tar";
        copy( $org, $dir . "/tar_ustar_character_device.tar" );

        $bf = new ezcArchiveBlockFile( $dir . "/tar_ustar_character_device.tar" );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );

        $archive->extractCurrent( $dir );

        // Zero device should be here..
        $this->assertEquals( "\0\0\0\0\0\0\0\0\0\0", file_get_contents( "$dir/myzero", false, null, 0, 10 ) );

        unlink( "$dir/myzero" );
    }

    public function testExtractFIFO()
    {
        $dir = $this->getTempDir();

        $org = dirname(__FILE__) . "/../data/tar_ustar_fifo.tar";
        copy( $org, $dir . "/tar_ustar_fifo.tar" );

        $bf = new ezcArchiveBlockFile( $dir . "/tar_ustar_fifo.tar" );
        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );

        $archive->extractCurrent( $dir );

        // Zero device should be here..
        clearstatcache();
        $this->assertTrue( file_exists( "$dir/myfifo" ) );

        unlink( "$dir/myfifo" );
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

        copy( $this->file, $dir . "/gnutar.tar" );

        $archive->seek( 0, SEEK_END ); // File number two.
        $archive->appendToCurrent( "$dir/file1.txt", $dir );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -rf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir file1.txt" );

        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $this->file ) );
    }

    public function testAppendToCurrentCharacterDevice()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        $dir = $this->getTempDir();

        $chartar = "$dir/my_character_device.tar";
        $bf = new ezcArchiveBlockFile( $chartar, true );

        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat ); 

        // Appending an character device.
        try
        {
            $archive->appendToCurrent( "/dev/zero", "/dev/" );
            $archive->close();

            // Do the same with gnu tar.
            exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C /dev/ zero" );
            $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $chartar ) );
        }
        catch ( ezcArchiveException $e )
        {
            if ( $e->getMessage() != "Cannot add a device to the TAR because the device type cannot be determined. Your system / PHP version does not support 'st_blksize'." )
            {
                $this->fail( "Unexpected exception: " . $e->getMessage() );
            }

            $s = stat( "/dev/zero" );
            if ( $s["rdev"] != -1 )
            {
                $this->fail( "This exception is only valid when the stat()['rdev'] is not available." );
            }
        }
    }

    public function testAppendToCurrentFifo()
    {
        if ( !$this->canWrite )
        {
            return;
        }

        if ( !ezcBaseFeatures::hasFunction( 'posix_mknod' ) )
        {
            return;
        }

        $dir = $this->getTempDir();

        posix_mknod( "$dir/myfifo", POSIX_S_IFIFO );

        $fifo = "$dir/my_fifo.tar";
        $bf = new ezcArchiveBlockFile( $fifo, true );

        $archive = ezcArchive::getTarInstance( $bf, $this->tarMimeFormat );

        $archive->appendToCurrent( "$dir/myfifo", "$dir" );
        $archive->close();

        // Do the same with gnu tar.
        exec( "tar -cf $dir/gnutar.tar --format=" . $this->tarFormat . " -C $dir/ myfifo" );
        $this->assertEquals( file_get_contents( "$dir/gnutar.tar" ), file_get_contents( $fifo ) );

        unlink( "$dir/myfifo" );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

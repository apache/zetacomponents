<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once( dirname( __FILE__ ) . "/testdata.php" );
require_once(dirname(__FILE__) . "/archive_test_case.php");

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveTest extends ezcArchiveTestCase
{
    protected function setUp()
    {
        $this->createTempDir( "ezcArchive_" );
        date_default_timezone_set( "UTC" );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testRecognizePaxTar()
    {
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/tar_pax_2_textfiles.tar" );

        $this->assertNotNull( $archive );
        $this->assertEquals( ezcArchive::TAR_PAX, $archive->getAlgorithm() );

        $this->assertFalse( $archive->algorithmCanWrite() );
    }

    public function testRecognizeGnuTar()
    {
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/tar_gnu_2_textfiles.tar" );

        $this->assertNotNull( $archive );
        $this->assertEquals( ezcArchive::TAR_GNU, $archive->getAlgorithm() );

        $this->assertFalse( $archive->algorithmCanWrite() );
    }

    public function testRecognizeGnuTar2()
    {
        $file = dirname(__FILE__). '/data/gnu_tar.tar';
        $archive = ezcArchive::open( $file );
        $this->assertEquals( ezcArchive::TAR_GNU, $archive->getAlgorithm() );
    }

    public function testRecognizeGnuTar3()
    {
        $file = dirname(__FILE__). '/data/gnu_tar2.tar';
        $archive = ezcArchive::open( $file );
        $this->assertEquals( ezcArchive::TAR_GNU, $archive->getAlgorithm() );
    }

    public function testRecognizeUstar()
    {
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar" );

        $this->assertNotNull( $archive );
        $this->assertEquals( ezcArchive::TAR_USTAR, $archive->getAlgorithm() );

        $this->assertTrue( $archive->algorithmCanWrite() );
    }

    public function testRecognizeV7Tar()
    {
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/tar_v7_2_textfiles.tar" );

        $this->assertNotNull( $archive );
        $this->assertEquals( ezcArchive::TAR_V7, $archive->getAlgorithm() );

        $this->assertTrue( $archive->algorithmCanWrite() );
    }

    public function testRecognizeZip()
    {
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/infozip_2_textfiles.zip" );

        $this->assertNotNull( $archive );
        $this->assertEquals( ezcArchive::ZIP, $archive->getAlgorithm() );

        $this->assertTrue( $archive->algorithmCanWrite() );
    }

    public function testExtractAll()
    {
        // Just choose one type. The specific algorithms are already tested.
        $dir = $this->getTempDir();
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/tar_pax_2_textfiles.tar" );
        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }

    // Extracting works fine. But adding files breaks.
    public function testReadGzippedTarAuto()
    {
        $dir = $this->getTempDir() . DIRECTORY_SEPARATOR;
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "{$dir}mytar.tar" );

        exec( "gzip {$dir}mytar.tar" );
        $archive = ezcArchive::open( "{$dir}mytar.tar.gz" );
        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "{$dir}file1.txt" ) );
        $this->assertTrue( file_exists( "{$dir}file2.txt" ) );
    }

    // Extracting works fine. But adding files breaks.

    public function testReadGzippedTar()
    {
        $dir = $this->getTempDir(). DIRECTORY_SEPARATOR;
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "{$dir}mytar.tar" );

        exec( "gzip {$dir}mytar.tar" );
        $archive = ezcArchive::open( "compress.zlib://{$dir}mytar.tar.gz" );
        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "{$dir}file1.txt" ) );
        $this->assertTrue( file_exists( "{$dir}file2.txt" ) );
    }

    public function testReadBzippedTar()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bz2' ) )
        {
            $this->markTestSkipped();
        }

        $dir = $this->getTempDir() . DIRECTORY_SEPARATOR;
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "{$dir}mytar.tar" );

        exec( "bzip2 {$dir}mytar.tar" );
        $archive = ezcArchive::open( "compress.bzip2://{$dir}mytar.tar.bz2" );
        // echo ( $archive );

        $archive->extract( $dir );
        $archive->rewind();

        clearstatcache();
        $this->assertTrue( file_exists( "{$dir}file1.txt" ) );
        $this->assertTrue( file_exists( "{$dir}file2.txt" ) );
    }

    public function testReadBzippedTarAuto()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bz2' ) )
        {
            $this->markTestSkipped();
        }

        $dir = $this->getTempDir() . DIRECTORY_SEPARATOR;
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "{$dir}mytar.tar" );

        exec( "bzip2 {$dir}mytar.tar" );
        $archive = ezcArchive::open( "{$dir}mytar.tar.bz2" );

        $archive->extract( $dir );
        $archive->rewind();

        clearstatcache();
        $this->assertTrue( file_exists( "{$dir}file1.txt" ) );
        $this->assertTrue( file_exists( "{$dir}file2.txt" ) );
    }

    public function testReadBzippedGzippedTar()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar" );

        exec( "gzip $dir/mytar.tar" );
        exec( "bzip2 $dir/mytar.tar.gz" );
        $archive = ezcArchive::open( "$dir/mytar.tar.gz.bz2", null, new ezcArchiveOptions( array( 'readOnly' => true ) ) );

        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }

    public function testTarIncorrectBlockSizeException()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/infozip_2_textfiles.zip", "$dir/mytar.tar" );

        try
        {
            $archive = ezcArchive::open( "$dir/mytar.tar", ezcArchive::TAR_V7 );
            $entry = $archive->current();
            $this->fail( "This is not an Tar, so throw an exception" );
        }
        catch ( ezcArchiveBlockSizeException $e )
        {
        }
    }

    public function testWriteBzippedTar()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bz2' ) )
        {
            $this->markTestSkipped();
        }

        $dir = $this->getTempDir();

        try
        {
            $archive = ezcArchive::open( "compress.bzip2://$dir/mytar.tar.bz2" );

            file_put_contents( "$dir/file3.txt", "Hahaha" );
            $archive->appendToCurrent( "$dir/file3.txt", $dir );
            $this->fail( "Read only exception expected" );
        }
        catch ( ezcArchiveUnknownTypeException $e )
        {
        }
    }

    /*
    public function testWriteBzippedTarAuto()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar" );

        exec( "bzip2 $dir/mytar.tar" );
        $archive = ezcArchive::open( "$dir/mytar.tar.bz2" );

        try
        {
            file_put_contents( "$dir/file3.txt", "Hahaha" );
            $archive->appendToCurrent( "$dir/file3.txt", $dir );
            $this->fail( "Read only exception expected" );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            // Expect read-only exception.
        }
    }
     */

    /*
    public function testGzippedGzippedTar()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/tar_pax_2_textfiles.tar", "$dir/mytar.tar" );

        exec( "gzip $dir/mytar.tar" );

        rename( "$dir/mytar.tar.gz", "$dir/mytar.tar.a" );
        exec( "gzip $dir/mytar.tar.a" );
        $archive = ezcArchive::open( "$dir/mytar.tar.a.gz" );
        $archive->extract( $dir );

        clearstatcache();
        $this->assertTrue( file_exists( "$dir/file1.txt" ) );
        $this->assertTrue( file_exists( "$dir/file2.txt" ) );
    }
    */

    public function testForceUstarTar()
    {
        $dir = $this->getTempDir();

        // Filesize is smaller than the blocksize.
        copy( dirname( __FILE__ ) . "/data/infozip_2_textfiles.zip", "$dir/myzip.zip" );

        try
        {
            // File size too small.
            $archive = ezcArchive::open( "$dir/myzip.zip", ezcArchive::TAR_V7 );
            $archive->extract( $dir );
            $this->fail( "Exception expected since we cannot extract a Zip archive with the Tar handler. ");
        }
        catch ( ezcArchiveException $e )
        {
            // Okay.
        }
    }

    public function testForceUstarTarPart2()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/infozip_file_dir_symlink_link.zip", "$dir/myzip.zip");

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
        file_put_contents( "$dir/bla.txt", "Hello world" );
        file_put_contents( "$dir/bla2.txt", "Hello world2" );
        $archive->append( "$dir/bla.txt", "$dir" );
        $archive->append( "$dir/bla2.txt", "$dir" );

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

        file_put_contents( "$dir/bla.txt", "Hello world" );
        file_put_contents( "$dir/bla2.txt", "Hello world2" );
        $archive->append("$dir/bla.txt", "$dir" );
        $archive->append("$dir/bla2.txt", "$dir" );

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
    //    */

    public function testWinzipExtract()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/winzip_1_textfile.zip", "$dir/myzip.zip" );

        $archive = ezcArchive::open( "$dir/myzip.zip" );
        $archive->extract( $dir );

        $this->assertEquals( "Hello world 2!!", file_get_contents( "$dir/ray2.txt" ) );
    }

    public function testWinzipAppend()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/winzip_1_textfile.zip", "$dir/myzip.zip" );

        $archive = ezcArchive::open( "$dir/myzip.zip" );
        file_put_contents( "$dir/myfile.txt", "Hi" );
        $archive->append( "$dir/myfile.txt", $dir );

        $archive->rewind();
        $this->assertEquals( "ray2.txt", $archive->current()->getPath() );
        $this->assertEquals( "myfile.txt", $archive->next()->getPath() );

        unset( $archive );

        $archive = ezcArchive::open( "$dir/myzip.zip" );

        $this->assertEquals( "ray2.txt", $archive->current()->getPath() );
        $this->assertEquals( "myfile.txt", $archive->next()->getPath() );
    }

    public function testListing()
    {
        $archive = ezcArchive::open( dirname( __FILE__ ) . "/data/tar_pax_2_textfiles.tar" );
        $list = $archive->getListing();

        $this->assertEquals( "file1.txt", substr( $list[0], -9 ) );
        $this->assertEquals( "file2.txt", substr( $list[1], -9 ) );
    }

    public function testAppendWithWrongPrefix()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/tar_ustar_2_textfiles.tar", "$dir/mytar.tar" );
        $archive = ezcArchive::open( "$dir/mytar.tar" );

        file_put_contents( "$dir/haha.txt", "Hahahah" );

        try
        {
            $archive->append( "$dir/haha.txt", "aap" );
        }
        catch ( ezcArchiveEntryPrefixException $e )
        {
            // $this->assertEquals( ezcArchiveException::INVALID_PREFIX, $e->getCode() );
        }
    }

    public function testModifyFileTime()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/gzip-test.tar.gz", "$dir/mytar.tar.gz" );
        $before = stat( "$dir/mytar.tar.gz" );
        clearstatcache();
        sleep(2);

        $archive = ezcArchive::open( "$dir/mytar.tar.gz" );
        mkdir( $dir . '/extract' );
        foreach ( $archive as $file )
        {
            $archive->extractCurrent( 'extract' );
        }
        $after = stat( "$dir/mytar.tar.gz" );

        self::assertNotEquals( $before['ctime'], $after['ctime'] );
        self::assertNotEquals( $before['mtime'], $after['mtime'] );
    }

    public function testReadOnlyModifyFileTime()
    {
        $dir = $this->getTempDir();
        copy( dirname( __FILE__ ) . "/data/gzip-test.tar.gz", "$dir/mytar.tar.gz" );
        $before = stat( "$dir/mytar.tar.gz" );
        clearstatcache();
        sleep(2);

        $options = new ezcArchiveOptions( array( 'readOnly' => true ) );
        $archive = ezcArchive::open( "$dir/mytar.tar.gz", null, $options );
        mkdir( $dir . '/extract' );
        foreach ( $archive as $file )
        {
            $archive->extractCurrent( 'extract' );
        }
        $after = stat( "$dir/mytar.tar.gz" );

        self::assertEquals( $before['ctime'], $after['ctime'] );
        self::assertEquals( $before['mtime'], $after['mtime'] );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveBlockFileTest extends ezcTestCase
{
    public function createTempFile( $file )
    {
        $original = dirname(__FILE__) . "/../data/$file";

        $tmpDir = $this->createTempDir( "ezcArchive_" );
        $tmpFile = $tmpDir . "/temp_file.tar";
        copy( $original, $tmpFile );

        return $tmpFile;
    }

    public function testOpenFile()
    {
        $blockFile = new ezcArchiveBlockFile( dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar" );

        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ) );
    }

    public function testOpenNonExistingFile()
    {
        try
        {
            $blockFile = new ezcArchiveBlockFile( dirname(__FILE__) . "/../data/this_file_does_not_exist.tar" );
            $this->fail( "Expected a file not found exception." );
        }
        catch (ezcBaseFileNotFoundException $e)
        {
        }

        // Same test, but now with a gzipped compressed file.
        try
        {
            $blockFile = new ezcArchiveBlockFile( "compress.zlib://" . dirname( __FILE__ ) . "/../data/this_file_does_not_exist.tar.gz" );
            $this->fail( "Expected a file not found exception." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
        }
    }

    public function testCompressedStream()
    {
        $dir = $this->createTempDir( "ezcArchive_" );
        // $file =   $dir . "/blockfile";
        $file =  "compress.zlib://" . $dir . "/blockfile";

        // Create the file.
        // Blocksize = 4.
        $bf = new ezcArchiveBlockFile( $file, true, 4 );
        $this->assertFalse ($bf->valid() );

        // Exact 1 block.
        $bf->append( "abcd" );
        $this->assertTrue ($bf->valid() );
        $this->assertEquals( 0, $bf->key(), "Current block should be 0" );
        $this->assertEquals( 0, $bf->getLastBlockNumber(), "Last block should be 0" );

        // halve block.
        $bf->append( "ef" );
        $this->assertEquals( 1, $bf->key(), "Current block should be 1" );
        $this->assertEquals( 1, $bf->getLastBlockNumber(), "Last block should be 1" );

        // File should contain: abcdef\0\0
        $this->assertEquals( "abcdef\0\0", file_get_contents( $file ) );

        $bf->rewind();
        $this->assertEquals( 0, $bf->key(), "Current block should be 0");
        $this->assertEquals( "abcd" , $bf->current() );
        $this->assertTrue( $bf->valid() );
        $this->assertEquals( 1 , $bf->getLastBlockNumber() );

        try
        {
            $bf->append( "ZZ" );
            $this->fail( "Expected an exception that the block could not be appended in the middle" );
        }
        catch ( ezcArchiveException $e ) { }

        $bf->next();
        $bf->append( "ZZ" );

        $this->assertEquals( 2, $bf->key(), "Current block should be 0" );
        $this->assertEquals( "ZZ" , $bf->current() );
        $this->assertTrue( $bf->valid() );
        $this->assertEquals( 2 , $bf->getLastBlockNumber() );
    }

    /*
    public function testGzipOpenFile()
    {
        $tmpDir = $this->createTempDir( "ezcArchive_" );
        $tmpFile = $tmpDir . "/compress.zlib://my_file.gz";

        // Create a new file, and set the blocksize to 5.
        $blockFile = new ezcArchiveBlockFile( $tmpFile, true, 5 );

        $this->removeTempDir();
    }
    */

    /*
    public function testOpenReadOnlyFile()
    {
        $original =  dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar";

        $this->createTempDir( "ezcArchive_" );
        $tmpDir = $this->getTempDir();
        $readOnly = $tmpDir . "/read_only.tar";
        copy( $original, $readOnly );

        $blockFile = new ezcArchiveBlockFile( $readOnly );
        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr($data, 0, 9), "Cannot read the copied file" );
        unset( $blockFile );

        chmod( $readOnly, 0400 );

        try
        {
            $blockFile = new ezcArchiveBlockFile( $readOnly );
            $data = $blockFile->current();
            $this->assertEquals( "file1.txt", substr($data, 0, 9), "Cannot read the copied READ-ONLY file" );
            unset( $blockFile );
        }
        catch ( ezcArchiveException $e )
        {
            $this->fail( "Exception: Cannot read the copied READ-ONLY file." );
        }

        chmod( $readOnly, 0777 );
        $this->removeTempDir();
    }

    public function testOpenFileAndCreateWhenNotExist()
    {
        $tmpDir = $this->createTempDir( "ezcArchive_" );
        $file = $tmpDir . "/file_does_not_exist.tar";

        $blockFile = new ezcArchiveBlockFile( $file, true );
        $this->assertFalse( $blockFile->current() ); 
        $this->assertTrue( $blockFile->isEmpty() );

        $blockFile->append( "Appended" );

        $this->assertFalse( $blockFile->isEmpty() );
        $data = $blockFile->current();
        $this->assertEquals( "Appended", substr( $data, 0, 8 ), "Failed to append to file." );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testForEaching()
    {
        $blockFile = new ezcArchiveBlockFile( dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar" );

        $total = 0;
        foreach ( $blockFile as $blockNr => $data )
        {
            $total += $blockNr;
            $this->assertEquals( 512, strlen( $data ) );
        }

        $this->assertEquals( 190, $total, "Expected block numbers from 0 .. 19" );

        // And repeat the test.
        $total = 0;
        foreach ( $blockFile as $blockNr => $data )
        {
            $total += $blockNr;
            $this->assertEquals( 512, strlen( $data ) );
        }

        $this->assertEquals( 190, $total, "Expected block numbers from 0 .. 19" );
    }

    public function testTruncateAll()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ), "Cannot read the tmp file" );

        $blockFile->truncate();
        $blockFile->rewind();
        $this->assertFalse( $blockFile->current(), "The current block element should be false." );
        $this->assertFalse( $blockFile->next(), "No forwarding should be allowed." );
        $this->assertFalse( $blockFile->valid(), "Current element should not be valid." );
        $this->assertFalse( $blockFile->key(), "No key available" );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testTruncatePart()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->truncate(3);
        $blockFile->rewind();

        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ), "Cannot read the tmp file" );

        $blockFile->next(); // Block 2
        $this->assertTrue( $blockFile->valid() );

        $blockFile->next(); // Block 3
        $this->assertTrue( $blockFile->valid() );

        $blockFile->next(); // Should be false.
        $this->assertFalse( $blockFile->valid() );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function canWriteToReadOnlyFiles()
    {
        $dir = $this->getTempDir();
        touch( "$dir/asdfasdfasdfasdf" );
        chmod( "$dir/asdfasdfasdfasdf" , 0400 );

        $writable = is_writable( "$dir/asdfasdfasdfasdf" );

        unlink ( "$dir/asdfasdfasdfasdf" );
        return $writable;
    }

    public function testAppendReadOnlyException()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );

        chmod( $tmpFile, 0400 );

        try
        {
            $blockFile = new ezcArchiveBlockFile( $tmpFile );
            $data = $blockFile->current();
            $this->assertEquals( "file1.txt", substr( $data, 0, 9 ), "Cannot read the copied READ-ONLY file" );
        }
        catch ( ezcArchiveException $e )
        {
            $this->fail( "Exception: Cannot read the copied READ-ONLY file." );
        }

        try
        {
            // For normal users, this test should fail. However, root can still write.
            $blockFile->append( "This should fail" );

            if ( !$this->canWriteToReadOnlyFiles() )
            {
                $this->fail( "Exception expected, since it is not possible to write to a read-only file." );
            }
        }
        catch ( ezcBaseFilePermissionException $e )
        {
        }

        chmod( $tmpFile, 0777 );
        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testAppendFirstBlock()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->truncate();
        $blockFile->rewind();
        $blockFile->append( "Appended" );

        $this->assertTrue( $blockFile->valid(), "Current element should be valid." );

        // Point to the last block
        $data = $blockFile->current();
        $this->assertEquals( "Appended", substr( $data, 0, 8 ), "Failed to append to file." );

        $this->assertEquals( 0, $blockFile->key() );

        $this->assertFalse( $blockFile->next(), "Expected no more data" );
        $this->assertFalse( $blockFile->valid(), "Not valid anymore" );
        $this->assertFalse( $blockFile->current(), "No value expected" );
        $this->assertFalse( $blockFile->key(), "No key should be available" );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testAppendAfterFirstBlock()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        // Test the current file.
        $total = 0;
        foreach ( $blockFile as $blockNr => $data )
        {
            $total += $blockNr;
            $this->assertEquals( 512, strlen( $data ) );
        }

        $this->assertEquals( 190, $total, "Expected block numbers from 0 .. 19" );

        // Append after the first block.
        $blockFile->rewind();

        // First block?
        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ), "First block is wrong." );

        $blockFile->append( "My appended text" );

        $data = $blockFile->current();
        $this->assertEquals( "My appended text", substr( $data, 0, 16 ), "Appended block is wrong." );

        // Test the complete block now.
        $blockFile->rewind();

        $total = 0;
        foreach ( $blockFile as $blockNr => $data )
        {
            $total += $blockNr;
            $this->assertEquals( 512, strlen( $data ) );
        }

        $this->assertEquals( 1, $total, "Expected block numbers 0 and 1" );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testAppendAtEndOfFile()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        while ( $blockFile->next() );

        // Not valid anymore.
        $blockFile->append( "My appended text" );

        $data = $blockFile->current();
        $this->assertEquals( "My appended text", substr( $data, 0, 16 ), "Appended block is wrong." );

        // Test the complete block now.
        $blockFile->rewind();

        $total = 0;
        foreach ( $blockFile as $blockNr => $data )
        {
            $total += $blockNr;
            $this->assertEquals( 512, strlen( $data ) );
        }

        $this->assertEquals( 210, $total, "Expected block numbers 0 .. 20" );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testAppendMultipleBlocks()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->truncate();
        $blockFile->rewind();
        $blockFile->append( "Hello" );
        $blockFile->append( "World" );
        $blockFile->append( "This is the third block." );

        $blockFile->rewind();
        $total = 0;
        foreach ( $blockFile as $blockNr => $data )
        {
            $total += $blockNr;
            $this->assertEquals( 512, strlen( $data ) );
        }

        $this->assertEquals( 3, $total, "Expected block numbers 0 .. 2" );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testNullBlock()
    {
        $blockFile = new ezcArchiveBlockFile( dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar" );

        $this->assertFalse( $blockFile->isNullBlock(), "First block shouldn't be a null block." );
        $blockFile->next();
        $blockFile->next();
        $blockFile->next();
        $this->assertFalse( $blockFile->isNullBlock(), "Forth block shouldn't be a null block." );

        $blockFile->next();
        $this->assertTrue( $blockFile->isNullBlock(), "Expected a null block." );

        $blockFile->next();
        $this->assertTrue( $blockFile->isNullBlock(), "Expected a null block." );

        // Go to the end of the file.
        while ( $blockFile->next() );

        $this->assertFalse( $blockFile->valid(), "End of archive should be reached." );
        $this->assertFalse( $blockFile->isNullBlock(), "This shouldn't be a nullblock" );
    }

    public function testAppendNullBlock()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->truncate();
        $blockFile->rewind();
        $blockFile->appendNullBlock();

        $this->assertTrue( $blockFile->valid(), "Should be a null block here." );
        $this->assertTrue( $blockFile->isNullBlock(), "Should be a null block here." );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testIsEmpty()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $this->assertFalse( $blockFile->isEmpty() );
        $blockFile->append( "Blaap" );
        $this->assertFalse( $blockFile->isEmpty() );

        $blockFile->truncate(1);
        $this->assertFalse( $blockFile->isEmpty() );
        $blockFile->append( "Blaap" );
        $this->assertFalse( $blockFile->isEmpty() );

        $blockFile->truncate();
        $this->assertTrue( $blockFile->isEmpty() );

        $blockFile->rewind();
        $blockFile->append( "blaap" );
        $this->assertFalse( $blockFile->isEmpty() );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testBlockFromBytes()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $this->assertEquals( 2, $blockFile->getBlocksFromBytes( 666 ) );
        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testSeekPositions()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->seek( 2 ); // Search the third block
        $data = $blockFile->current();
        $this->assertEquals( "file2.txt", substr( $data, 0, 9 ) );
        $this->assertEquals( 2, $blockFile->key() );

        $blockFile->seek( 0 ); // Search the first block
        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ) );
        $this->assertEquals( 0, $blockFile->key() );

        $blockFile->seek( 19 ); // Search the last block
        $this->assertTrue( $blockFile->isNullBlock() );
        $this->assertFalse( $blockFile->next(), "Expected to be at the last block." );

        $blockFile->seek( -1 ); // Invalid block search.
        $this->assertFalse( $blockFile->valid() );
        $this->assertFalse( $blockFile->current() );
        $this->assertFalse( $blockFile->key() );
        $this->assertFalse( $blockFile->next(), "Should all be false" );
        $this->assertFalse( $blockFile->next(), "Should all be false" );
        $this->assertFalse( $blockFile->next(), "Should all be false" );

        // Should be valid again.
        $blockFile->seek( 2 ); // Search the third block
        $data = $blockFile->current();
        $this->assertEquals( "file2.txt", substr( $data, 0, 9 ) );
        $this->assertEquals( 2, $blockFile->key() );

        $blockFile->seek( 20 ); // Invalid block search.
        $this->assertFalse( $blockFile->valid() );
        $this->assertFalse( $blockFile->current() );
        $this->assertFalse( $blockFile->key() );
        $this->assertFalse( $blockFile->next() );
        $this->assertFalse( $blockFile->next() );
        $this->assertFalse( $blockFile->next() );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testSeekEndOfFile()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->seek( 0, SEEK_END ); // Search the last block
        $this->assertEquals( 19, $blockFile->key(), "Expected to be at the last block." );

        $this->assertTrue( $blockFile->valid(), "Last block should be valid" );
        $this->assertFalse( $blockFile->next(), "Cannot move past the last block." );
        $this->assertFalse( $blockFile->valid() );

        $blockFile->seek( -2, SEEK_END ); // Search the last block
        $this->assertEquals( 17, $blockFile->key(), "Expected to be at the 18th block." );

        $blockFile->next();
        $this->assertTrue( $blockFile->valid(), "Expected to be at the 19th block." );
        $blockFile->next();
        $this->assertTrue( $blockFile->valid(), "Expected to be at the 20th block." );
        $this->assertFalse( $blockFile->next(), "Expected to be at the end." );

        // File with no blocks.
        $blockFile->truncate();
        $blockFile->seek( 0, SEEK_END ); // Search the last block
        $this->assertFalse( $blockFile->valid(), "No block should be here." );

        // File with one block.
        $blockFile->append( "My block" );
        $blockFile->seek(0, SEEK_END ); // Should be the first and last block.

        $data = $blockFile->current();
        $this->assertEquals( "My block", substr( $data, 0, 8 ) );
        $this->assertTrue( $blockFile->valid() );

        // First block.
        $blockFile->seek( 0 );
        $data = $blockFile->current();
        $this->assertEquals( "My block", substr( $data, 0, 8 ) );
        $this->assertTrue( $blockFile->valid() );

        // Invalid block.
        $blockFile->seek( -1, SEEK_END ); // Should be the first and last block.

        $this->assertFalse( $blockFile->current() );
        $this->assertFalse( $blockFile->valid() );

        unset( $blockFile );
        $this->removeTempDir();
    }

    public function testSeekCurrentLocation()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $blockFile = new ezcArchiveBlockFile( $tmpFile );

        $blockFile->next(); // Block number: 1.
        $this->assertEquals( 1, $blockFile->key() );

        $blockFile->seek( 0, SEEK_CUR ); // Stay at the same block
        $this->assertEquals( 1, $blockFile->key() );

        $blockFile->seek( 1, SEEK_CUR ); // one block further
        $this->assertEquals( 2, $blockFile->key() );

        $data = $blockFile->current();
        $this->assertEquals( "file2.txt", substr( $data, 0, 9 ) ); 

        $blockFile->seek( -2, SEEK_CUR ); // two blocks back.
        $this->assertEquals( 0, $blockFile->key() );

        $data = $blockFile->current();
        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ) ); 

        unset( $blockFile );
        $this->removeTempDir();
    }
    */

//    public function testLastBlockNumber()
//    {
//        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
//        $blockFile = new ezcArchiveBlockFile( $tmpFile );
//
//        $this->assertEquals( -1, $blockFile->getLastBlockNumber(), "Last blocknumber supposed to be unknown" );
//
//        while ( $blockFile->next() );
//
//        $this->assertEquals( 19, $blockFile->getLastBlockNumber(), "Last blocknumber supposed to be 19. (0 .. 19)" );
//
//        $blockFile->append( "Hello" );
//        $this->assertEquals( 20, $blockFile->getLastBlockNumber() );
//
//        $blockFile->append( "Hello" );
//        $this->assertEquals( 21, $blockFile->getLastBlockNumber() );
//
//        $blockFile->truncate();
//        $blockFile->rewind();
//        $this->assertEquals( -1, $blockFile->getLastBlockNumber() );
//
//        // First block
//        $blockFile->append( "Hello" );
//        $this->assertEquals( 0, $blockFile->getLastBlockNumber() );
//        $this->assertEquals( 0, $blockFile->key() );
//
//        $blockFile->append( "Hello" );
//        $this->assertEquals( 1, $blockFile->getLastBlockNumber() );
//        $this->assertEquals( 1, $blockFile->key() );
//
//        $blockFile->rewind();
//
//        // First block
//        $blockFile->append("Hello");
//        $this->assertEquals( 1, $blockFile->getLastBlockNumber() );
//
//        /*
//        $blockFile->next(); // Block number: 1.
//        $this->assertEquals( 1, $blockFile->key() );
//
//        $blockFile->seek( 0, SEEK_CUR ); // Stay at the same block
//        $this->assertEquals( 1, $blockFile->key() );
//
//        $blockFile->seek( 1, SEEK_CUR ); // one block further
//        $this->assertEquals( 2, $blockFile->key() );
//
//        $data = $blockFile->current();
//        $this->assertEquals( "file2.txt", substr( $data, 0, 9 ) ); 
//
//        $blockFile->seek( -2, SEEK_CUR ); // two blocks back.
//        $this->assertEquals( 0, $blockFile->key() );
//
//        $data = $blockFile->current();
//        $this->assertEquals( "file1.txt", substr( $data, 0, 9 ) ); 
//
//        unset( $blockFile );
//         */
//        $this->removeTempDir();
//    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

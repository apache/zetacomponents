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
class ezcArchiveCharacterFileTest extends ezcTestCase
{
    public function testOpenFile()
    {
        $characterFile = new ezcArchiveCharacterFile( dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar" );

        $this->assertEquals( "f", $characterFile->current() );
        $this->assertEquals( "i", $characterFile->next() );
        $this->assertEquals( "l", $characterFile->next() );
        $this->assertEquals( "e", $characterFile->next() );
        $this->assertEquals( "1", $characterFile->next() );
    }

    public function testFileNotFoundException()
    {
        try
        {
            $cf = new ezcArchiveCharacterFile( dirname(__FILE__) . "/../data/this_file_does_not_exist.tar" );
            $this->fail( "Expected a file not found exception." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
        }
    }

    public function testOpenReadOnlyFile()
    {
        $original =  dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar";

        $tmpDir = $this->createTempDir( "ezcArchive_" );
        $readOnly = $tmpDir . "/read_only.tar";
        copy( $original, $readOnly );

        $cf = new ezcArchiveCharacterFile( $readOnly );

        $data = $cf->current();
        $this->assertEquals( "f", $cf->current() );

        chmod( $readOnly, 0400 );

        try
        {
            $cf = new ezcArchiveCharacterFile( $readOnly );
            $this->assertEquals( "f", $cf->current() );
        }
        catch (ezcArchiveException $e)
        {
            $this->fail( "Exception: Cannot read the copied READ-ONLY file." );
        }

        chmod( $readOnly, 0777 );
        unset( $cf );
        $this->removeTempDir();
    }

    public function testOpenFileAndCreateWhenNotExist()
    {
        $tmpDir = $this->createTempDir( "ezcArchive_" );
        $file = $tmpDir . "/file_does_not_exist.tar";

        $cf = new ezcArchiveCharacterFile( $file, true );
        $this->assertFalse( $cf->current() ); 
        $this->assertTrue( $cf->isEmpty() );

        $cf->append( "Appended" );

        $this->assertFalse( $cf->isEmpty() );
        $data = $cf->current();

        $this->assertEquals( "A", $cf->current() );
        $this->assertEquals( "p", $cf->next() );
        $this->assertEquals( "p", $cf->next() );
        $this->assertEquals( "e", $cf->next() );
        $this->assertEquals( "n", $cf->next() );
        $this->assertEquals( "d", $cf->next() );
        $this->assertEquals( "e", $cf->next() );
        $this->assertEquals( "d", $cf->next() );
        $this->assertFalse( $cf->next() );

        unset( $cf );
        $this->removeTempDir();
    }

    public function testForEaching()
    {
        $charFile = new ezcArchiveCharacterFile( dirname(__FILE__) . "/../data/tar_ustar_2_textfiles.tar" );

        $total = 0;
        foreach ( $charFile as $pos => $char )
        {
            $total++;
        }

        $this->assertEquals( 0x2800, $total, "Expected 0x27ff bytes in file." );
    }

    public function createTempFile( $file )
    {
        $original = dirname(__FILE__) . "/../data/$file";

        $tmpDir = $this->createTempDir( "ezcArchive_" );
        $tmpFile = $tmpDir . "/temp_file.tar";
        copy( $original, $tmpFile );

        return $tmpFile;
    }

    public function testTruncateAll()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        $data = $charFile->current();
        $this->assertEquals( "f", $data, "Cannot read the tmp file" );

        $charFile->truncate();
        $charFile->rewind();
        $this->assertFalse( $charFile->current(), "The current character should be false." );
        $this->assertFalse( $charFile->next(), "No forwarding should be allowed." );
        $this->assertFalse( $charFile->valid(), "Current element should not be valid." );
        $this->assertFalse( $charFile->key(), "No key available" );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testTruncatePart()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        $charFile->truncate( 3 );
        $charFile->rewind();

        $data = $charFile->current();
        $this->assertEquals( "f", $data, "Cannot read the tmp file" );

        $charFile->next(); // Char 2
        $this->assertTrue( $charFile->valid() );

        $charFile->next(); // Char 3
        $this->assertTrue( $charFile->valid() );

        $charFile->next(); // Should be false.
        $this->assertFalse( $charFile->valid() );

        unset( $charFile );
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
            $charFile = new ezcArchiveCharacterFile( $tmpFile );
            $data = $charFile->current();
            $this->assertEquals( "f", $data, "Cannot read the copied READ-ONLY file" );
        }
        catch (ezcBaseFilePermissionException $e)
        {
        }

        try
        {
            // For normal users, this test should fail. However, root can still write.
            $charFile->append( "This should fail" );

            if (!$this->canWriteToReadOnlyFiles() )
            {
                $this->fail("Exception expected, since it is not possible to write to a read-only file." );
            }
        }
        catch (ezcBaseFilePermissionException $e)
        {
        }

        chmod( $tmpFile, 0777 );
        unset( $charFile );
        $this->removeTempDir();
    }

    public function testAppendFirstBlock()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        $charFile->truncate();
        $charFile->rewind();
        $charFile->append( "A" );

        $this->assertTrue( $charFile->valid(), "Current element should be valid." );

        $data = $charFile->current();
        $this->assertEquals( "A", $data, "Failed to append to file." );

        $this->assertEquals( 0, $charFile->key() );

        $this->assertFalse( $charFile->next(), "Expected no more data" );
        $this->assertFalse( $charFile->valid(), "Not valid anymore" );
        $this->assertFalse( $charFile->current(), "No value expected" );
        $this->assertFalse( $charFile->key(), "No key should be available" );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testAppendAfterFirstBlock()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

         // Append after the first character.
        $charFile->rewind();

        // First character?
        $charFile->append( "A" );

        $data = $charFile->current();
        $this->assertEquals( "f", $data); // Original
        $this->assertEquals( "A", $charFile->next()); // New.

        $charFile->rewind();

        $total = 0;
        foreach ( $charFile as $charNr => $data )
        {
            $total++;
        }

        $this->assertEquals( 2, $total, "Expected 2 characters in the file." );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testAppendAtEndOfFile()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        while ( $charFile->next() );

        // Not valid anymore.
        $charFile->append( "Xtra" );

        $this->assertEquals( "X", $charFile->next(), "Appended character is wrong." );
        $this->assertEquals( "t", $charFile->next(), "Appended character is wrong." );
        $this->assertEquals( "r", $charFile->next(), "Appended character is wrong." );
        $this->assertEquals( "a", $charFile->next(), "Appended character is wrong." );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testIsEmpty()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        $this->assertFalse( $charFile->isEmpty() );
        $charFile->append( "Blaap" );
        $this->assertFalse( $charFile->isEmpty() );

        $charFile->truncate( 1 );
        $this->assertFalse( $charFile->isEmpty() );
        $charFile->append( "Blaap" );
        $this->assertFalse( $charFile->isEmpty() );

        $charFile->truncate();
        $this->assertTrue( $charFile->isEmpty() );

        $charFile->rewind();
        $charFile->append( "blaap" );
        $this->assertFalse( $charFile->isEmpty() );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testSeekPositions()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        $charFile->seek( 2 ); // Search the third char
        $data = $charFile->current();
        $this->assertEquals( "l", $charFile->current() );
        $this->assertEquals( 2, $charFile->key() );

        $charFile->seek( 0 ); // Search the first character
        $data = $charFile->current();
        $this->assertEquals( "f", $data );
        $this->assertEquals( 0, $charFile->key() );

        $charFile->seek( -1 ); // Invalid block search.
        $this->assertFalse( $charFile->valid() );
        $this->assertFalse( $charFile->current() );
        $this->assertFalse( $charFile->key() );
        $this->assertFalse( $charFile->next(), "Should all be false" );
        $this->assertFalse( $charFile->next(), "Should all be false" );
        $this->assertFalse( $charFile->next(), "Should all be false" );

        // Should be valid again.
        $charFile->seek( 2 ); // Search the third char
        $data = $charFile->current();
        $this->assertEquals( "l", $charFile->current() );
        $this->assertEquals( 2, $charFile->key() );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testRead()
    {
        $tmpFile = $this->createTempFile( "tar_ustar_2_textfiles.tar" );
        $charFile = new ezcArchiveCharacterFile( $tmpFile );

        $data = $charFile->read( 9 );
        $this->assertEquals( "file1.txt", $data );

        unset( $charFile );
        $this->removeTempDir();
    }

    public function testWrite()
    {
        $dir = $this->createTempDir( "ezcArchive_" );
        $file = $dir . "/myfile.txt";

        $char = new ezcArchiveCharacterFile( $file, true );
        $char->write( "ab" );
        $char->write( "cd" );

        $this->assertEquals( "abcd", file_get_contents( $file ) );

        $char->seek( 2 );
        $this->assertEquals( "c", $char->current() );
        $char->append( "De" );
        $this->assertEquals( "abcDe", file_get_contents( $file ) );

        $this->assertTrue( $char->valid() );
        $this->assertEquals( "c", $char->current() );

        $char->seek( 3 );
        $this->assertEquals( "D", $char->current() );
        $char->seek( 2 );
        $this->assertEquals( "c", $char->current() );

        $char->write( "Cde" );
        $this->assertEquals( "abCde", file_get_contents( $file ) );

        unset( $char );
        $this->removeTempDir();
    }

    // FIXME.. check also seek with a whence.

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

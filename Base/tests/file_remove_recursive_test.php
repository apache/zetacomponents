<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Base
 * @subpackage Tests
 */

/**
 * @package Base
 * @subpackage Tests
 */
class ezcBaseFileRemoveRecursiveTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->tempDir = $this->createTempDir( 'ezcBaseFileRemoveFileRecursiveTest' );
        mkdir( $this->tempDir . '/dir1' );
        mkdir( $this->tempDir . '/dir2' );
        mkdir( $this->tempDir . '/dir2/dir1' );
        mkdir( $this->tempDir . '/dir2/dir1/dir1' );
        mkdir( $this->tempDir . '/dir2/dir2' );
        mkdir( $this->tempDir . '/dir4' );
        mkdir( $this->tempDir . '/dir5' );
        mkdir( $this->tempDir . '/dir6' );
        file_put_contents( $this->tempDir . '/dir1/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir1/file2.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir1/.file3.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir2/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir2/dir1/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir2/dir1/dir1/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir2/dir1/dir1/file2.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir2/dir2/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir4/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir4/file2.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir5/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir5/file2.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir6/file1.txt', 'test' );
        file_put_contents( $this->tempDir . '/dir6/file2.txt', 'test' );
        chmod( $this->tempDir . '/dir4/file1.txt', 0 );
        chmod( $this->tempDir . '/dir5', 0 );
        chmod( $this->tempDir . '/dir6', 0400 );
    }

    protected function tearDown()
    {
        chmod( $this->tempDir . '/dir5', 0700 );
        chmod( $this->tempDir . '/dir6', 0700 );
        $this->removeTempDir();
    }

    public function testRecursive1()
    {
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
        ezcBaseFile::removeRecursive( $this->tempDir . '/dir1' );
        self::assertEquals( 9, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
        ezcBaseFile::removeRecursive( $this->tempDir . '/dir2' );
        self::assertEquals( 4, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
    }

    public function testRecursive2()
    {
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
        try
        {
            ezcBaseFile::removeRecursive( $this->tempDir . '/dir3' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            self::assertEquals( "The directory file '{$this->tempDir}/dir3' could not be found.", $e->getMessage() );
        }
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
    }

    public function testRecursive3()
    {
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
        try
        {
            ezcBaseFile::removeRecursive( $this->tempDir . '/dir4' );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            self::assertEquals( "The file '{$this->tempDir}/dir5' can not be opened for reading.", $e->getMessage() );
        }
        self::assertEquals( 10, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
    }

    public function testRecursive4()
    {
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
        try
        {
            ezcBaseFile::removeRecursive( $this->tempDir . '/dir5' );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            self::assertEquals( "The file '{$this->tempDir}/dir5' can not be opened for reading.", $e->getMessage() );
        }
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
    }

    public function testRecursive5()
    {
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
        try
        {
            ezcBaseFile::removeRecursive( $this->tempDir . '/dir6' );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            // Make no asumption on which file is tryed to be removed first
            self::assertEquals(
                1,
                preg_match(
                    "(The file '{$this->tempDir}/dir6/file[12].txt' can not be removed.)",
                    $e->getMessage()
                )
            );
        }
        self::assertEquals( 12, count( ezcBaseFile::findRecursive( $this->tempDir ) ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcBaseFileRemoveRecursiveTest" );
    }
}
?>

<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcArchiveChecksumTest extends ezcTestCase
{
    public $testString = "abcdefghijklmnopqrstuvwxyz";

    public function testTotalByteValueFromString()
    {
        $crc = ezcArchiveChecksums::getTotalByteValueFromString( $this->testString );
        $this->assertEquals( 2847, $crc );
    }

    public function testTotalByteValueFromFile()
    {
        $this->createTempDir("ezcArchive_" );
        $dir = $this->getTempDir();

        file_put_contents( "$dir/byte_value_file.txt", $this->testString );

        $byteValueExpected = ezcArchiveChecksums::getTotalByteValueFromString( file_get_contents( "$dir/byte_value_file.txt" ) );
        $byteValue = ezcArchiveChecksums::getTotalByteValueFromFile( "$dir/byte_value_file.txt" );

        $this->assertEquals( $byteValueExpected, $byteValue );
    }

    public function testCrc32FromString()
    {
        $crc = ezcArchiveChecksums::getCrc32FromString( $this->testString );
        $this->assertEquals( 1277644989, $crc );
    }

    public function testCrc32FromFile()
    {
        $this->createTempDir("ezcArchive_" );
        $dir = $this->getTempDir();

        file_put_contents( "$dir/crc32file.txt", $this->testString );

        $crcExpected = ezcArchiveChecksums::getCrc32FromString( file_get_contents( "$dir/crc32file.txt" ) );
        $crc = ezcArchiveChecksums::getCrc32FromFile( "$dir/crc32file.txt" );

        $this->assertEquals( $crcExpected, $crc);
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

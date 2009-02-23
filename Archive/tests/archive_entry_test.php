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
class ezcArchiveEntryTest extends ezcTestCase
{
    public function testEntry()
    {
        date_default_timezone_set( "UTC" );

        $tar = ezcArchiveTar::getInstance( dirname( __FILE__) . "/data/tar_ustar_complex.tar" );
        $entry = $tar->getEntry();

        $this->assertEquals("files/bla/", $entry->getPath() );
        $this->assertEquals(1129810752, $entry->getModificationTime() );
        $this->assertEquals("rb", $entry->getUserId() );
        $this->assertEquals("users", $entry->getGroupId() );
        $this->assertEquals(0, $entry->getSize() );
        $this->assertEquals("0000755", $entry->getPermissions() );
        $this->assertEquals("rwxr-xr-x", $entry->getPermissionsString() );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

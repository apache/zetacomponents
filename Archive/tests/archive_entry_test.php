<?php

class ezcArchiveEntryTest extends ezcTestCase
{

    public function testEntry()
    {
        date_default_timezone_set("UTC");
        
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
        return new ezcTestSuite("ezcArchiveEntryTest");
    }
}


?>

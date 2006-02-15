<?php
require_once( "writers/writer_database_test.php");
    
class ezcEventLogDatabaseTieinSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("EventLogDatabaseTiein");
        
        $this->addTest( ezcLogDatabaseWriterTest::suite() );
    }

    public static function suite()
    {
        return new ezcEventLogDatabaseTieinSuite();
    }
}


?>

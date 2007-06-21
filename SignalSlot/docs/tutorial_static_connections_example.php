<?php
require_once 'tutorial_autoload.php';

class DataObject
{
    private $signals = null;
    private $identifier = null;

    public function __construct( $id )
    {
        $this->identifier = $id;
    }

    public function signals()
    {
        if ( $this->signals == null ) $this->signals = new ezcSignalCollection( __CLASS__ );
        return $this->signals;
    }

    public function manipulate()
    {
        // change the data here
        $this->signals()->emit( "dataChanged", $this->identifier );
    }
}

class Cache
{
    public function deleteCache( $identifier )
    {
        echo "Deleting cache for ID: {$identifier}\n";
    }
}

$cache = new Cache();
ezcSignalStaticConnections::getInstance()->connect( "DataObject",
                                                    "dataChanged", array( $cache, "deleteCache" ) );

$data1 = new DataObject( 1 );
$data2 = new DataObject( 2 );
$data1->manipulate();
$data2->manipulate();
?>

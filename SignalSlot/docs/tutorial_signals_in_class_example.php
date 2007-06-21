<?php
require_once 'tutorial_autoload.php';

class Data
{
    private $signals = null;
    public function signals()
    {
        if ( $this->signals == null ) $this->signals = new ezcSignalCollection();
        return $this->signals;
    }

    public function manipulate()
    {
        // change the data here
        $this->signals()->emit( "dataChanged" );
    }
}

class Cache
{
    public function deleteCache()
    {
        echo "Deleting cache\n";
    }
}

$cache = new Cache();
$data = new Data();
$data->signals()->connect( "dataChanged", array( $cache, "deleteCache" ) );

$data->manipulate();
?>

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
        $this->signals()->emit( "dataChanged", "calendar" );
    }
}

class Cache
{
    public function deleteCache( $type )
    {
        echo "Deleting cache for ID: {$type}\n";
    }
}

class CacheGenerator
{
    public function generateCache( $identifier )
    {
        echo "Generating cache for ID: {$identifier}\n";
    }
}

$cache = new Cache();
$cacheGenerator = new CacheGenerator();

$data = new Data();
$data->signals()->connect( "dataChanged", array( $cache, "deleteCache" ) );
$data->signals()->connect( "dataChanged", array( $cacheGenerator, "generateCache" ) );

$data->manipulate();
?>

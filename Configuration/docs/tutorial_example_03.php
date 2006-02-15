<?php
require_once 'tutorial_autoload.php';

$writer = new ezcConfigurationArrayWriter();
$writer->init( dirname( __FILE__ ), "settings", $cfg );
$writer->save();
?>

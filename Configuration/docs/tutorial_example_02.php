<?php
require_once 'tutorial_autoload.php';

$reader = new ezcConfigurationIniReader();
$reader->init( dirname( __FILE__ ), 'settings' );

$result = $reader->validate();
foreach ( $result->getResultList() as $resultItem )
{
    print $resultItem->file . ":" . $resultItem->line . ":" . $resultItem->column. ":";
    print " " . $resultItem->details . "\n";
}

$cfg = $reader->load();
?>

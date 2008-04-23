<?php
require_once 'tutorial_autoload.php';

$reader = new ezcConfigurationIniReader();
$reader->init( dirname( __FILE__ ), 'settings' );

// validate the settings file, and loop over all the validation errors and
// warnings
$result = $reader->validate();
foreach ( $result->getResultList() as $resultItem )
{
    print $resultItem->file . ":" . $resultItem->line . ":" . $resultItem->column. ":";
    print " " . $resultItem->details . "\n";
}

// load the settings into an ezcConfiguration object
$cfg = $reader->load();
?>

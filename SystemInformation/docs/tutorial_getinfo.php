<?php
require_once 'tutorial_autoload.php';

$info = ezcSystemInfo::getInstance();
echo $info->cpuType, "\n";
echo $info->cpuSpeed, "\n";

?>

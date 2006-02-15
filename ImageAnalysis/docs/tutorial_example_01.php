<?php
require_once 'tutorial_autoload.php';
$tutorialPath = dirname( __FILE__ );

$image = new ezcImageAnalyzer( "{$tutorialPath}/img/imageanalysis_example_01.jpg" );

echo "Image has MIME type <{$image->mime}>.\n";
?>

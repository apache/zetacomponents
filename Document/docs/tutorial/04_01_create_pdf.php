<?php

require 'tutorial_autoload.php';

$document = new ezcDocumentRst();
$document->loadFile( './article/introduction.txt' );

$docbook = $document->getAsDocbook();
file_put_contents( './article/introduction.xml', $docbook );

$docbook->loadFile( './article/introduction.xml' );

$pdf = new ezcDocumentPdf();
$pdf->createFromDocbook( $docbook );

file_put_contents( __FILE__ . '.pdf', $pdf );

?>

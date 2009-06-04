<?php

require 'tutorial_autoload.php';

// Convert some input RSTfile to docbook
$document = new ezcDocumentRst();
$document->loadFile( './article/introduction.txt' );

$docbook = $document->getAsDocbook();
file_put_contents( './article/introduction.xml', $docbook );

// Load the docbook document and create a PDF from it
$docbook->loadFile( './article/introduction.xml' );

$pdf = new ezcDocumentPdf();
$pdf->createFromDocbook( $docbook );

file_put_contents( __FILE__ . '.pdf', $pdf );

?>

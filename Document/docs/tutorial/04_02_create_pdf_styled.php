<?php

require 'tutorial_autoload.php';

// Convert some input RSTfile to docbook
$document = new ezcDocumentRst();
$document->loadFile( './article/introduction.txt' );

$docbook = $document->getAsDocbook();
file_put_contents( './article/introduction.xml', $docbook );

$docbook->loadFile( './article/introduction.xml' );

// Load the docbook document and create a PDF from it
$pdf = new ezcDocumentPdf();

// Load a custom style sheet
$pdf->loadStyles( 'custom.css' );

// Add a customized footer
$pdf->registerPdfPart( new ezcDocumentPdfFooterPdfPart(
    new ezcDocumentPdfFooterOptions( array( 
        'showDocumentTitle'  => false,
        'showDocumentAuthor' => false,
        'height'             => '10mm',
    ) )
) );

// Add a customized header
$pdf->registerPdfPart( new ezcDocumentPdfHeaderPdfPart(
    new ezcDocumentPdfFooterOptions( array( 
        'showPageNumber'     => false,
        'height'             => '10mm',
    ) )
) );

$pdf->createFromDocbook( $docbook );
file_put_contents( __FILE__ . '.pdf', $pdf );

?>

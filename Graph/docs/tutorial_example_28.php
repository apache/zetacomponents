<?php

require_once 'tutorial_autoload.php';

$graph = new ezcGraphPieChart();
$graph->palette = new ezcGraphPaletteEz();
$graph->title = 'Access statistics';

$graph->data['Access statistics'] = new ezcGraphArrayDataSet( array(
    'Mozilla' => 19113,
    'Explorer' => 10917,
    'Opera' => 1464,
    'Safari' => 652,
    'Konqueror' => 474,
) );

$graph->render( 400, 200, 'tutorial_example_28.svg' );

// Get element references from renderer
$elements = $graph->renderer->getElementReferences();

// Add links to charts
$dom = new DOMDocument();
$dom->load( 'tutorial_example_28.svg' );
$xpath = new DomXPath( $dom );

// Link chart elements
foreach( $elements['data']['Access statistics'] as $objectName => $ids )
{
    foreach( $ids as $id )
    {
        echo "Link: $id\n";
        $element = $xpath->query( '//*[@id = \'' . $id . '\']' )->item( 0 );

        $element->setAttribute( 'style', $element->getAttribute( 'style' ) . ' cursor: pointer;' );
        $element->setAttribute( 'onclick', 'top.location = \'/detailedData.php?browser=' . $objectName . '\'' );
    }
}

// Link legend elements
foreach( $elements['legend'] as $objectName => $ids )
{
    foreach( $ids as $id )
    {
        echo "Link: $id\n";
        $element = $xpath->query( '//*[@id = \'' . $id . '\']' )->item( 0 );

        $element->setAttribute( 'style', $element->getAttribute( 'style' ) . ' cursor: pointer;' );
        $element->setAttribute( 'onclick', 'top.location = \'/detailedData.php?browser=' . $objectName . '\'' );
    }
}

$dom->save( 'tutorial_example_28.svg' );

?>

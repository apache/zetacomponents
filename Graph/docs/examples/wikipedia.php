<?php

require 'Base/src/base.php';
function __autoload( $className )
{
        ezcBase::autoload( $className );
}

// Create the graph
$graph = new ezcGraphPieChart();

// Add the data and hilight norwegian data set
$graph->data['articles'] = new ezcGraphArrayDataSet( array(
    'English' => 1300000,
    'Germany' => 452000,
    'Netherlands' => 217000,
    'Norway' => 70000,
) );
$graph->data['articles']->highlight['Norway'] = true;

// Set graph title
$graph->title = 'Articles by country';

// Modify pie chart label to only show amount and percent
$graph->options->label = '%2$d (%3$.1f%%)';

// Use 3d renderer, and beautify it
$graph->renderer = new ezcGraphRenderer3d();
$graph->renderer->options->pieChartShadowSize = 12;
$graph->renderer->options->pieChartGleam = .5;
$graph->renderer->options->dataBorder = false;
$graph->renderer->options->pieChartHeight = 16;
$graph->renderer->options->legendSymbolGleam = .5;
$graph->renderer->options->pieChartOffset = 100;

// Output the graph with std SVG driver
$graph->render( 500, 200, 'wiki_graph.svg' );

?>

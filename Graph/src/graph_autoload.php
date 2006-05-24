<?php
/**
 * Autoloader definition for the ezcGraph component.
 *
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Graph
 */

return array(
    'ezcGraph'                                  => 'Graph/graph.php',
    'ezcGraphUnknownChartTypeException'         => 'Graph/exceptions/unknown_chart_type.php',
    
    'ezcGraphChart'                             => 'Graph/interfaces/chart.php',
    'ezcGraphPieChart'                          => 'Graph/charts/pie.php',
    'ezcGraphLineChart'                         => 'Graph/charts/line.php',
    'ezcGraphChartOptions'                      => 'Graph/options/chart.php',
    'ezcGraphInvalidImageFileException'         => 'Graph/exceptions/invalid_image_file.php',

    'ezcGraphColor'                             => 'Graph/structs/color.php',
    'ezcGraphUnknownColorDefinitionException'   => 'Graph/exceptions/unknown_color_definition.php',

    'ezcGraphRenderer'                          => 'Graph/interfaces/renderer.php',
    'ezcGraphRenderer2D'                        => 'Graph/renderer/2d.php',
    'ezcGraphRenderer3D'                        => 'Graph/renderer/3d.php',
    'ezcGraphInvalidRendererException'          => 'Graph/exceptions/invalid_renderer.php',

    'ezcGraphDriver'                            => 'Graph/interfaces/driver.php',
    'ezcGraphGDDriver'                          => 'Graph/driver/gd.php',
    'ezcGraphSVGDriver'                         => 'Graph/driver/svg.php',
    'ezcGraphInvalidDriverException'            => 'Graph/exceptions/invalid_driver.php',

    'ezcGraphChartElement'                      => 'Graph/interfaces/element.php',
    'ezcGraphChartElementText'                  => 'Graph/element/text.php',
    'ezcGraphChartElementLegend'                => 'Graph/element/legend.php',
    'ezcGraphChartElementAxis'                  => 'Graph/element/axis.php',
    'ezcGraphChartElementNumericAxis'           => 'Graph/axis/numeric_axis.php',
    'ezcGraphChartElementLabeledAxis'           => 'Graph/axis/labeled_axis.php',

    'ezcGraphDataset'                           => 'Graph/datasets/base.php',
    'ezcGraphDatasetAverage'                    => 'Graph/datasets/average.php',
    'ezcGraphDatasetProperty'                   => 'Graph/interfaces/dataset_property.php',
    'ezcGraphDatasetColorProperty'              => 'Graph/datasets/property/color.php',
    'ezcGraphDatasetStringProperty'             => 'Graph/datasets/property/string.php',
    'ezcGraphDatasetIntProperty'                => 'Graph/datasets/property/integer.php',
    'ezcGraphNoSuchDataException'               => 'Graph/exceptions/no_such_data.php',
    'ezcGraphNoSuchDatasetException'            => 'Graph/exceptions/no_such_dataset.php',
    'ezcGraphTooManyDatasetsExceptions'         => 'Graph/exceptions/too_many_datasets.php',
    'ezcGraphUnknownDatasetSourceException'     => 'Graph/exceptions/unknown_dataset_source.php',

    'ezcGraphBoundings'                         => 'Graph/structs/boundings.php',
    'ezcGraphCoordinate'                        => 'Graph/structs/coordinate.php',
);

?>

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
    'ezcGraphException'                         => 'Graph/exceptions/exception.php',
    'ezcGraphUnknownChartTypeException'         => 'Graph/exceptions/unknown_chart_type.php',
    
    'ezcGraphChart'                             => 'Graph/interfaces/chart.php',
    'ezcGraphPieChart'                          => 'Graph/charts/pie.php',
    'ezcGraphLineChart'                         => 'Graph/charts/line.php',
    'ezcGraphChartOptions'                      => 'Graph/options/chart.php',
    'ezcGraphPieChartOptions'                   => 'Graph/options/pie_chart.php',
    'ezcGraphLineChartOptions'                  => 'Graph/options/line_chart.php',
    'ezcGraphInvalidImageFileException'         => 'Graph/exceptions/invalid_image_file.php',

    'ezcGraphColor'                             => 'Graph/structs/color.php',
    'ezcGraphUnknownColorDefinitionException'   => 'Graph/exceptions/unknown_color_definition.php',

    'ezcGraphRenderer'                          => 'Graph/interfaces/renderer.php',
    'ezcGraphRenderer2d'                        => 'Graph/renderer/2d.php',
    'ezcGraphRenderer2dOptions'                 => 'Graph/options/renderer_2d.php',
    'ezcGraphRenderer3d'                        => 'Graph/renderer/3d.php',
    'ezcGraphRenderer3dOptions'                 => 'Graph/options/renderer_3d.php',
    'ezcGraphInvalidRendererException'          => 'Graph/exceptions/invalid_renderer.php',

    'ezcGraphAxisLabelRenderer'                 => 'Graph/interfaces/axis_label_renderer.php',
    'ezcGraphAxisNoLabelRenderer'               => 'Graph/renderer/axis_label_none.php',
    'ezcGraphAxisExactLabelRenderer'            => 'Graph/renderer/axis_label_exact.php',
    'ezcGraphAxisCenteredLabelRenderer'         => 'Graph/renderer/axis_label_centered.php',

    'ezcGraphDriver'                            => 'Graph/interfaces/driver.php',
    'ezcGraphDriverOptions'                     => 'Graph/options/driver.php',
    'ezcGraphGdDriver'                          => 'Graph/driver/gd.php',
    'ezcGraphGdDriverOptions'                   => 'Graph/options/gd_driver.php',
    'ezcGraphGdDriverInvalidFontException'      => 'Graph/exceptions/invalid_font.php',
    'ezcGraphGdDriverUnsupportedImageTypeException' => 'Graph/exceptions/unsupported_image_type.php',
    'ezcGraphSvgDriver'                         => 'Graph/driver/svg.php',
    'ezcGraphSvgDriverOptions'                  => 'Graph/options/svg_driver.php',
    'ezcGraphInvalidDriverException'            => 'Graph/exceptions/invalid_driver.php',
    'ezcGraphVerboseDriver'                     => 'Graph/driver/verbose.php',

    'ezcGraphPalette'                           => 'Graph/interfaces/palette.php',
    'ezcGraphPaletteTango'                      => 'Graph/palette/tango.php',
    'ezcGraphPaletteBlack'                      => 'Graph/palette/black.php',
    'ezcGraphUnknownPaletteException'           => 'Graph/exceptions/unknown_palette.php',

    'ezcGraphChartElement'                      => 'Graph/interfaces/element.php',
    'ezcGraphNoSuchElementException'            => 'Graph/exceptions/no_such_element.php',
    'ezcGraphFontOptions'                       => 'Graph/options/font.php',
    'ezcGraphChartElementText'                  => 'Graph/element/text.php',
    'ezcGraphChartElementLegend'                => 'Graph/element/legend.php',
    'ezcGraphChartElementBackgroundImage'       => 'Graph/element/background.php',
    'ezcGraphChartElementAxis'                  => 'Graph/element/axis.php',
    'ezcGraphChartElementNumericAxis'           => 'Graph/axis/numeric.php',
    'ezcGraphChartElementLabeledAxis'           => 'Graph/axis/labeled.php',

    'ezcGraphDataSet'                           => 'Graph/datasets/base.php',
    'ezcGraphDataSetAverage'                    => 'Graph/datasets/average.php',
    'ezcGraphDataSetProperty'                   => 'Graph/interfaces/dataset_property.php',
    'ezcGraphDataSetColorProperty'              => 'Graph/datasets/property/color.php',
    'ezcGraphDataSetStringProperty'             => 'Graph/datasets/property/string.php',
    'ezcGraphDataSetIntProperty'                => 'Graph/datasets/property/integer.php',
    'ezcGraphDataSetBooleanProperty'            => 'Graph/datasets/property/boolean.php',
    'ezcGraphNoSuchDataException'               => 'Graph/exceptions/no_such_data.php',
    'ezcGraphNoSuchDataSetException'            => 'Graph/exceptions/no_such_dataset.php',
    'ezcGraphTooManyDataSetsExceptions'         => 'Graph/exceptions/too_many_datasets.php',
    'ezcGraphUnknownDataSetSourceException'     => 'Graph/exceptions/unknown_dataset_source.php',

    'ezcGraphBoundings'                         => 'Graph/structs/boundings.php',
    'ezcGraphCoordinate'                        => 'Graph/structs/coordinate.php',
);

?>

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
    
    'ezcGraphChart'                             => 'Graph/interfaces/chart.php',
    'ezcGraphPieChart'                          => 'Graph/charts/pie.php',
    'ezcGraphLineChart'                         => 'Graph/charts/line.php',
    'ezcGraphBarChart'                          => 'Graph/charts/bar.php',
    'ezcGraphChartOptions'                      => 'Graph/options/chart.php',
    'ezcGraphPieChartOptions'                   => 'Graph/options/pie_chart.php',
    'ezcGraphLineChartOptions'                  => 'Graph/options/line_chart.php',
    'ezcGraphInvalidImageFileException'         => 'Graph/exceptions/invalid_image_file.php',

    'ezcGraphChartDataContainer'                => 'Graph/data_container/base.php',
    'ezcGraphChartSingleDataContainer'          => 'Graph/data_container/single.php',

    'ezcGraphColor'                             => 'Graph/colors/color.php',
    'ezcGraphLinearGradient'                    => 'Graph/colors/linear_gradient.php',
    'ezcGraphRadialGradient'                    => 'Graph/colors/radial_gradient.php',
    'ezcGraphUnknownColorDefinitionException'   => 'Graph/exceptions/unknown_color_definition.php',

    'ezcGraphRenderer'                          => 'Graph/interfaces/renderer.php',
    'ezcGraphRendererOptions'                   => 'Graph/options/renderer.php',
    'ezcGraphRenderer2d'                        => 'Graph/renderer/2d.php',
    'ezcGraphRenderer2dOptions'                 => 'Graph/options/renderer_2d.php',
    'ezcGraphRenderer3d'                        => 'Graph/renderer/3d.php',
    'ezcGraphRenderer3dOptions'                 => 'Graph/options/renderer_3d.php',

    'ezcGraphAxisLabelRenderer'                 => 'Graph/interfaces/axis_label_renderer.php',
    'ezcGraphAxisNoLabelRenderer'               => 'Graph/renderer/axis_label_none.php',
    'ezcGraphAxisExactLabelRenderer'            => 'Graph/renderer/axis_label_exact.php',
    'ezcGraphAxisCenteredLabelRenderer'         => 'Graph/renderer/axis_label_centered.php',
    'ezcGraphAxisBoxedLabelRenderer'            => 'Graph/renderer/axis_label_boxed.php',

    'ezcGraphDriver'                            => 'Graph/interfaces/driver.php',
    'ezcGraphFontRenderingException'            => 'Graph/exceptions/font_rendering.php',
    'ezcGraphUnknownFontTypeException'          => 'Graph/exceptions/font_type.php',
    'ezcGraphInvalidFontTypeException'          => 'Graph/exceptions/invalid_font.php',
    'ezcGraphDriverOptions'                     => 'Graph/options/driver.php',
    'ezcGraphGdDriver'                          => 'Graph/driver/gd.php',
    'ezcGraphGdDriverOptions'                   => 'Graph/options/gd_driver.php',
    'ezcGraphGdDriverUnsupportedImageTypeException' => 'Graph/exceptions/unsupported_image_type.php',
    'ezcGraphSvgDriver'                         => 'Graph/driver/svg.php',
    'ezcGraphSvgDriverOptions'                  => 'Graph/options/svg_driver.php',
    'ezcGraphSvgDriverInvalidIdException'       => 'Graph/exceptions/invalid_id.php',
    'ezcGraphVerboseDriver'                     => 'Graph/driver/verbose.php',
    'ezcGraphFlashDriver'                       => 'Graph/driver/flash.php',
    'ezcGraphFlashDriverOptions'                => 'Graph/options/flash_driver.php',
    'ezcGraphFlashBitmapTypeException'          => 'Graph/exceptions/flash_bitmap_type.php',
    'ezcGraphFlashBitmapBoundingsException'     => 'Graph/exceptions/flash_bitmap_boundings.php',

    'ezcGraphPalette'                           => 'Graph/interfaces/palette.php',
    'ezcGraphPaletteTango'                      => 'Graph/palette/tango.php',
    'ezcGraphPaletteBlack'                      => 'Graph/palette/black.php',
    'ezcGraphPaletteEzBlue'                     => 'Graph/palette/ez_blue.php',
    'ezcGraphPaletteEzGreen'                    => 'Graph/palette/ez_green.php',
    'ezcGraphPaletteEzRed'                      => 'Graph/palette/ez_red.php',
    'ezcGraphPaletteEz'                         => 'Graph/palette/ez.php',

    'ezcGraphChartElement'                      => 'Graph/interfaces/element.php',
    'ezcGraphNoSuchElementException'            => 'Graph/exceptions/no_such_element.php',
    'ezcGraphFontOptions'                       => 'Graph/options/font.php',
    'ezcGraphChartElementText'                  => 'Graph/element/text.php',
    'ezcGraphChartElementLegend'                => 'Graph/element/legend.php',
    'ezcGraphChartElementBackground'            => 'Graph/element/background.php',
    'ezcGraphChartElementAxis'                  => 'Graph/element/axis.php',
    'ezcGraphChartElementDateAxis'              => 'Graph/axis/date.php',
    'ezcGraphChartElementNumericAxis'           => 'Graph/axis/numeric.php',
    'ezcGraphChartElementLabeledAxis'           => 'Graph/axis/labeled.php',
    'ezcGraphChartElementLogarithmicalAxis'     => 'Graph/axis/logarithmic.php',
    'ezcGraphOutOfLogithmicalBoundingsException' => 'Graph/exceptions/out_of_logarithmical_boundings.php',

    'ezcGraphDataSet'                           => 'Graph/datasets/base.php',
    'ezcGraphArrayDataSet'                      => 'Graph/datasets/array.php',
    'ezcGraphDataSetAveragePolynom'             => 'Graph/datasets/average.php',
    'ezcGraphDatasetAverageInvalidKeysException' => 'Graph/exceptions/invalid_keys.php',
    'ezcGraphDataSetProperty'                   => 'Graph/interfaces/dataset_property.php',
    'ezcGraphDataSetColorProperty'              => 'Graph/datasets/property/color.php',
    'ezcGraphDataSetStringProperty'             => 'Graph/datasets/property/string.php',
    'ezcGraphDataSetIntProperty'                => 'Graph/datasets/property/integer.php',
    'ezcGraphDataSetBooleanProperty'            => 'Graph/datasets/property/boolean.php',
    'ezcGraphNoSuchDataException'               => 'Graph/exceptions/no_such_data.php',
    'ezcGraphNoSuchDataSetException'            => 'Graph/exceptions/no_such_dataset.php',
    'ezcGraphTooManyDataSetsExceptions'         => 'Graph/exceptions/too_many_datasets.php',
    'ezcGraphInvalidDisplayTypeException'       => 'Graph/exceptions/invalid_display_type.php',

    'ezcGraphMatrix'                            => 'Graph/math/matrix.php',
    'ezcGraphMatrixInvalidDimensionsException'  => 'Graph/exceptions/invalid_dimensions.php',
    'ezcGraphMatrixOutOfBoundingsException'     => 'Graph/exceptions/out_of_boundings.php',
    'ezcGraphPolynom'                           => 'Graph/math/polynom.php',
    'ezcGraphBoundings'                         => 'Graph/math/boundings.php',

    'ezcGraphCoordinate'                        => 'Graph/structs/coordinate.php',
    'ezcGraphContext'                           => 'Graph/structs/context.php',
);

?>

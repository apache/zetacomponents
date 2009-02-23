<?php
/**
 * Autoloader definition for the ImageAnalysis component.
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ImageAnalysis
 */

return array(
    'ezcImageAnalyzerException'                   => 'ImageAnalysis/exceptions/exception.php',
    'ezcImageAnalyzerFileNotProcessableException' => 'ImageAnalysis/exceptions/file_not_processable.php',
    'ezcImageAnalyzerInvalidHandlerException'     => 'ImageAnalysis/exceptions/invalid_handler.php',
    'ezcImageAnalyzerHandler'                     => 'ImageAnalysis/interfaces/handler.php',
    'ezcImageAnalyzer'                            => 'ImageAnalysis/analyzer.php',
    'ezcImageAnalyzerData'                        => 'ImageAnalysis/structs/analyzer_data.php',
    'ezcImageAnalyzerImagemagickHandler'          => 'ImageAnalysis/handlers/imagemagick.php',
    'ezcImageAnalyzerPhpHandler'                  => 'ImageAnalysis/handlers/php.php',
);
?>

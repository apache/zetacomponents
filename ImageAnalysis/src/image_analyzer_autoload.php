<?php
/**
 * Autoload map for ImageAnalysis package.
 *
 * @package ImageAnalysis
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

return array (
    'ezcImageAnalyzer'                              => 'ImageAnalysis/analyzer.php',
    'ezcImageAnalyzerData'                          => 'ImageAnalysis/structs/analyzer_data.php',
    'ezcImageAnalyzerHandler'                       => 'ImageAnalysis/interfaces/handler.php',
    'ezcImageAnalyzerPhpHandler'                    => 'ImageAnalysis/handlers/php.php',
    'ezcImageAnalyzerImagemagickHandler'            => 'ImageAnalysis/handlers/imagemagick.php',
    
    'ezcImageAnalyzerException'                     => 'ImageAnalysis/exceptions/exception.php',
    'ezcImageAnalyzerFileNotProcessableException'   => 'ImageAnalysis/exceptions/file_not_processable.php',
    'ezcImageAnalyzerInvalidHandlerException'       => 'ImageAnalysis/exceptions/invalid_handler.php',
);

?>

<?php
/**
 * Autoloader definition for the Translation component.
 *
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

return array(
    'ezcTranslationBackend'               => 'Translation/interfaces/backend_interface.php',
    'ezcTranslationFilter'                => 'Translation/interfaces/filter_interface.php',
    'ezcTranslationContextWrite'          => 'Translation/interfaces/context_write_interface.php',
    'ezcTranslationContextRead'           => 'Translation/interfaces/context_read_interface.php',
    'ezcTranslationManager'               => 'Translation/translation_manager.php',
    'ezcTranslation'                      => 'Translation/translation.php',
    'ezcTranslationComplementEmptyFilter' => 'Translation/filters/complement_filter.php',
    'ezcTranslationBorkFilter'            => 'Translation/filters/bork_filter.php',
    'ezcTranslationLeetFilter'            => 'Translation/filters/leet_filter.php',
    'ezcTranslationTsBackend'             => 'Translation/backends/ts_backend.php',
    'ezcTranslationData'                  => 'Translation/structs/translation_data.php',

    'ezcTranslationException'                       => 'Translation/exceptions/exception.php',
    'ezcTranslationContextNotAvailableException'    => 'Translation/exceptions/context_not_available.php',
    'ezcTranslationKeyNotAvailableException'        => 'Translation/exceptions/key_not_available.php',
    'ezcTranslationMissingTranslationFileException' => 'Translation/exceptions/missing_translation_file.php',
    'ezcTranslationNotConfiguredException'          => 'Translation/exceptions/not_configured.php',
    'ezcTranslationParameterMissingException'       => 'Translation/exceptions/parameter_missing.php',
    'ezcTranslationReaderNotInitializedException'   => 'Translation/exceptions/reader_not_initialized.php',
    'ezcTranslationWriterNotInitializedException'   => 'Translation/exceptions/writer_not_initialized.php',
);
?>

<?php
/**
 * Autoloader definition for the Translation component.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

return array(
    'ezcTranslationException'                       => 'Translation/exceptions/exception.php',
    'ezcTranslationContextNotAvailableException'    => 'Translation/exceptions/context_not_available.php',
    'ezcTranslationKeyNotAvailableException'        => 'Translation/exceptions/key_not_available.php',
    'ezcTranslationMissingTranslationFileException' => 'Translation/exceptions/missing_translation_file.php',
    'ezcTranslationNotConfiguredException'          => 'Translation/exceptions/not_configured.php',
    'ezcTranslationParameterMissingException'       => 'Translation/exceptions/parameter_missing.php',
    'ezcTranslationReaderNotInitializedException'   => 'Translation/exceptions/reader_not_initialized.php',
    'ezcTranslationWriterNotInitializedException'   => 'Translation/exceptions/writer_not_initialized.php',
    'ezcTranslationBackend'                         => 'Translation/interfaces/backend_interface.php',
    'ezcTranslationContextRead'                     => 'Translation/interfaces/context_read_interface.php',
    'ezcTranslationFilter'                          => 'Translation/interfaces/filter_interface.php',
    'ezcTranslation'                                => 'Translation/translation.php',
    'ezcTranslationBorkFilter'                      => 'Translation/filters/bork_filter.php',
    'ezcTranslationComplementEmptyFilter'           => 'Translation/filters/complement_filter.php',
    'ezcTranslationContextWrite'                    => 'Translation/interfaces/context_write_interface.php',
    'ezcTranslationData'                            => 'Translation/structs/translation_data.php',
    'ezcTranslationLeetFilter'                      => 'Translation/filters/leet_filter.php',
    'ezcTranslationManager'                         => 'Translation/translation_manager.php',
    'ezcTranslationTsBackend'                       => 'Translation/backends/ts_backend.php',
    'ezcTranslationTsBackendOptions'                => 'Translation/options/ts_backend.php',
);
?>

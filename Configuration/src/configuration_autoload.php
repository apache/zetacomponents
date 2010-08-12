<?php
/**
 * Autoloader definition for the Configuration component.
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
 * @package Configuration
 */

return array(
    'ezcConfigurationException'                      => 'Configuration/exceptions/exception.php',
    'ezcConfigurationGroupExistsAlreadyException'    => 'Configuration/exceptions/group_exists_already.php',
    'ezcConfigurationInvalidReaderClassException'    => 'Configuration/exceptions/invalid_reader_class.php',
    'ezcConfigurationInvalidSuffixException'         => 'Configuration/exceptions/invalid_suffix.php',
    'ezcConfigurationManagerNotInitializedException' => 'Configuration/exceptions/manager_no_init.php',
    'ezcConfigurationNoConfigException'              => 'Configuration/exceptions/no_config.php',
    'ezcConfigurationNoConfigObjectException'        => 'Configuration/exceptions/no_config_object.php',
    'ezcConfigurationParseErrorException'            => 'Configuration/exceptions/parse_error.php',
    'ezcConfigurationReadFailedException'            => 'Configuration/exceptions/read_failed.php',
    'ezcConfigurationSettingWrongTypeException'      => 'Configuration/exceptions/setting_wrong_type.php',
    'ezcConfigurationSettingnameNotStringException'  => 'Configuration/exceptions/settingname_not_string.php',
    'ezcConfigurationUnknownConfigException'         => 'Configuration/exceptions/unknown_config.php',
    'ezcConfigurationUnknownGroupException'          => 'Configuration/exceptions/unknown_group.php',
    'ezcConfigurationUnknownSettingException'        => 'Configuration/exceptions/unknown_setting.php',
    'ezcConfigurationWriteFailedException'           => 'Configuration/exceptions/write_failed.php',
    'ezcConfigurationReader'                         => 'Configuration/interfaces/reader.php',
    'ezcConfigurationWriter'                         => 'Configuration/interfaces/writer.php',
    'ezcConfigurationFileReader'                     => 'Configuration/file_reader.php',
    'ezcConfigurationFileWriter'                     => 'Configuration/file_writer.php',
    'ezcConfiguration'                               => 'Configuration/configuration.php',
    'ezcConfigurationArrayReader'                    => 'Configuration/array/array_reader.php',
    'ezcConfigurationArrayWriter'                    => 'Configuration/array/array_writer.php',
    'ezcConfigurationIniItem'                        => 'Configuration/structs/ini_item.php',
    'ezcConfigurationIniParser'                      => 'Configuration/ini/ini_parser.php',
    'ezcConfigurationIniReader'                      => 'Configuration/ini/ini_reader.php',
    'ezcConfigurationIniWriter'                      => 'Configuration/ini/ini_writer.php',
    'ezcConfigurationManager'                        => 'Configuration/configuration_manager.php',
    'ezcConfigurationValidationItem'                 => 'Configuration/structs/validation_item.php',
    'ezcConfigurationValidationResult'               => 'Configuration/validation_result.php',
);
?>

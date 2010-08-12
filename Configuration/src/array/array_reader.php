<?php
/**
 * File containing the ezcConfigurationArrayReader class
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
 * @package Configuration
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * This class provides functionality for reading files containing specific PHP
 * arrays into ezcConfiguration objects.
 *
 * The file it reads from must be a PHP file containing the group and comments
 * (if enabled).
 *
 * A typical usage is to create the reader object and pass the filepath in the
 * constructor:
 * <code>
 * $reader = new ezcConfigurationArrayReader( "settings/site.php" );
 * $reader->load();
 * </code>
 * That makes the class figure out the location and name values automatically.
 *
 * Or generally use the init() function:
 * <code>
 * $reader = new ezcConfigurationArrayReader();
 * $reader->init( "settings", "site" );
 * $reader->load();
 * </code>
 *
 * Accessing the configuration object is done by the getConfig() method or by
 * using the return value of load():
 * <code>
 * $conf1 = $reader->load();
 * $conf2 = $reader->getConfig();
 * // $conf1 and $conf2 points to the same object
 * </code>
 *
 * If caching is employed the getTimestamp() method can be used to find the last
 * modification time of the file.
 * <code>
 * $time = $reader->getTimestamp();
 * if ( $time > $cachedTime )
 * {
 *    $reader->load();
 * }
 * </code>
 *
 * Instead of loading the PHP file it can be validated with validate(), this will
 * return an ezcConfigurationValidationResult which can be inspected and
 * presented to the end user. As the array format can never have any parse
 * errors per line, the validation result will always be empty.
 * <code>
 * $result = $reader->validate();
 * if ( !$result->isValid )
 * {
 *    foreach ( $result->getResultList() as $resultItem )
 *    {
 *        // ...
 *    }
 * }
 * </code>
 *
 * For more information on file based configurations see {@link
 * ezcConfigurationFileReader}.
 *
 * This class uses exceptions and will throw them when the conditions for the
 * operation fails somehow.
 *
 * Files are required to have the suffix .php, as this allows PHP accelerators
 * to cache the content for even faster retrieval.
 *
 * @package Configuration
 * @version //autogen//
 * @mainclass
 */
class ezcConfigurationArrayReader extends ezcConfigurationFileReader
{
    /**
     * Returns the suffix used in the storage filename.
     *
     * @return string
     */
    protected function getSuffix()
    {
        return 'php';
    }

    /**
     * Loads the current config object
     *
     * Loads the current config object from a given location which can later be
     * stored with a ezcConfigurationWriter.
     *
     * @see config()
     *
     * @throws ezcConfigurationNoConfigException if there is no config
     *         object to be read from the location.
     * @throws ezcConfigurationInvalidSuffix if the current
     *         location values cannot be used for reading.
     * @throws ezcConfigurationReadFailedException if the configuration
     *         could not be read from the given location.
     *
     * @return ezcConfiguration
     */
    public function load()
    {
        $data = include $this->path;

        $this->config = new ezcConfiguration( $data['settings'], $data['comments'] );
        return $this->config;
    }

    /**
     * Validates the configuration
     *
     * Validates the configuration at the given location and returns the validation
     * result.
     *
     * @param bool $strict Controls how strict the validation is. If set to
     *             true it will not validate the file if it contains any errors
     *             or warnings. If false it will allow warnings but not errors.
     * @return ezcConfigurationValidationResult
     */
    public function validate( $strict = false )
    {
        $validationResult = new ezcConfigurationValidationResult( $this->location, $this->name, $this->path );
        return $validationResult;
    }
}
?>

<?php
/**
 * File containing the ezcConfigurationArrayWriter class
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
 * This class provides functionality for writing ezcConfiguration object into
 * files containing PHP arrays.
 *
 * The file it writes to will be a PHP file containing the group and comments
 * (if enabled).
 *
 * A typical usage is to create the writer object and pass the filepath in the
 * constructor:
 * <code>
 * $writer = new ezcConfigurationArrayWriter( "settings/site.php" );
 * $writer->setConfig( $configurationObject );
 * $writer->save();
 * </code>
 * That makes the class figure out the location and name values automatically.
 *
 * Or generally use the init() function:
 * <code>
 * $writer = new ezcConfigurationArrayWriter();
 * $writer->init( "settings", "site", $configurationObject );
 * $writer->save();
 * </code>
 *
 * For more information on file based configurations see {@link
 * ezcConfigurationFileWriter}.
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
class ezcConfigurationArrayWriter extends ezcConfigurationFileWriter
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
     * Writes the settings and comments to disk
     *
     * This method loops over all groups and settings and write those to disk.
     * For the settings itself it will call writeSetting() which also detects
     * arrays and handles those recursively.
     *
     * @param resource $fp The filepointer of the file to write
     * @param array $settings The structure containing settings
     * @param array $comments The structure containing the comments for the
     *                        settings
     */
    protected static function writeSettings( $fp, $settings, $comments = array() )
    {
        fwrite( $fp, "<?php\n" );
        $serializedSettings = var_export( array( 'settings' => $settings, 'comments' => $comments ), true );
        fwrite( $fp, 'return ' . $serializedSettings . ";\n" );
        fwrite( $fp, "?>\n" );
    }
}
?>

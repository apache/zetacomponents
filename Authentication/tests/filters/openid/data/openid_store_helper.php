<?php
/**
 * File containing the ezcAuthenticationOpenidFileStoreHelper class.
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
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Class which exposes the protected functions from ezcAuthenticationOpenidFileStore
 * and contains other needed methods for OpenID file store tests.
 *
 * For testing purposes only.
 *
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationOpenidFileStoreHelper extends ezcAuthenticationOpenidFileStore
{
    /**
     * Returns the filenames from a provided path.
     *
     * @param string $path The path to return the filenames from
     * @return array(string)
     */
    public static function getFiles( $path )
    {
        $result = array();
        if ( $fh = opendir( $path ) )
        {
            while ( ( $file = readdir( $fh ) ) !== false )
            {
                $result[] = $file;
            }
            closedir( $fh );
        }
        return $result;
    }

    /**
     * Creates a valid filename from the provided string.
     *
     * @param string $value A string which needs to be used as a valid filename
     * @return string
     */
    public function convertToFilename( $value )
    {
        return parent::convertToFilename( $value );
    }
}
?>

<?php
/**
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
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveTestData
{
    protected $tempDir;
    protected $dataDir;
    protected $extension;
    protected $version;

    protected $usedFiles = array();
    public function __construct( $dataDir, $tempDir, $extension, $version )
    {
        $this->tempDir = $tempDir;
        $this->dataDir = $dataDir;
        $this->extension = $extension;
        $this->version = $version;
    }

    public function createTempFile( $file )
    {
        $original = dirname(__FILE__) . "/../data/$file";

        $tmpFile = $this->getTempDir() . "/$file";
        copy( $original, $tmpFile );

        return $tmpFile;
    }

    public function getFileName( $type )
    {
        $file = $this->version . "_$type." . $this->extension;

        if ( isset( $this->usedFiles[$file] ) )
        {
            return $file;
        }

        $this->usedFiles[$file] = true;
        copy( $this->dataDir . "/" . $file, $this->tempDir . "/" . $file );

        return $this->tempDir . "/" . $file;
    }

    public function getCharFile( $type )
    {
        return new ezcArchiveCharacterFile ( $this->getFileName ( $type ) );
    }

    public function getArchive( $type )
    {
        // FIXME, zip only.
        return new ezcArchiveZip( $this->getCharFile( $type ) );
    }

    public function getNewCharFile( $type )
    {
        return new ezcArchiveCharacterFile ( $type, true );
    }

    public function getNewArchive( $type )
    {
        return new ezcArchiveZip( $this->getNewCharFile( $type ) );
    }
}
?>

<?php
/**
 * File containing the ezcDbSchemaPhpArrayWriter class.
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
 * @package DatabaseSchema
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Writer handler for files containing PHP arrays that represent DB schemas.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaPhpArrayWriter implements ezcDbSchemaFileWriter, ezcDbSchemaDiffFileWriter
{
    /**
     * Returns what type of schema writer this class implements.
     *
     * This method always returns ezcDbSchema::FILE
     *
     * @return int
     */
    public function getWriterType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Returns what type of schema difference writer this class implements.
     *
     * This method always returns ezcDbSchema::FILE
     *
     * @return int
     */
    public function getDiffWriterType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Saves the schema definition in $schema to the file $file.
     * @todo throw exception when file can not be opened
     *
     * @param string      $file
     * @param ezcDbSchema $dbSchema
     */
    public function saveToFile( $file, ezcDbSchema $dbSchema )
    {
        $schema = $dbSchema->getSchema();
        $data = $dbSchema->getData();
        
        $fileData = '<?php return '. var_export( array( $schema, $data ), true ) . '; ?>';
        if ( ! @file_put_contents( $file, (string) $fileData ) )
        {
            throw new ezcBaseFilePermissionException( $file, ezcBaseFileException::WRITE );
        }
    }

    /**
     * Saves the differences in $schemaDiff to the file $file
     * @todo throw exception when file can not be opened
     *
     * @param string          $file
     * @param ezcDbSchemaDiff $dbSchemaDiff
     */
    public function saveDiffToFile( $file, ezcDbSchemaDiff $dbSchemaDiff )
    {
        $fileData = '<?php return '. var_export( $dbSchemaDiff, true ) . '; ?>';
        if ( ! @file_put_contents( $file, (string) $fileData ) )
        {
            throw new ezcBaseFilePermissionException( $file, ezcBaseFileException::WRITE );
        }
    }
}
?>

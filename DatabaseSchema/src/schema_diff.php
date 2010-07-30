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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * ezcDbSchemaDiff is the main class for schema differences operations.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @mainclass
 */
class ezcDbSchemaDiff
{
    /**
     * All added tables
     *
     * @var array(string=>ezcDbSchemaTable)
     */
    public $newTables;

    /**
     * All changed tables
     *
     * @var array(string=>ezcDbSchemaTableDiff)
     */
    public $changedTables;

    /**
     * All removed tables
     *
     * @var array(string=>bool)
     */
    public $removedTables;

    /**
     * Constructs an ezcDbSchemaDiff object.
     *
     * @param array(string=>ezcDbSchemaTable)      $newTables
     * @param array(string=>ezcDbSchemaTableDiff)  $changedTables
     * @param array(string=>bool)                  $removedTables
     */
    public function __construct( $newTables = array(), $changedTables = array(), $removedTables = array() )
    {
        $this->newTables = $newTables;
        $this->changedTables = $changedTables;
        $this->removedTables = $removedTables;
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaDiff(
             $array['newTables'], $array['changedTables'], $array['removedTables']
        );
    }

    /**
     * Checks whether the object in $obj implements the correct $type of reader handler.
     *
     * @throws ezcDbSchemaInvalidReaderClassException if the object in $obj is
     *         not a schema reader of the correct type.
     *
     * @param ezcDbSchemaReader $obj
     * @param int               $type
     */
    static private function checkSchemaDiffReader( $obj, $type )
    {
        if ( !( ( $obj->getDiffReaderType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidReaderClassException( get_class( $obj ), $type );
        }
    }

    /**
     * Factory method to create a ezcDbSchemaDiff object from the file $file with the format $format.
     *
     * @throws ezcDbSchemaInvalidReaderClassException if the handler associated
     *         with the $format is not a file schema reader.
     *
     * @param string $format
     * @param string $file
     * @return ezcDbSchemaDiff
     */
    static public function createFromFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getDiffReaderByFormat( $format );
        $reader = new $className();
        self::checkSchemaDiffReader( $reader, ezcDbSchema::FILE );
        return $reader->loadDiffFromFile( $file );
    }

    /**
     * Checks whether the object in $obj implements the correct $type of writer handler.
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the object in $obj is
     *         not a schema writer of the correct type.
     *
     * @param ezcDbSchemaWriter $obj
     * @param int               $type
     */
    static private function checkSchemaDiffWriter( $obj, $type )
    {
        if ( !( ( $obj->getDiffWriterType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidWriterClassException( get_class( $obj ), $type );
        }
    }

    /**
     * Writes the schema differences to the file $file in format $format.
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the handler associated
     *         with the $format is not a file schema writer.
     *
     * @param string $format
     * @param string $file
     */
    public function writeToFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getDiffWriterByFormat( $format );
        $reader = new $className();
        self::checkSchemaDiffWriter( $reader, ezcDbSchema::FILE );
        $reader->saveDiffToFile( $file, $this );
    }

    /**
     * Upgrades the database $db with the differences.
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the handler associated
     *         with the $format is not a database schema writer.
     *
     * @param ezcDbHandler $db
     */
    public function applyToDb( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getDiffWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaDiffWriter( $writer, ezcDbSchema::DATABASE );
        $writer->applyDiffToDb( $db, $this );
    }

    /**
     * Returns the $db specific SQL queries that would update the database $db
     *
     * The database type can be given as both a database handler (instanceof
     * ezcDbHandler) or the name of the database as string as retrieved through
     * calling getName() on the database handler object.
     *
     * @see ezcDbHandler::getName()
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the handler associated
     *         with the $format is not a database schema writer.
     *
     * @param string|ezcDbHandler $db
     * @return array(string)
     */
    public function convertToDDL( $db )
    {
        if ( $db instanceof ezcDbHandler )
        {
            $db = $db->getName();
        }
        $className = ezcDbSchemaHandlerManager::getDiffWriterByFormat( $db );
        $writer = new $className();
        self::checkSchemaDiffWriter( $writer, ezcDbSchema::DATABASE );
        return $writer->convertDiffToDDL( $this );
    }
}
?>

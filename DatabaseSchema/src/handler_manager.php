<?php
/**
 * File containing the ezcDbSchemaHandlerManager class.
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
 * Deals with schema handlers for a ezcDbSchema object.
 *
 * Determines which handlers to use for the specified storage type.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @mainclass
 */
class ezcDbSchemaHandlerManager
{
    /**
     * Set of standard read handlers.
     *
     * The property is an array where the key is the name of the format and the
     * value the classname that implements the read handler.
     *
     * @var array(string=>string)
     */
    static public $readHandlers = array(
        'array' => 'ezcDbSchemaPhpArrayReader',
        'mysql' => 'ezcDbSchemaMysqlReader',
        'oracle' => 'ezcDbSchemaOracleReader',
        'pgsql' => 'ezcDbSchemaPgsqlReader',
        'sqlite' => 'ezcDbSchemaSqliteReader',
        'xml' => 'ezcDbSchemaXmlReader',
    );

    /**
     * Set of standard write handlers.
     *
     * The property is an array where the key is the name of the format and the
     * value the classname that implements the write handler.
     *
     * @var array(string=>string)
     */
    static public $writeHandlers = array(
        'array' => 'ezcDbSchemaPhpArrayWriter',
        'mysql' => 'ezcDbSchemaMysqlWriter',
        'oracle' => 'ezcDbSchemaOracleWriter',
        'pgsql' => 'ezcDbSchemaPgsqlWriter',
        'sqlite' => 'ezcDbSchemaSqliteWriter',
        'xml' => 'ezcDbSchemaXmlWriter',
        'persistent' => 'ezcDbSchemaPersistentWriter',
    );

    /**
     * Set of standard difference read handlers.
     *
     * The property is an array where the key is the name of the format and the
     * value the classname that implements the read handler.
     *
     * @var array(string=>string)
     */
    static public $diffReadHandlers = array(
        'array' => 'ezcDbSchemaPhpArrayReader',
        'xml' => 'ezcDbSchemaXmlReader',
    );

    /**
     * Set of standard difference write handlers.
     *
     * The property is an array where the key is the name of the format and the
     * value the classname that implements the write handler.
     *
     * @var array(string=>string)
     */
    static public $diffWriteHandlers = array(
        'array' => 'ezcDbSchemaPhpArrayWriter',
        'mysql' => 'ezcDbSchemaMysqlWriter',
        'oracle' => 'ezcDbSchemaOracleWriter',
        'pgsql' => 'ezcDbSchemaPgsqlWriter',
        'sqlite' => 'ezcDbSchemaSqliteWriter',
        'xml' => 'ezcDbSchemaXmlWriter',
    );

    /**
     * Returns the class name of the read handler for format $format.
     *
     * @param string $format
     * @return string
     */
    static public function getReaderByFormat( $format )
    {
        if ( !isset( self::$readHandlers[$format] ) )
        {
            throw new ezcDbSchemaUnknownFormatException( $format, 'read' );
        }
        return self::$readHandlers[$format];
    }

    /**
     * Returns the class name of the write handler for format $format.
     *
     * @param string $format
     * @return string
     */
    static public function getWriterByFormat( $format )
    {
        if ( !isset( self::$writeHandlers[$format] ) )
        {
            throw new ezcDbSchemaUnknownFormatException( $format, 'write' );
        }
        return self::$writeHandlers[$format];
    }

    /**
     * Returns the class name of the differences read handler for format $format.
     *
     * @param string $format
     * @return string
     */
    static public function getDiffReaderByFormat( $format )
    {
        if ( !isset( self::$diffReadHandlers[$format] ) )
        {
            throw new ezcDbSchemaUnknownFormatException( $format, 'difference read' );
        }
        return self::$diffReadHandlers[$format];
    }

    /**
     * Returns the class name of the differences write handler for format $format.
     *
     * @param string $format
     * @return string
     */
    static public function getDiffWriterByFormat( $format )
    {
        if ( !isset( self::$diffWriteHandlers[$format] ) )
        {
            throw new ezcDbSchemaUnknownFormatException( $format, 'difference write' );
        }
        return self::$diffWriteHandlers[$format];
    }

    /**
     * Returns list of schema types supported by all known handlers.
     *
     * Goes through the list of known handlers and gathers information of which
     * schema types do they support.
     *
     * @return array
     */
    static public function getSupportedFormats()
    {
        return array_keys( array_merge ( self::$readHandlers, self::$writeHandlers ) );
    }

    /**
     * Returns list of schema types supported by all known difference handlers.
     *
     * Goes through the list of known difference handlers and gathers
     * information of which schema types do they support.
     *
     * @return array
     */
    static public function getSupportedDiffFormats()
    {
        return array_keys( array_merge( self::$diffReadHandlers, self::$diffWriteHandlers ) );
    }

    /**
     * Adds the read handler class $readerClass to the manager for $type
     *
     * @throws ezcDbSchemaInvalidReaderClassException if the $readerClass
     *         doesn't exist or doesn't extend the abstract class
     *         ezcDbSchemaReader.
     * @param string $type
     * @param string $readerClass
     */
    static public function addReader( $type, $readerClass )
    {
        // Check if the passed classname actually exists
        if ( !ezcBaseFeatures::classExists( $readerClass, true ) )
        {
            throw new ezcDbSchemaInvalidReaderClassException( $readerClass );
        }

        // Check if the passed classname actually implements the interface.
        if ( !in_array( 'ezcDbSchemaReader', class_implements( $readerClass ) ) )
        {
            throw new ezcDbSchemaInvalidReaderClassException( $readerClass );
        }
        self::$readHandlers[$type] = $readerClass;
    }

    /**
     * Adds the write handler class $writerClass to the manager for $type
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the $writerClass
     *         doesn't exist or doesn't extend the abstract class
     *         ezcDbSchemaWriter.
     * @param string $type
     * @param string $writerClass
     */
    static public function addWriter( $type, $writerClass )
    {
        // Check if the passed classname actually exists
        if ( !ezcBaseFeatures::classExists( $writerClass, true ) )
        {
            throw new ezcDbSchemaInvalidWriterClassException( $writerClass );
        }

        // Check if the passed classname actually implements the interface.
        if ( !in_array( 'ezcDbSchemaWriter', class_implements( $writerClass ) ) )
        {
            throw new ezcDbSchemaInvalidWriterClassException( $writerClass );
        }
        self::$writeHandlers[$type] = $writerClass;
    }

    /**
     * Adds the difference read handler class $readerClass to the manager for $type
     *
     * @throws ezcDbSchemaInvalidReaderClassException if the $readerClass
     *         doesn't exist or doesn't extend the abstract class
     *         ezcDbSchemaDiffReader.
     * @param string $type
     * @param string $readerClass
     */
    static public function addDiffReader( $type, $readerClass )
    {
        // Check if the passed classname actually exists
        if ( !ezcBaseFeatures::classExists( $readerClass, true ) )
        {
            throw new ezcDbSchemaInvalidDiffReaderClassException( $readerClass );
        }

        // Check if the passed classname actually implements the interface.
        if ( !in_array( 'ezcDbSchemaDiffReader', class_implements( $readerClass ) ) )
        {
            throw new ezcDbSchemaInvalidDiffReaderClassException( $readerClass );
        }
        self::$diffReadHandlers[$type] = $readerClass;
    }

    /**
     * Adds the difference write handler class $writerClass to the manager for $type
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the $writerClass
     *         doesn't exist or doesn't extend the abstract class
     *         ezcDbSchemaDiffWriter.
     * @param string $type
     * @param string $writerClass
     */
    static public function addDiffWriter( $type, $writerClass )
    {
        // Check if the passed classname actually exists
        if ( !ezcBaseFeatures::classExists( $writerClass, true ) )
        {
            throw new ezcDbSchemaInvalidDiffWriterClassException( $writerClass );
        }

        // Check if the passed classname actually implements the interface.
        if ( !in_array( 'ezcDbSchemaDiffWriter', class_implements( $writerClass ) ) )
        {
            throw new ezcDbSchemaInvalidDiffWriterClassException( $writerClass );
        }
        self::$diffWriteHandlers[$type] = $writerClass;
    }
}
?>

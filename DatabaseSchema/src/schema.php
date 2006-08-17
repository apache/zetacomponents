<?php
/**
 * File containing the ezcDbSchema class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcDbSchema is the main class for schema operations.
 *
 * ezcDbSchema represents the schema itself and provide proxy methods to the
 * handlers that are able to load/save schemas from/to files, databases or other
 * sources/destinations, depending on available schema handlers.
 *
 * A database schema is a definition of all the tables inside a database,
 * including field definitions and indexes.
 * @see ezcDbSchemaTable ezcDbSchemaField ezcDbSchemaIndex 
 * @see ezcDbSchemaIndexField.
 *
 * The available builtin handlers are currently for MySQL, XML files and PHP 
 * arrays.
 *
 * The following example shows you how you can load a database schema
 * from the PHP format and store it into the XML format.
 * <code>
 *     $schema = ezcDbSchema::createFromFile( 'array', 'file.php' );
 *     $schema->writeToFile( 'xml', 'file.xml' );
 * </code>
 *
 * The following example shows how you can load a database schema
 * from the XML format and store it into a database.
 * <code>
 *     $db = ezcDbFactory::create( 'mysql://user:password@host/database' );
 *     $schema = ezcDbSchema::createFromFile( 'xml', 'file.php' );
 *     $schema->writeToDb( $db );
 * </code>
 *
 * Example that shows how to make a comparison between a file on disk and a
 * database, and how to apply the changes.
 * <code>
 *     $xmlSchema = ezcDbSchema::createFromFile( 'xml', 'wanted-schema.xml' );
 *     $dbSchema = ezcDbSchema::createFromDb( $db );
 *     $diff = ezcDbSchemaComparator::compareSchemas( $xmlSchema, $dbSchema );
 *     $diff->applyToDb( $db );
 * </code>
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @mainclass
 */
class ezcDbSchema
{
    /**
     * Used by reader and writer classes to inform that it implements a file
     * based handler.
     */
    const FILE = 1;

    /**
     * Used by reader and writer classes to inform that it implements a
     * database based handler.
     */
    const DATABASE = 2;

    /**
     * Stores the schema information.
     *
     * @var array(string=>ezcDbSchemaTable)
     */
    private $schema;

    /**
     * Meant to store data - not currently in use
     *
     * @var array
     */
    private $data;

    /**
     * A list of all the supported database filed types
     *
     * @var array(string)
     */
    static public $supportedTypes = array(
        'integer', 'boolean', 'float', 'decimal', 'timestamp', 'time', 'date',
        'text', 'blob', 'clob'
    );

    /**
     * Constructs a new ezcDbSchema object with schema definition $schema.
     *
     * @param array(ezcDbSchemaTable) $schema
     * @param array                   $data
     */
    public function __construct( array $schema, $data = array() )
    {
        $this->schema = $schema;
        $this->data = $data;
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
    static private function checkSchemaReader( ezcDbSchemaReader $obj, $type )
    {
        if ( !( ( $obj->getReaderType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidReaderClassException( get_class( $obj ), $type );
        }
    }

    /**
     * Factory method to create a ezcDbSchema object from the file $file with the format $format.
     *
     * @throws ezcDbSchemaInvalidReaderClassException if the handler associated
     *         with the $format is not a file schema reader.
     *
     * @param string $format
     * @param string $file
     */
    static public function createFromFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getReaderByFormat( $format );
        $reader = new $className();
        self::checkSchemaReader( $reader, self::FILE );
        return $reader->loadFromFile( $file );
    }

    /**
     * Factory method to create a ezcDbSchema object from the database $db.
     *
     * @throws ezcDbSchemaInvalidReaderClassException if the handler associated
     *         with the $format is not a database schema reader.
     *
     * @param ezcDbHandler $db
     */
    static public function createFromDb( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getReaderByFormat( $db->getName() );
        $reader = new $className();
        self::checkSchemaReader( $reader, self::DATABASE );
        return $reader->loadFromDb( $db );
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
    static private function checkSchemaWriter( $obj, $type )
    {
        if ( !( ( $obj->getWriterType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidWriterClassException( get_class( $obj ), $type );
        }
    }

    /**
     * Writes the schema to the file $file in format $format.
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the handler associated
     *         with the $format is not a file schema writer.
     *
     * @param string $format
     * @param string $file
     */
    public function writeToFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getWriterByFormat( $format );
        $reader = new $className();
        self::checkSchemaWriter( $reader, self::FILE );
        $reader->saveToFile( $file, $this );
    }

    /**
     * Creates the tables defined in the schema into the database specified through $db.
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the handler associated
     *         with the $format is not a database schema writer.
     *
     * @param ezcDbHandler $db
     */
    public function writeToDb( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaWriter( $writer, self::DATABASE );
        $writer->saveToDb( $db, $this );
    }

    /**
     * Returns the $db specific SQL queries that would create the tables defined in the schema.
     *
     * @throws ezcDbSchemaInvalidWriterClassException if the handler associated
     *         with the $format is not a database schema writer.
     *
     * @param ezcDbHandler $db
     * @return array(string)
     */
    public function convertToDDL( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaWriter( $writer, self::DATABASE );
        return $writer->convertToDDL( $this );
    }

    /**
     * Returns the internal schema.
     *
     * @return array(string=>ezcDbSchemaTable)
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Returns the internal data.
     *
     * This data is not used anywhere though.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
?>

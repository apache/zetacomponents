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
 * ezcDbSchema represents the schema itself and has the
 * ability to load/save schema from/to files, databases or other
 * sources/destinations, depending on available schema handlers.
 *
 * @todo what is a database schema
 * @todo what are the available built in types
 *
 * The following example shows you how you can load a database schema
 * from the PHP format and store it into the XML format.
 * <code>
 *     $schema = ezcDbSchema::createFromFile( 'array', 'file.php' );
 *     $schema->writeToFile( 'xml', 'file.xml' );
 * </code>
 *
 * The following example shows you how you can load a database schema
 * from the XML format and store it into the database.
 * <code>
 *     $db = ezcDbFactory::create( 'mysql://user:password@host/database' );
 *     $schema = ezcDbSchema::createFromFile( 'xml', 'file.php' );
 *     $schema->writeToDb( $db );
 * </code>
 *
 * @todo Example, create SQL diff between file on disk and database. Apply patch.
 *
 * A more complex example:
 * @todo This example is cryptic to me. What does it explain?
 * <code>
 *  class MyAppSchema extends ezcDbSchema { ... }
 *
 *  $schema1 = new MyAppSchema;
 *  $schema2 = new MyAppSchema;
 *
 *  $schema1->load( 'file1.xml', 'xml-file' );
 *  $schema2->load( $db, 'oracle-db' );
 *
 *  $diff = $schema1->compare( $schema2 );
 *  $schema1->saveDelta( $diff, 'delta.sql', 'mysql-file' );
 *
 *  $schema2->save( 'schema2.sql', 'oracle-file' );
 * </code>
 *
 * @package DatabaseSchema
 */

class ezcDbSchema
{
    const FILE = 1;
    const DATABASE = 2;

    private $schema;
    private $data;

    static public $supportedTypes = array(
        'integer', 'boolean', 'float', 'decimal', 'timestamp', 'time', 'date',
        'text', 'blob', 'clob'
    );

    public function __construct( array $schema, $data = array() )
    {
        $this->schema = $schema;
        $this->data = $data;
    }

    static private function checkSchemaReader( $obj, $type )
    {
        if ( !( ( $obj->getReaderType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidReaderClassException( get_class( $obj ), $type );
        }
    }

    static public function createFromFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getReaderByFormat( $format );
        $reader = new $className();
        self::checkSchemaReader( $reader, self::FILE );
        return $reader->loadFromFile( $file );
    }

    static public function createFromDb( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getReaderByFormat( $db->getName() );
        $reader = new $className();
        self::checkSchemaReader( $reader, self::DATABASE );
        return $reader->loadFromDb( $db );
    }


    static private function checkSchemaWriter( $obj, $type )
    {
        if ( !( ( $obj->getWriterType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidWriterClassException( get_class( $obj ), $type );
        }
    }

    public function writeToFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getWriterByFormat( $format );
        $reader = new $className();
        self::checkSchemaWriter( $reader, self::FILE );
        $reader->saveToFile( $file, $this );
    }

    public function writeToDb( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaWriter( $writer, self::DATABASE );
        $writer->saveToDb( $db, $this );
    }

    public function convertToDDL( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaWriter( $writer, self::DATABASE );
        return $writer->convertToDDL( $this );
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function getData()
    {
        return $this->data;
    }
}
?>

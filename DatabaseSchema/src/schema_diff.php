<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store schema difference information in.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaDiff
{
    const FILE = 1;
    const DATABASE = 2;

    /**
     * All added tables
     *
     * @var array(string=>ezcDbSchemaTable)
     */
    public $newTables;

    /**
     * All changed tables
     *
     * @var array(string=>array)
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
    function __construct( $newTables = array(), $changedTables = array(), $removedTables = array() )
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

    static private function checkSchemaDiffReader( $obj, $type )
    {
        if ( !( ( $obj->getDiffReaderType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidReaderClassException( get_class( $obj ), $type );
        }
    }

    static public function createFromFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getDiffReaderByFormat( $format );
        $reader = new $className();
        self::checkSchemaDiffReader( $reader, self::FILE );
        return $reader->loadDiffFromFile( $file );
    }


    static private function checkSchemaDiffWriter( $obj, $type )
    {
        if ( !( ( $obj->getDiffWriterType() & $type ) == $type ) )
        {
            throw new ezcDbSchemaInvalidWriterClassException( get_class( $obj ), $type );
        }
    }

    public function writeToFile( $format, $file )
    {
        $className = ezcDbSchemaHandlerManager::getDiffWriterByFormat( $format );
        $reader = new $className();
        self::checkSchemaDiffWriter( $reader, self::FILE );
        $reader->saveDiffToFile( $file, $this );
    }

    public function applyToDb( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getDiffWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaDiffWriter( $writer, self::DATABASE );
        $writer->applyDiffToDb( $db, $this );
    }

    public function convertToDDL( ezcDbHandler $db )
    {
        $className = ezcDbSchemaHandlerManager::getDiffWriterByFormat( $db->getName() );
        $writer = new $className();
        self::checkSchemaDiffWriter( $writer, self::DATABASE );
        return $writer->convertDiffToDDL( $this );
    }

}
?>

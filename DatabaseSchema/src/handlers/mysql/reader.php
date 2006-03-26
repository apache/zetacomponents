<?php
/**
 * File containing the ezcDbSchemaMysqlReader class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for files containing PHP arrays that represent DB schema.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaMysqlReader implements ezcDbSchemaDbReader
{
    static private $typeMap = array(
        'tinyint' => 'integer',
        'smallint' => 'integer',
        'mediumint' => 'integer',
        'int' =>  'integer',
        'bigint' => 'integer',
        'integer' => 'integer',
        'bool' => 'boolean',
        'boolean' => 'boolean',
        'float' => 'float',
        'double' => 'float',
        'dec' => 'decimal',
        'numeric' => 'decimal',
        'fixed' => 'decimal',
        
        'date' => 'date',
        'datetime' => 'timestamp',
        'timestamp' => 'timestamp',
        'time' => 'time',
        'year' => 'integer',
       
        'char' => 'text',
        'varchar' => 'text',
        'binary' => 'blob',
        'varbinary' => 'blob',
        'tinyblob' => 'blob',
        'blob' => 'blob',
        'mediumblob' => 'blob',
        'longblob' => 'blob',
        'tinytext' => 'clob',
        'text' => 'clob',
        'mediumtext' => 'clob',
        'longtext' => 'clob',
    );
            
            
    /**
     * This handler supports loading schema
     * from XML files.
     */
    public function getReaderType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Load schema from a .xml file.

     * @returns ezcDbSchema
     */
    public function loadFromDb( ezcDbHandler $db )
    {
        $this->db = $db;
        return new ezcDbSchema( $this->fetchSchema() );
    }

    private function fetchSchema()
    {
        $schemaDefinition = array();

        $tables = $this->db->query( "SHOW TABLES" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $fields  = $this->fetchTableFields( $tableName );
            $indexes = $this->fetchTableIndexes( $tableName );

            $schemaDefinition[$tableName] = new ezcDbSchemaTable( $fields, $indexes );
        }

        return $schemaDefinition;
    }

    /**
     * Fetch fields definition for the given table.
     *
     * @param ezcDbHandler $db    Database to use.
     * @param string       $table Table to fetch fields from.
     */
    private function fetchTableFields( $tableName )
    {
        $fields = array();

        $resultArray = $this->db->query( "DESCRIBE $tableName" );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );

        foreach ( $resultArray as $row )
        {
            $fieldLength = false;
            $fieldType = self::convertToGenericType( $row['type'], $fieldLength, $fieldPrecision );
            if ( !$fieldLength )
            {
                $fieldLength = false;
            }

            $fieldNotNull = false;
            if ( $row['null'][0] != 'Y' )
            {
                $fieldNotNull = true;
            }

            $fieldDefault = null;

            $fieldAutoIncrement = false;
            if ( strstr ( $row['extra'], 'auto_increment' ) !== false )
            {
                $fieldAutoIncrement = true;
            }

            // FIXME: unsigned needs to be implemented
            $fieldUnsigned = false;

            $fields[$row['field']] = new ezcDbSchemaField( $fieldType, $fieldLength, $fieldNotNull, $fieldDefault, $fieldAutoIncrement, $fieldUnsigned );
        }

        return $fields;
    }

    /**
     * Extracts length/precision information from mysql type.
     *
     * @param string $typeString      A string like "float(5,10)"
     * @param ref    $typeLength    Used to return field length.
     * @param ref    $typePrecision Used to return field precision.
     * @return string type name.
     */
    static function convertToGenericType( $typeString, &$typeLength, &$typePrecision )
    {
        preg_match( "@([a-z]*)(\((\d*)(,(\d+))?\))?@", $typeString, $matches );
        $genericType = self::$typeMap[$matches[1]];

        if ( in_array( $genericType, array( 'text', 'decimal', 'float' ) ) && isset( $matches[3] ) )
        {
            $typeLength = $matches[3];
            if ( is_numeric( $typeLength ) )
            {
                $typeLength = (int) $typeLength;
            }
        }
        if ( in_array( $genericType, array( 'decimal', 'float' ) ) && isset( $matches[5] ) )
        {
            $typePrecision = $matches[5];
        }

        return $genericType;
    }

    private function isNumericType( $type )
    {
        $types = array( 'float', 'int' );
        return in_array( $type, $types );
    }

    private function isStringType( $type )
    {
        $types = array( 'tinytext', 'text', 'mediumtext', 'longtext' );
        return in_array( $type, $types );
    }

    private function isBlobType( $type )
    {
        $types = array( 'varchar', 'char' );
        return in_array( $type, $types );
    }


    /**
     * Fetches all indexes from a database along with their schema.
     * @return array(mixed)  Indexes schema.
     */
    private function fetchTableIndexes( $tableName )
    {
        $indexBuffer = array();

        $resultArray = $this->db->query( "SHOW INDEX FROM $tableName" );
        
        foreach ( $resultArray as $row )
        {
            $keyName = $row['key_name'];
            if ( $keyName == 'PRIMARY' )
            {
                $keyName = 'primary';
            }

            $indexBuffer[$keyName]['primary'] = false;
            $indexBuffer[$keyName]['unique'] = true;

            if ( $keyName == 'primary' )
            {
                $indexBuffer[$keyName]['primary'] = true;
                $indexBuffer[$keyName]['unique'] = true;
            }
            else
            {
                $indexBuffer[$keyName]['unique'] = $row['non_unique'] ? false : true;
            }

            $indexBuffer[$keyName]['fields'][$row['column_name']] = new ezcDbSchemaIndexField();

//            if ( $row['sub_part'] )
//            {
//                $indexBuffer[$keyName]['options']['limitations'][$row['column_name']] = $row['sub_part'];
//            }
        }

        $indexes = array();

        foreach ( $indexBuffer as $indexName => $indexInfo )
        {
            $indexes[$indexName] = new ezcDbSchemaIndex( $indexInfo['fields'], $indexInfo['primary'], $indexInfo['unique'] );
        }

        return $indexes;
    }

}
?>

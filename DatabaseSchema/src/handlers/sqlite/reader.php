<?php
/**
 * File containing the ezcDbSchemaSqliteReader class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for SQLite connections representing a DB schema.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaSqliteReader implements ezcDbSchemaDbReader
{
    /**
     * Contains a type map from SQLITE native types to generic DbSchema types.
     *
     * @var array
     */
    static private $typeMap = array(
        'integer' => 'integer',
        'real' => 'float',
        'text' => 'text',
        'blob' => 'blob',
    );
            
            
    /**
     * Returns what type of schema reader this class implements.
     *
     * This method always returns ezcDbSchema::DATABASE
     *
     * @return int
     */
    public function getReaderType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Returns a ezcDbSchema object from the database that is referenced with $db.
     *
     * @param ezcDbHandler $db
     * @return ezcDbSchema
     */
    public function loadFromDb( ezcDbHandler $db )
    {
        $this->db = $db;
        return new ezcDbSchema( $this->fetchSchema() );
    }

    /**
     * Loops over all the tables in the database and extracts schema information.
     *
     * This method extracts information about a database's schema from the
     * database itself and returns this schema as an ezcDbSchema object.
     *
     * @return ezcDbSchema
     */
    private function fetchSchema()
    {
        $schemaDefinition = array();

        $tables = $this->db->query( "SELECT NAME FROM sqlite_master WHERE type='table' AND name != 'sqlite_sequence'" )->fetchAll();
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
     * Fetch fields definition for the table $tableName
     *
     * This method loops over all the fields in the table $tableName and
     * returns an array with the field specification. The key in the returned
     * array is the name of the field.
     *
     * @param string $tableName
     * @return array(string=>ezcDbSchemaField)
     */
    private function fetchTableFields( $tableName )
    {
        $fields = array();

        $resultArray = $this->db->query( "PRAGMA TABLE_INFO( $tableName )" );
        $resultArray->setFetchMode( PDO::FETCH_NUM );

        foreach ( $resultArray as $row )
        {
            $fieldLength = false;
            $fieldPrecision = null;
            $fieldType = self::convertToGenericType( $row[2], $fieldLength, $fieldPrecision );

            $fieldNotNull = false;
            if ( $row[2] == '99' )
            {
                $fieldNotNull = true;
            }

            $fieldDefault = null;
            if ( $row[3] != '' )
            {
                $fieldNotNull = $row[3];
            }

            $fieldAutoIncrement = false;
            $autoIncrementResult = $this->db->query( "SELECT * FROM sqlite_master WHERE tbl_name = '$tableName' AND name LIKE 'sqlite_autoindex_$tableName_%" );
            if ( count( $autoIncrementResult ) > 0 )
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
     * Converts the native MySQL type in $typeString to a generic DbSchema type.
     *
     * This method converts a string like "float(5,10)" to the generic DbSchema
     * type and uses the by-reference parameters $typeLength and $typePrecision
     * to communicate the optional length and precision of the field's type.
     *
     * @param string  $typeString
     * @param int    &$typeLength
     * @param int    &$typePrecision
     * @return string
     */
    static function convertToGenericType( $typeString, &$typeLength, &$typePrecision )
    {
        $genericType = self::$typeMap[$typeString];

        return $genericType;
    }

    /**
     * Returns whether the type $type is a numeric type
     *
     * @return bool
     */
    private function isNumericType( $type )
    {
        $types = array( 'real', 'integer' );
        return in_array( $type, $types );
    }

    /**
     * Returns whether the type $type is a string type
     *
     * @return bool
     */
    private function isStringType( $type )
    {
        $types = array( 'text' );
        return in_array( $type, $types );
    }

    /**
     * Returns whether the type $type is a blob type
     *
     * @return bool
     */
    private function isBlobType( $type )
    {
        $types = array( 'blob' );
        return in_array( $type, $types );
    }


    /**
     * Loops over all the indexes in the table $table and extracts information.
     *
     * This method extracts information about the table $tableName's indexes
     * from the database and returns this schema as an array of
     * ezcDbSchemaIndex objects. The key in the array is the index' name.
     *
     * @param  string
     * @return array(string=>ezcDbSchemaIndex)
     */
    private function fetchTableIndexes( $tableName )
    {
        $indexBuffer = array();

        $resultArray = $this->db->query( "" );
        
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

<?php
/**
 * File containing the ezcDbSchemaHandlerMysql class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for MySQL databases and SQL files.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaHandlerMysql extends ezcDbSchemaHandlerSql implements ezcDbSchemaHandlerDataTransfer
{
    // these members are used in bulk transfer methods

    /**
     * Bulk data transfer destination (a file or a DB)
     */
    private $storage                 = null;

    /**
     * Name of the table we're transferring data from.
     */
    private $currentTableBeingStored = null;

    /**
     * Indicates whether destination of bulk transfer is a database.
     *
     * true if storing to db, false if to file
     */
    private $storeToDatabase         = null;

    public function __construct( $params )
    {
        parent::__construct( $params );
    }

    public function getDbmsName()
    {
        return 'mysql';
    }

    /**
     * This handler supports saving/loading schema
     * to/from DB and saving to SQL files.
     */
    static public function getSupportedStorageTypes()
    {
        return array( 'mysql-db', 'mysql-file' );
    }

    /**
     * @return array List of schema features supported by the handler.
     */
    static public function getSupportedFeatures()
    {
        return array( 'auto_increment', 'field_precision', 'limited_index_field_length' );
    }

    /**
     * Loads schema from a database.
     */
    public function loadSchema( $src, $storageType, $what )
    {
        $schema = null;

        if ( !in_array( $storageType, $this->getSupportedStorageTypes() ) )
            throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );

        if ( $storageType == 'mysql-db' )
        {
            if ( ! $src instanceof ezcDbHandler )
            {
                throw new ezcDbSchemaException(
                    ezcDbSchemaException::INVALID_ARGUMENT,
                    'Invalid argument: a database handler instance is expected' );
            }

            if ( !self::checkWhat( $what ) )
            {
                throw new ezcDbSchemaException(
                    ezcDbSchemaException::INVALID_ARGUMENT,
                    'Unknown specification of what to load.' );
            }

            $schema = $this->fetchSchema( $src, $what );
        }

        return $schema;
    }

    /**
     * Saves schema to an SQL file or database.
     */
    public function saveSchema( $schema, $dst, $storageType, $what )
    {
        if ( !in_array( $storageType, $this->getSupportedStorageTypes() ) )
            throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );

        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(
                ezcDbSchemaException::INVALID_ARGUMENT,
                'Unknown specification of what to save.' );
        }

        $saveSchema = in_array( $what, array( 'schema', 'both' ) );
        $saveData   = in_array( $what, array( 'data',   'both' ) );

        // save to a .sql file
        if ( $storageType == 'mysql-file' )
        {
            $dump = '';

            if ( $saveSchema )
            {
                $schemaQueries = $this->generateSchemaAsSQL( $schema );
                $dump .= join( ";\n\n\n", $schemaQueries ) . ";\n";
            }

            if ( $saveData )
            {
                $dataQueries = $this->generateDataAsSQL( $schema );
                $dump .= join( ";\n", $dataQueries ) . ";\n";
            }

            $fh = self::fopen( $dst, 'wb' );
            fwrite( $fh, $dump );
            fclose( $fh );
        }

        // save to a db
        elseif ( $storageType == 'mysql-db' )
        {
            $db = $dst;

            $db->beginTransaction();

            if ( $saveSchema && !$saveData )
            {
                $db->createUtilities()->cleanup();
            }

            if ( $saveSchema )
            {
                $schemaQueries = $this->generateSchemaAsSQL( $schema );
                foreach ( $schemaQueries as $query )
                    $db->exec( $query );
            }

            if ( $saveData )
            {
                $dataQueries = $this->generateDataAsSQL( $schema );
                foreach ( $dataQueries as $query )
                    $db->exec( $query );
            }

            $db->commit();
        }
    }

    /**
     * Saves difference between schemas to an SQL file.
     */
    public function saveDelta ( $delta, $dst, $storageType )
    {
        if ( $storageType != 'mysql-file' )
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMENT );

        $queries = $this->generateDeltaSQL( $delta );
        $dump = $queries ? ( join( ";\n", $queries ) . ";\n" ) : '';

        $fh = self::fopen( $dst, 'wb' );
        fwrite( $fh, $dump );
        fclose( $fh );
    }

    /**
     * Returns the list of internal formats supported by the handler.
     *
     * @see ezcDbSchemaHandler::getSupportedInternalFormats()
     */
    static public function getSupportedInternalFormats()
    {
        return array( 'mysql-queries-array' );
    }

    /**
     * Return schema in one of internal formats without saving it to a file or database.
     *
     * @see ezcDbSchemaHandler::getSchema()
     * @throws ezcDbSchemaException::UNKNOWN_INTERNAL_FORMAT if an unknown
     *         internal format specified
     * @throws ezcDbSchemaException::INVALID_ARGUMMENT if $what is specified incorrectly.
     */
    public function getSchema( $schema, $internalFormat, $what )
    {
        $getSchema = in_array( $what, array( 'schema', 'both' ) );
        $getData   = in_array( $what, array( 'data',   'both' ) );

        // check $what
        if ( !self::checkWhat( $what ) )
        {
            throw new ezcDbSchemaException(  ezcDbSchemaException::INVALID_ARGUMENT,
                                             'Unknown specification of what to load.' );
        }
        if ( !$getSchema && !$getData )
        {
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMMENT,
                                            'Nothing to get.' );
        }

        switch ( $internalFormat )
        {
            case 'mysql-queries-array':
                {
                    $queries = array();
                    if ( $getSchema )
                        $queries = array_merge( $queries,  $this->generateSchemaAsSQL( $schema ) );
                    if ( $getData )
                        $queries = array_merge( $queries,  $this->generateDataAsSQL( $schema ) );
                    return $queries;
                }

            default:
                throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_INTERNAL_FORMAT );
        }
    }

    /**
     * Fetch schema from given database.
     *
     * @return array Fetched schema.
     */
    private function fetchSchema( $db, $what )
    {
        $result = array();

        $fetchSchema = in_array( $what, array( 'schema', 'both' ) );
        $fetchData   = in_array( $what, array( 'data',   'both' ) );

        if ( $fetchSchema || $fetchData )
        {
            $rsltTables = $db->query( "SHOW TABLES" );
            $rsltTables->setFetchMode( PDO::FETCH_NUM );
            $tables = $rsltTables->fetchAll();

            $schema = array(
                '_info'  => array(
                    'dbms_type' => self::getDbmsName(),
                    'dbms_ver'  => false,
                    'app'       => false,
                    'features'  => array()
                ),
                'tables' => array(),
            );

            foreach ( $tables as $row )
            {
                $tableName = $row[0];

                $tableSchema            = array();
                $tableSchema['name']    = $tableName;
                $tableSchema['fields']  = $this->fetchTableFields( $db, $tableName );
                $tableSchema['indexes'] = $this->fetchTableIndexes( $db, $tableName );

                $schema['tables'][$tableName] = $tableSchema;
            }

            ksort( $schema );
        }

        if ( $fetchData )
        {
            foreach ( array_keys( $schema['tables'] ) as $table )
            {
                $result['data'][$table]['fields'] = array_keys( $schema['tables'][$table]['fields'] );
                $tableDataRslt = $db->query( "SELECT * FROM $table" );
                $tableDataRslt->setFetchMode( PDO::FETCH_NUM );
                $result['data'][$table]['rows'] = $tableDataRslt->fetchAll();
                unset( $tableDataRslt );
            }
        }

        if ( $fetchSchema )
            $result['schema'] = $schema;

        krsort( $result ); // put schema before data in the result

        return $result;
    }

    /**
     * Fetch fields definition for the given table.
     *
     * @param ezcDbHandler $db    Database to use.
     * @param string       $table Table to fetch fields from.
     */
    private function fetchTableFields( $db, $table )
    {
        $fields = array();

        $resultArray = $db->query( "DESCRIBE $table" );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );

        foreach ( $resultArray as $row )
        {
            $field = array();
            $field['type'] = $this->parseType ( $row['type'], $field['length'], $field['precision'] );
            if ( !$field['length'] )
            {
                unset( $field['length'] );
            }

            if ( is_null( $field['precision'] ) )
                unset( $field['precision'] );

            $field['not_null'] = 0;
            if ( substr( $row['null'], 0, 1 ) != 'Y' )
            {
                $field['not_null'] = '1';
            }
            $field['default'] = false;
            if ( !$field['not_null'] )
            {
                if ( $row['default'] === null )
                    $field['default'] = null;
                else
                    $field['default'] = (string)$row['default'];
            }
            else
            {
                $field['default'] = (string)$row['default'];
            }

            $numericTypes = array( 'float', 'int' );
            $blobTypes = array( 'tinytext', 'text', 'mediumtext', 'longtext' );
            $charTypes = array( 'varchar', 'char' );
            if ( in_array( $field['type'], $charTypes ) )
            {
                if ( !$field['not_null'] )
                {
                    if ( $field['default'] === null )
                    {
                        $field['default'] = null;
                    }
                    else if ( $field['default'] === false )
                    {
                        $field['default'] = '';
                    }
                }
            }
            else if ( in_array( $field['type'], $numericTypes ) )
            {
                if ( $field['default'] === false )
                {
                    if ( $field['not_null'] )
                    {
                        $field['default'] = 0;
                    }
                }
                else if ( $field['type'] == 'int' )
                {
                    if ( $field['not_null'] or
                         is_numeric( $field['default'] ) )
                        $field['default'] = (int)$field['default'];
                }
                else if ( $field['type'] == 'float' or
                          is_numeric( $field['default'] ) )
                {
                    if ( $field['not_null'] or
                         is_numeric( $field['default'] ) )
                        $field['default'] = (float)$field['default'];
                }
            }
            else if ( in_array( $field['type'], $blobTypes ) )
            {
                // We do not want default for blobs.
                $field['default'] = false;
            }

            if ( substr ( $row['extra'], 'auto_increment' ) !== false )
            {
                $field['options'] = array( 'auto_increment' => true );
            }

            if ( !$field['not_null'] )
                unset( $field['not_null'] );

            $fields[$row['field']] = $field;
        }
        //ksort( $fields );

        return $fields;
    }

    /**
     * Extracts length/precision information from mysql type.
     *
     * @param string $type_info      A string like "float(5,10)"
     * @param ref    $length_info    Used to return field length.
     * @param ref    $precision_info Used to return field precision.
     * @return string type name.
     */
    private function parseType( $type_info, &$length_info, &$precision_info )
    {
        preg_match( "@([a-z]*)(\((\d*)(,(\d+))?\))?@", $type_info, $matches );

        if ( isset( $matches[3] ) )
        {
            $length_info = $matches[3];
            if ( is_numeric( $length_info ) )
                $length_info = (int)$length_info;
        }
        if ( isset( $matches[5] ) )
            $precision_info = $matches[5];

        return $matches[1];
    }


    /**
     * Fetches all indexes from a database along with their schema.
     * @return array(mixed)  Indexes schema.
     */
    private function fetchTableIndexes( $db, $table )
    {
        $indexes = array();

        $resultArray = $db->query( "SHOW INDEX FROM $table" );

        foreach ( $resultArray as $row )
        {
            $kn = $row['key_name'];

            if ( $kn == 'PRIMARY' )
            {
                $indexes[$kn]['type'] = 'primary';
            }
            else
            {
                $indexes[$kn]['type'] = $row['non_unique'] ? 'non-unique' : 'unique';
            }

            $indexes[$kn]['fields'][] = $row['column_name'];

            if ( $row['sub_part'] )
                $indexes[$kn]['options']['limitations'][$row['column_name']] = $row['sub_part'];

            ksort( $indexes[$kn] );
        }

        ksort( $indexes );

        return $indexes;
    }

    /**
     * Dump specified schema as an array of SQL queries.
     *
     * @throws ezcDbSchemaException::GENERIC_ERROR if there's no schema
     *         to generate SQL queries for.
     * @return array The queries.
     * @static
     */
    private function generateSchemaAsSQL( $schema )
    {
        if ( !isset( $schema['schema'] ) )
             throw new ezcDbSchemaException( ezcDbSchemaException::GENERIC_ERROR,
                                             'You should load schema before using it.' );

        $queries = array();

        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
            $queries = array_merge( $queries, $this->generateCreateTableSql( $tableName, $tableSchema ) );

        return $queries;
    }

    /**
     * Dumps field schema as part of a DDL query.
     * @param   string $fieldName   Field name.
     * @param   array  $fieldSchema Field schema.
     * @return string              Field schema in SQL.
     */
    private static function generateFieldSQL( $fieldName, $fieldSchema )
    {
        $def = $fieldSchema;

        $mysqlCompatible = false;
        $defaultText = $mysqlCompatible ? "default" : "DEFAULT";
        $diffFriendly = false;
        $sql_def = $fieldName . ' ';

        $defList = array();
        $type = $def['type'];
        if ( isset( $def['length'] ) )
        {
            if ( isset( $def['precision'] ) )
                $type .= "({$def['length']},{$def['precision']})";
            else
                $type .= "({$def['length']})";
        }
        $defList[] = $type;
        if ( isset( $def['not_null'] ) && ( $def['not_null'] ) )
        {
            $defList[] = 'NOT NULL';
        }

        if ( isset( $def['options']['auto_increment'] ) )
        {
            $incrementText = $mysqlCompatible ? "auto_increment" : "AUTO_INCREMENT";
            $defList[] = $incrementText;
            $skip_primary = true;
        }
        elseif ( array_key_exists( 'default', $def ) )
        {
            if ( $def['default'] === null )
            {
                $defList[] = "$defaultText NULL";
            }
            else if ( $def['default'] !== false )
            {
                $defList[] = "$defaultText '{$def['default']}'";
            }
        }

        $sql_def .= join( $diffFriendly ? "\n    " : " ", $defList );
        $skip_primary = false;

        return $sql_def;
    }

    /**
     * Dumps data from a database as a set of INSERTs.
     *
     * Note: Cannot work with large databases due to memory exhaustion.
     *
     * @return array(string) The INSERT queries.
     */
    private static function generateDataAsSQL( $schema )
    {
        if ( !isset( $schema['schema'] ) )
        {
             throw new ezcDbSchemaException(
                 ezcDbSchemaException::GENERIC_ERROR,
                 'You should load schema before ' .
                 'generating queries for the corresponding data.' );
        }

        if ( !isset( $schema['data'] ) )
        {
             throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMENT,
                                             'You should load data before using it.' );
        }

        $queries = array();
        foreach ( $schema['data'] as $tableName => $tableData )
        {
            $fieldsDef = array_values( $schema['schema']['tables'][$tableName]['fields'] );

            foreach ( $tableData['rows'] as $row )
            {
                $valStrings  = array();
                foreach ( $row as $i => $val )
                    $valStrings[] = $this->generateDataValueTextSQL( $fieldsDef[$i], $val );;
                $values = join( ',', $valStrings );
                $query = "INSERT INTO $tableName VALUES ($values)";
                $queries[] = $query;
            }
        }

        return $queries;
    }

    /**
     * Dumps given column value as SQL.
     *
     * Encloses string values with quotes,
     * dumps null as NULL.
     *
     * @return string The value ready to be used in SQL.
     */
    private static function generateDataValueTextSQL( $fieldDef, $value )
    {
        if ( $fieldDef['type'] == 'auto_increment' or
             $fieldDef['type'] == 'int' or
             $fieldDef['type'] == 'float' )
        {
            if ( $value === null or
                 $value === false )
                return "NULL";
            $value = (int)$value;
            $value = (string)$value;
            return $value;
        }
        else if ( is_string( $value ) )
        {
            return "'" . str_replace ("'", "''", $value ) . "'";
        }
        else
        {
            if ( $value === null or
                 $value === false )
                return "NULL";
            return (string)$value;
        }
    }

    /**
     * Generate SQL queries for table creation.
     *
     * @return array(string) Array of queries needed to create the table
     *                        (along with its indexes, etc).
     * @see ezcDbSchemaHandlerSql::generateCreateTableSql()
     */
    protected function generateCreateTableSql( $tableName, $tableSchema, $params = array() )
    {
        $diffFriendly = false;
        $sql = '';

        $sql .= "CREATE TABLE $tableName (\n";

        // dump fields
        $fieldsSQL = array();

        foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
            $fieldsSQL[] = '  ' . $this->generateFieldSQL( $fieldName, $fieldSchema );

        // dump indexes
        foreach ( $tableSchema['indexes'] as $indexName => $indexSchema )
        {
            $fieldsSQL[] = ( $diffFriendly ? '' : '  ' ) .
                $this->generateAddIndexSql( $tableName, $indexName, $indexSchema,
                                            array(), true );
        }

        $sql .= join( ",\n", $fieldsSQL );

        $sql .= "\n)";

        return array( $sql );
    }


    /**
     * Generate table dropping SQL query.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateDropTableSql()
     */
    protected function generateDropTableSql( $tableName, $params = array() )
    {
        return "DROP TABLE $tableName";
    }

    /**
     * Generate SQL query for adding a table field.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateAddFieldSql()
     */
    protected function generateAddFieldSql( $tableName, $fieldName, $fieldSchema, $params = array() )
    {
        $sql = "ALTER TABLE $tableName ADD COLUMN ";
        $sql .= $this->generateFieldSql( $fieldName, $fieldSchema );
        return $sql;
    }

    /**
     * Generate SQL query for altering table field schema.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateAlterFieldSql()
     */
    protected function generateAlterFieldSql( $tableName, $fieldName, $fieldSchema, $diffParams = array() )
    {
        $sql = "ALTER TABLE $tableName CHANGE COLUMN $fieldName ";
        $sql .= $this->generateFieldSQL( $fieldName, $fieldSchema );
        return $sql;
    }

    /**
     * Generate SQL query for dropping a table field.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateDropFieldSql()
     */
    protected function generateDropFieldSql( $tableName, $fieldName, $params = array() )
    {
        return "ALTER TABLE $tableName DROP COLUMN $fieldName";
    }

    /**
     * Generate index creation SQL query.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateAddIndexSql()
     */
    protected function generateAddIndexSql( $tableName, $indexName, $indexSchema, $params = array(), $isEmbedded = false )
    {
        $diffFriendly = isset( $params['diff_friendly'] ) ? $params['diff_friendly'] : false;
        // If the output should compatible with existing MySQL dumps
        $mysqlCompatible = isset( $params['compatible_sql'] ) ? $params['compatible_sql'] : false;
        $sql = '';

        $table_name = $tableName;
        $index_name = $indexName;
        $def = $indexSchema;

        // Will be set to true when primary key is inside CREATE TABLE
        if ( !$isEmbedded )
        {
            $sql .= "ALTER TABLE $table_name ADD";
            $sql .= " ";
        }

        switch ( $def['type'] )
        {
            case 'primary':
            {
                $sql .= 'PRIMARY KEY';
                if ( $mysqlCompatible )
                    $sql .= " ";
            } break;

            case 'non-unique':
            {
                if ( $isEmbedded )
                {
                    $sql .= "KEY $index_name";
                }
                else
                {
                    $sql .= "INDEX $index_name";
                }
            } break;

            case 'unique':
            {
                if ( $isEmbedded )
                {
                    $sql .= "UNIQUE KEY $index_name";
                }
                else
                {
                    $sql .= "UNIQUE $index_name";
                }
            } break;
        }

        $sql .= ( $diffFriendly ? " (\n    " : ( $mysqlCompatible ? " (" : " ( " ) );
        $fields = $def['fields'];
        $i = 0;
        foreach ( $fields as $fieldDef )
        {
            if ( $i > 0 )
            {
                $sql .= $diffFriendly ? ",\n    " : ( $mysqlCompatible ? ',' : ', ' );
            }

            // Dump limitation on maximum indexed field length (if specified).
            if ( isset( $indexSchema['options']['limitations'][$fieldDef] ) )
            {
                $fieldName = $fieldDef;
                $limit = $indexSchema['options']['limitations'][$fieldDef];

                $sql .= $fieldName;

                if ( $diffFriendly )
                {
                    $sql .= "(\n";
                    $sql .= "    " . str_repeat( ' ', strlen( $fieldName ) );
                }
                else
                {
                    $sql .= $mysqlCompatible ? "(" : "( ";
                }
                $sql .= $limit;
                if ( $diffFriendly )
                {
                    $sql .= ")";
                }
                else
                {
                    $sql .= $mysqlCompatible ? ")" : " )";
                }
            }
            else
            {
                $sql .= $fieldDef;
            }

            ++$i;
        }
        $sql .= ( $diffFriendly ? "\n)" : ( $mysqlCompatible ? ")" : " )" ) );

        return $sql;
    }

    /**
     * Generate drop index SQL query.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateDropIndexSql()
     */
    protected function generateDropIndexSql( $tableName, $indexName, $indexSchema, $params = array() )
    {
        $sql = '';
        $sql .= "ALTER TABLE $tableName DROP ";

        if ( $indexSchema['type'] == 'primary' )
        {
            $sql .= 'PRIMARY KEY';
        }
        else
        {
            $sql .= "INDEX $indexName";
        }

        return $sql;
    }


    /**
     * Prepare destination handler for transfer [destination].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function openTransferDestination( $storage, $storageType )
    {
        $this->currentTableBeingStored = null;

        if ( $storageType == 'mysql-db' )
        {
            $this->storeToDatabase = true;
            $this->storage = $storage;
        }
        else
        {
            $this->storeToDatabase = false;
            $this->storage = self::fopen( $storage, 'w' );
        }
    }

    /**
     * Tell destination handler that there is no more data to transfer. [destination]
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function closeTransferDestination()
    {
        if ( !$this->storeToDatabase )
            fclose( $this->storage );

        $this->storage                 = null;
        $this->currentTableBeingStored = null;
        $this->storeToDatabase         = null;
    }

    /**
     * Start to transfer data of the next table. [destination]
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function setTableBeingTransferred( $tableName, $tableFields = null )
    {
        $this->currentTableBeingStored = $tableName;

        $deleteQuery = "DELETE FROM $tableName;\n";
        if ( $this->storeToDatabase )
            $this->storage->query( $deleteQuery );
        else
            fputs( $this->storage, $deleteQuery );
    }


    /**
     * Save given row. [destination]
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function saveRow( $row )
    {
        $query = 'INSERT INTO ' . $this->currentTableBeingStored .
            ' VALUES (';

        // quote strings
        foreach ( $row as &$val )
        {
            if ( is_string( $val ) )
                $val = '\'' . str_replace( "'", "''", $val ) . '\'';
            elseif ( is_null( $val ) )
                $val = 'NULL';
        }

        $query .= join( ",", $row ) . ");\n";

        if ( $this->storeToDatabase )
        {
            $this->storage->query( $query );
        }
        else
            fputs( $this->storage, $query );
    }


    /**
     * Actually transfer data [source].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function transfer( $storage, $storageType, $dstHandler )
    {
        $db = $storage;
        $rsltTables = $db->query( 'SHOW TABLES' );
        $rsltTables->setFetchMode( PDO::FETCH_NUM );
        $tables = $rsltTables->fetchAll();
        array_walk( $tables, create_function( '&$a', '$a = $a[0];' ) );

        foreach ( $tables as $table )
        {
            // get fields list
            $rslt = $db->query( "SELECT * FROM $table" );
            $rslt->setFetchMode( PDO::FETCH_NUM );
            $nCols = $rslt->columnCount();

            $fields = array();
            for ( $col = 0; $col < $nCols; $col++ )
            {
                $colSchema = $rslt->getColumnMeta( $col );
                $fields[] = $colSchema['name'];
            }

            $dstHandler->setTableBeingTransferred( $table, $fields );

            foreach ( $rslt as $row )
            {
                $dstHandler->saveRow( $row );
            }
            unset( $rslt );
        }
    }

}

?>
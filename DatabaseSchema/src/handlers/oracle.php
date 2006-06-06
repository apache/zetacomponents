<?php
/**
 * File containing the ezcDbSchemaHandlerOracle class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for Oracle databases and SQL files.
 *
 * @package DatabaseSchema
 */

class ezcDbSchemaHandlerOracle extends ezcDbSchemaHandlerSql implements ezcDbSchemaHandlerDataTransfer
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

    public function getDbmsName()
    {
        return 'oracle';
    }

    /**
     * This handler supports saving/loading schema
     * to/from DB and saving to SQL files.
     */
    static public function getSupportedStorageTypes()
    {
        return array( 'oracle-db', 'oracle-file' );
    }

    /**
     * Returns the list of internal formats supported by the handler.
     *
     * @see ezcDbSchemaHandler::getSupportedInternalFormats()
     */
    static public function getSupportedInternalFormats()
    {
        return array( 'oracle-queries-array' );
    }

    /**
     * @return array List of schema features supported by the handler.
     */
    static public function getSupportedFeatures()
    {
        return array(
            'sequences',
            'triggers',
        );
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
            case 'oracle-queries-array':
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
     * Loads schema from a database.
     */
    public function loadSchema( $src, $storageType, $what )
    {
        $schema = null;

        if ( !in_array( $storageType, $this->getSupportedStorageTypes() ) )
        {
            throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );
        }

        if ( $storageType == 'oracle-db' )
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
        if ( $storageType == 'oracle-file' )
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

                // updates sequences values
                $updateSeqQueries = $this->generateUpdateSequencesSQL( $schema );
                $dump .= join( ";\n", $updateSeqQueries ) . ";\n";
            }

            // actually save
            $fh = self::fopen( $dst, 'wb' );
            fwrite( $fh, $dump );
            fclose( $fh );
        }

        // save to a db
        elseif ( $storageType == 'oracle-db' )
        {
            $db = $dst;

            $db->begin();

            if ( $saveSchema )
            {
                $db->createUtilities()->cleanup();
            }

            if ( $saveSchema )
            {
                $schemaQueries = $this->generateSchemaAsSQL( $schema );
                foreach ( $schemaQueries as $query )
                {
                    $db->exec( $query );
                }
                unset( $schemaQueries );
            }

            if ( $saveData )
            {
                $dataQueries = $this->generateDataAsSQL( $schema );
                foreach ( $dataQueries as $query )
                {
                    $db->exec( $query );
                }
                unset( $dataQueries );

                $updateSeqQueries = $this->generateUpdateSequencesSQL( $schema );
                foreach ( $updateSeqQueries as $query )
                {
                    $db->exec( $query );
                }
                unset( $updateSeqQueries );
            }

            $db->commit();
        }
    }

    /**
     * Saves difference between schemas to an SQL file.
     */
    public function saveDelta ( $delta, $dst, $storageType )
    {
        if ( $storageType != 'oracle-file' )
        {
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMENT );
        }

        $queries = $this->generateDeltaSQL( $delta );
        $dump = $queries ? ( join( ";\n", $queries ) . ";\n" ) : '';

        $fh = self::fopen( $dst, 'wb' );
        fwrite( $fh, $dump );
        fclose( $fh );
    }

    /**
     * Actually transfer data [source].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function transfer( $storage, $storageType, $dstHandler )
    {
        $db = $storage;
        $tables = $this->fetchTablesList( $db );
        foreach ( $tables as $table )
        {
            // get fields list
            $fields = array_keys( $this->fetchTableFields( $db, $table ) );

            $rslt = $db->query( "SELECT * FROM $table" );
            $rslt->setFetchMode( PDO::FETCH_NUM );

            $dstHandler->setTableBeingTransferred( $table, $fields );

            foreach ( $rslt as $row )
            {
                $dstHandler->saveRow( $row );
            }
            unset( $rslt );
        }
    }


    /**
     * Prepare destination handler for transfer [destination].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function openTransferDestination( $storage, $storageType )
    {
        $this->currentTableBeingStored = null;

        if ( $storageType == 'oracle-db' )
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
        if ( $this->storeToDatabase )
        {
            // FIXME: update sequences here
        }
        else
        {
            fclose( $this->storage );
        }

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

        $deleteQuery = "DELETE FROM $tableName";
        if ( $this->storeToDatabase )
        {
            $this->storage->query( $deleteQuery );
        }
        else
        {
            fputs( $this->storage, $deleteQuery . ";\n" );
        }
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
            {
                $val = '\'' . str_replace( "'", "''", $val ) . '\'';
            }
            elseif ( is_null( $val ) )
            {
                $val = 'NULL';
            }
        }

        $query .= join( ",", $row ) . ")";

        if ( $this->storeToDatabase )
        {
            $this->storage->query( $query );
        }
        else
        {
            fputs( $this->storage, $query . ";\n" );
        }
    }


    // ------------- Delta handling methods ---------------

    /**
     * Generate SQL queries for table creation.
     *
     * @return array(string) Array of queries needed to create the table
     *                        (along with its indexes, etc).
     * @see ezcDbSchemaHandlerSql::generateCreateTableSql()
     */
    protected function generateCreateTableSql( $tableName, $tableSchema, $params = array() )
    {
        $sqls = array();


        // dump table
        $createTableSql = "CREATE TABLE $tableName (\n";

        // dump table fields
        $fieldsSQL = array();

        foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
        {
            $fieldsSQL[] = '  ' . $this->generateFieldSQL( $tableName, $fieldName, $fieldSchema );
        }

        $createTableSql .= join( ",\n", $fieldsSQL ) . "\n)";

        $sqls[] = $createTableSql;


        // dump table indexes
        foreach ( $tableSchema['indexes'] as $indexName => $indexSchema )
        {
            $createIndexSQL =
                $this->generateAddIndexSql( $tableName, $indexName, $indexSchema, array(), true );
            $sqls[] = $createIndexSQL;
        }

        return $sqls;
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
        $sql = "ALTER TABLE $tableNname ADD ";
        $sql .= eZOracleSchema::generateFieldDef ( $fieldName, $fieldSchema );

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
        // FIXME: check if a PHP warning appears when accessing 'different-options'
        $sql = "ALTER TABLE $tableName MODIFY (";
        $sql .= eZOracleSchema::generateFieldDef ( $fieldName, $fieldSchema, $diffParams['different-options'] );
        $sql .= ")";

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
         return "ALTER TABLE $tableNAme DROP COLUMN $fieldName";
    }

    /**
     * Generate index creation SQL query.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateAddIndexSql()
     */
    protected function generateAddIndexSql( $tableName, $indexName, $indexSchema, $params = array(), $isEmbedded = false  )
    {
        switch ( $indexSchema['type'] )
        {
            case 'primary':
                $sql = "ALTER TABLE $tableName ADD PRIMARY KEY ";
                break;

            case 'non-unique':
                $sql = "CREATE INDEX $indexName ON $tableName ";
                break;

            case 'unique':
                $sql = "CREATE UNIQUE INDEX $indexName ON $tableName ";
                break;

            default:
                eZDebug::writeError( "Unknown index type: " . $indexSchema['type'] );
                return '';
        }

        $sql .= '( ' . join ( ', ', $indexSchema['fields'] ) . ' )';

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
        $sql = "ALTER TABLE $tableName DROP ";

        if ( $tableSchema['type'] == 'primary' )
        {
            $sql .= 'PRIMARY KEY';
        }
        else
        {
            $sql .= "INDEX $indexName";
        }
        return $sql;
    }


    // ------- Methods specific for this class (i.e. not overloaded) --------

    /**
     * Fetch schema from given database.
     *
     * @return array Fetched schema.
     */
    protected function fetchSchema( $db, $what ) // FIXME: cut&paste
    {
        $result = array();

        $fetchSchema = in_array( $what,  array( 'schema', 'both' ) );
        $fetchData   = in_array( $what,  array( 'data',   'both' ) );

        if ( $fetchSchema || $fetchData )
        {
            $tables = $this->fetchTablesList( $db );
            $schema = array(
                '_info'  => array(
                    'dbms_type' => self::getDbmsName(),
                    'dbms_ver'  => false,
                    'app'       => false,
                    'features'  => array()
                ),
                'tables' => array(),
            );

            foreach ( $tables as $tableName )
            {
                $tableSchema            = array();
                $tableSchema['name']    = $tableName;
                $tableSchema['fields']  = $this->fetchTableFields( $db, $tableName );
                $tableSchema['indexes'] = $this->fetchTableIndexes( $db, $tableName );

                $schema['tables'][$tableName] = $tableSchema;
            }

            // fetch sequences
            foreach ( $this->fetchSequencesList( $db ) as $seqName )
            {
                $schema['sequences'][$seqName] = array(); // sequence schema may be placed in this array later
            }

            // FIXME: fetch triggers here

            if ( isset( $schema['tables'] ) )
            {
                ksort( $schema['tables'] );
            }

            if ( isset( $schema['sequences'] ) )
            {
                ksort( $schema['sequences'] );
            }
        }

        if ( $fetchData )
        {
            // FIXME: cut&paste

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
        {
            $result['schema'] = $schema;
        }

        krsort( $result ); // put schema before data in the result

        return $result;
    }

    /**
     * Fetch list of tables from the given database.
     *
     * @param  ezcDbHandler Database to fetch from.
     * @return array(string)      The list of tables.
     */
    protected function fetchTablesList( ezcDbHandler $db )
    {
        $rsltTables = $db->query( 'SELECT LOWER(table_name) FROM user_tables' );
        $tables = $rsltTables->fetchAll( PDO::FETCH_NUM );
        array_walk( $tables, create_function( '&$a', '$a = $a[0];' ) );
        return $tables;
    }

    /**
     * Fetch list of sequences from the given database.
     *
     * @param  ezcDbHandler $db   Database to fetch from.
     * @return array(string)      The list of sequences.
     */
    protected function fetchSequencesList( ezcDbHandler $db )
    {
        $rsltSequences = $db->query( 'SELECT LOWER(sequence_name) FROM user_sequences' );
        $sequences = $rsltSequences->fetchAll( PDO::FETCH_NUM );
        array_walk( $sequences, create_function( '&$a', '$a = $a[0];' ) );
        return $sequences;
    }

    /**
     * Fetch schema of all the table's fields.
     *
     * @param   ezcDbHandler  $db     Database to fetch from.
     * @param   string        $table  Name of the table to fetch from.
     * @return array                 Fields schema.
     */
    function fetchTableFields( $db, $table )
    {
        $numericTypes = array( 'float', 'int' );                               // FIXME: const
        $oraNumericTypes = array( 'FLOAT', 'NUMBER' );                         // FIXME: const
        $oraStringTypes  = array( 'CHAR', 'VARCHAR2' );                        // FIXME: const
        $blobTypes    = array( 'tinytext', 'text', 'mediumtext', 'longtext' ); // FIXME: const
        $fields      = array();

        $query = "SELECT   a.column_name AS col_name, " .
                 "         decode (a.nullable, 'N', 1, 'Y', 0) AS not_null, " .
                 "         a.data_type AS col_type, " .
                 "         a.data_length AS col_size, " .
                 "         a.data_default AS default_val " .
                 "FROM     user_tab_columns a ".
                 "WHERE    upper(a.table_name) = UPPER('$table') " .
                 "ORDER BY a.column_id";

        $resultArray = $db->query( $query );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );

        foreach ( $resultArray as $row )
        {
            $colName     = strtolower( $row['col_name'] );
            $colLength   = $row['col_size'];
            $colType     = $row['col_type'];
            $colNotNull  = (int) $row['not_null'];
            $colDefault  = $row['default_val'];

            $field = array();

            if ( is_string( $colDefault ) )
            {
                // strip trailing spaces
                $colDefault = rtrim( $colDefault );
            }

            if ( $colType == 'CLOB' )
            {
                // We do not want default for blobs.
                $field['type']    = $this->parseType( $colType );
                if ( $colNotNull )
                {
                    $field['not_null'] = (string) $colNotNull;
                }
                $field['default'] = false;
            }
            elseif ( in_array( $colType, $oraNumericTypes ) ) // number
            {
                if ( $colType != 'FLOAT' )
                {
                    $field['length'] = (int) $this->parseLength( $colType, $colLength );
                }
                $field['type']   = $this->parseType( $colType );

                if ( $colNotNull )
                {
                    $field['not_null'] = (string) $colNotNull;
                }

                if ( $colDefault !== null && $colDefault !== false )
                {
                    $field['default'] = (int) $colDefault;
                }
            }
            elseif ( in_array( $colType, $oraStringTypes ) ) // string
            {
                $field['length'] = (int) $this->parseLength( $colType, $colLength );
                $field['type']   = $this->parseType( $colType );

                if ( $colNotNull )
                {
                    $field['not_null'] = (string) $colNotNull;
                }

                if ( $colDefault !== null )
                {
                    // strip leading and trailing quotes
                    $field['default'] = preg_replace( array( '/^\\\'/', '/\\\'$/' ), '', $colDefault );
                }
            }
            else // what else?
            {
                $field['length'] = (int) $this->parseLength( $colType, $colLength );
                $field['type']   = $this->parseType( $colType );
                if ( $colNotNull )
                {
                    $field['not_null'] = (string) $colNotNull;
                }

                if ( $colDefault !== null )
                {
                    // strip leading and trailing quotes
                    $field['default'] = preg_replace( array( '/^\\\'/', '/\\\'$/' ), '', $colDefault );
                }
                else
                {
                    $field['default'] = false;
                }
            }

            if ( !array_key_exists( 'default', $field ) )
            {
                $field['default'] = null;
            }

            $fields[$colName] =& $field;
            unset( $field );
        }
        ksort( $fields );

        return $fields;
    }

    /**
     * Fetch schema of all the table's indexes.
     *
     * @param   ezcDbHandler  $db     Database to fetch from.
     * @param   string        $table  Name of the table to fetch from.
     * @return array                 Indexes schema.
     */
    protected function fetchTableIndexes( $db, $table )
    {
        $indexes = array();
        $query = "SELECT ui.index_name AS name, " .
                 "       ui.index_type AS type, " .
                 "       decode( ui.uniqueness, 'NONUNIQUE', 0, 'UNIQUE', 1 ) AS is_unique, " .
                 "       uic.column_name AS col_name, " .
                 "       uic.column_position AS col_pos " .
                 "FROM user_indexes ui, user_ind_columns uic " .
                 "WHERE ui.index_name = uic.index_name AND ui.table_name = UPPER('$table')";

        $resultArray = $db->query( $query );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );
        foreach ( $resultArray as $row )
        {
            $idxName = strtolower( $row['name'] );
            if ( strpos( $idxName, 'sys_' ) === 0 )
            {
                $idxType = 'primary';
                $idxName = "PRIMARY";
            }
            else
            {
                $idxType = ( (int) $row['is_unique'] ) ? 'unique' : 'non-unique';
            }

            $indexes[$idxName]['type']     = $idxType;
            $indexes[$idxName]['fields'][$row['col_pos'] - 1] = strtolower( $row['col_name'] );
        }
        ksort( $indexes );

        return $indexes;
    }

    protected function parseType( $type )
    {
        switch ( $type )
        {
            case 'NUMBER':
                return 'int';
            case 'FLOAT':
                return 'float';
            case 'VARCHAR2':
                return 'varchar';
            case 'CLOB':
                return 'longtext';
            case 'CHAR':
                return 'char';
            default:
                return $type;
        }
        return 'unknown';
    }

    protected function parseLength( $oraType, $oraLength )
    {
        if ( $oraType == 'NUMBER' )
        {
            return 11;
        }
        return $oraLength;
    }

    /**
     * Dump specified schema as an array of SQL queries.
     *
     * @throws ezcDbSchemaException::GENERIC_ERROR if there's no schema
     *         to generate SQL queries for.
     * @return array The queries.
     */
    protected function generateSchemaAsSQL( $schema )
    {
        if ( !isset( $schema['schema'] ) )
        {
             throw new ezcDbSchemaException( ezcDbSchemaException::GENERIC_ERROR,
                                             'You should load schema before using it.' );
        }

        $queries = array();

        // create sequences (if any)
        if ( isset( $schema['schema']['sequences'] ) )
        {
            foreach ( $schema['schema']['sequences'] as $seqName => $seqSchema )
            {
                $queries[] = $this->generateCreateSequenceSql( $seqName, $seqSchema );
            }
        }

        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
        {
            // dump table
            $queries = array_merge( $queries, $this->generateCreateTableSql( $tableName, $tableSchema ) );
        }

        // FIXME: dump triggers

        return $queries;
    }

    protected function generateCreateSequenceSql( $seqName, $seqSchema )
    {
        return "CREATE SEQUENCE $seqName";
    }

    protected function generateFieldSql( $tableName, $fieldName, $fieldSchema, $optionsToDump = array( 'default', 'not_null' ) )
    {
        $oraNumericTypes = array( 'INTEGER', 'FLOAT', 'DOUBLE PRECISION' ); // FIXME: should be a const

        $def = $fieldSchema;
        $sql_def = $fieldName . ' ';

        $oraType = $this->getOracleType( $def['type'] );
        $isNumericField = in_array( $oraType, $oraNumericTypes );

        if ( $def['type'] != 'auto_increment' )
        {
            // type
            $sql_def .= $oraType;
            if ( isset( $def['length'] ) && !$isNumericField )
            {
                $sql_def .= "({$def['length']})";
            }

            // default
            if ( in_array( 'default', $optionsToDump ) && array_key_exists( 'default', $def ) )
            {
                if ( isset( $def['default'] ) && $def['default'] !== false )
                {
                    $quote = $isNumericField ? '' : '\'';
                    $sql_def .= " DEFAULT $quote{$def['default']}$quote";
                }
            }

            // not null
            if ( in_array( 'not_null', $optionsToDump ) && isset( $def['not_null'] ) && $def['not_null'] )
            {
                $sql_def .= ' NOT NULL';
            }

        }
        else
        {
            $sql_def .= 'INTEGER NOT NULL';
        }
        return $sql_def;
    }

    /**
     * @return Oracle datatype matching the given generic type.
     */
    protected function getOracleType( $mysqlType )
    {
        $rslt = $mysqlType;
        $rslt = ereg_replace( 'varchar', 'VARCHAR2', $rslt );
        $rslt = ereg_replace( 'char', 'CHAR', $rslt );
        $rslt = ereg_replace( 'int(eger)?(\([0-9]+\))?( +unsigned)?', 'INTEGER', $rslt );
        $rslt = ereg_replace( '^(medium|long)?text$', 'CLOB', $rslt );
        $rslt = ereg_replace( '^double$', 'DOUBLE PRECISION', $rslt );
        $rslt = ereg_replace( '^float$', 'FLOAT', $rslt );
        return $rslt;
    }

    protected function generateDataAsSQL( $schema )  // FIXME: cut&paste
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
                {
                    $valStrings[] = $this->generateDataValueTextSQL( $fieldsDef[$i], $val );
                }
                $values = join( ',', $valStrings );
                $query = "INSERT INTO $tableName VALUES ($values)";
                $queries[] = $query;
            }
        }

        return $queries;
    }

    protected function generateDataValueTextSQL( $fieldDef, $value ) // FIXME: cut&paste
    {
        if ( $fieldDef['type'] == 'auto_increment' or
             $fieldDef['type'] == 'int' or
             $fieldDef['type'] == 'float' )
        {
            if ( $value === null || $value === false )
            {
                return "NULL";
            }
            $value = (int)$value;
            $value = (string)$value;
            return $value;
        }
        else if ( is_string( $value ) )
        {
            return "'" . str_replace ( "'", "''", $value ) . "'";
        }
        else
        {
            if ( $value === null || $value === false )
            {
                return "NULL";
            }
            return (string)$value;
        }
    }

}
?>

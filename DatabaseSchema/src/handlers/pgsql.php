<?php
/**
 * File containing the ezcDbSchemaHandlerPgsql class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Define EZC_DBSCHEMA_FETCH_TABLE_OID_QUERY
 */
define( 'EZC_DBSCHEMA_FETCH_TABLE_OID_QUERY', <<<END
SELECT c.oid,
    n.nspname,
    c.relname
FROM pg_catalog.pg_class c
    LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
WHERE pg_catalog.pg_table_is_visible(c.oid)
    AND c.relname ~ '^<<tablename>>$'
ORDER BY 2, 3;
END
);

define( 'EZC_DBSCHEMA_FETCH_TABLE_DEF_QUERY', <<<END
SELECT a.attname,
    pg_catalog.format_type(a.atttypid, a.atttypmod),
    (SELECT substring(d.adsrc for 128) FROM pg_catalog.pg_attrdef d
        WHERE d.adrelid = a.attrelid AND d.adnum = a.attnum AND a.atthasdef) as default,
    a.attnotnull, a.attnum
FROM pg_catalog.pg_attribute a
WHERE a.attrelid = '<<oid>>' AND a.attnum > 0 AND NOT a.attisdropped
ORDER BY a.attnum
END
);

define( 'EZC_DBSCHEMA_FETCH_INDEX_DEF_QUERY', <<<END
SELECT c.relname, i.*
FROM pg_catalog.pg_index i, pg_catalog.pg_class c
WHERE indrelid = '<<oid>>'
    AND i.indexrelid = c.oid
END
);

define( 'EZC_DBSCHEMA_FETCH_INDEX_COL_NAMES_QUERY', <<<END
SELECT a.attnum, a.attname
FROM pg_catalog.pg_attribute a
WHERE a.attrelid = '<<indexrelid>>' AND a.attnum IN (<<attids>>) AND NOT a.attisdropped
ORDER BY a.attnum
END
);

/**
 * Handler for PostgreSQL databases and SQL files.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaHandlerPgsql extends ezcDbSchemaHandlerSql implements ezcDbSchemaHandlerDataTransfer
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
        return 'pgsql';
    }

    /**
     * This handler supports saving/loading schema
     * to/from DB and saving to SQL files.
     */
    static public function getSupportedStorageTypes()
    {
        return array( 'pgsql-db', 'pgsql-file' );
    }

    /**
     * Returns the list of internal formats supported by the handler.
     *
     * @see ezcDbSchemaHandler::getSupportedInternalFormats()
     */
    static public function getSupportedInternalFormats()
    {
        return array( 'pgsql-queries-array' );
    }

    /**
     * @return array List of schema features supported by the handler.
     */
    static public function getSupportedFeatures()
    {
        return array(
            'sequences',
            'triggers',
            'field_default_is_sequence_value'
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
            case 'pgsql-queries-array':
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
            throw new ezcDbSchemaException( ezcDbSchemaException::UNKNOWN_STORAGE_TYPE );

        if ( $storageType == 'pgsql-db' )
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
        if ( $storageType == 'pgsql-file' )
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
        elseif ( $storageType == 'pgsql-db' )
        {
            $db = $dst;

            $db->beginTransaction();

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
                    $db->exec( $query );
                unset( $dataQueries );

                $updateSeqQueries = $this->generateUpdateSequencesSQL( $schema );
                foreach ( $updateSeqQueries as $query )
                    $db->exec( $query );
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
        if ( $storageType != 'pgsql-file' )
            throw new ezcDbSchemaException( ezcDbSchemaException::INVALID_ARGUMENT );

        $queries = $this->generateDeltaSQL( $delta );
        $dump = $queries ? ( join( ";\n", $queries ) . ";\n" ) : '';

        $fh = self::fopen( $dst, 'wb' );
        fwrite( $fh, $dump );
        fclose( $fh );
    }

    /**
     * Fetch schema from given database.
     *
     * @return array Fetched schema.
     */
    protected function fetchSchema( $db, $what )
    {
        $result = array();

        $fetchSchema = in_array( $what,  array( 'schema', 'both' ) );
        $fetchData   = in_array( $what, array( 'data',    'both' ) );

        if ( $fetchSchema || $fetchData )
        {
            $rsltTables = $db->query( "SELECT tablename FROM pg_tables WHERE tablename NOT LIKE 'pg_%'" );
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

            // fetch sequences
            $rsltSequences = $db->query( "SELECT relname FROM pg_catalog.pg_class WHERE relkind='S'" );
            $rsltSequences->setFetchMode( PDO::FETCH_NUM );
            foreach ( $rsltSequences as $row )
            {
                $seqName = $row[0];
                $schema['sequences'][$seqName] = array(); // sequence schema may be placed in this array later
            }

            // FIXME: fetch triggers here

            if ( isset( $schema['tables'] ) )
                ksort( $schema['tables'] );

            if ( isset( $schema['sequences'] ) )
                ksort( $schema['sequences'] );
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
    protected static function fetchTableFields( $db, $table )
    {
        $fields = array();

        $resultArray = $db->query( str_replace( '<<tablename>>', $table, EZC_DBSCHEMA_FETCH_TABLE_OID_QUERY ) );
        $rows = $resultArray->fetchAll();
        $oid = $rows[0]['oid'];

        $resultArray = $db->query( str_replace( '<<oid>>', $oid, EZC_DBSCHEMA_FETCH_TABLE_DEF_QUERY ) );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );
        foreach ( $resultArray as $row )
        {
            $field = array();
            $field['type'] = self::parseType( $row['format_type'], $field['length'] );
            if ( !$field['length'] )
            {
                unset( $field['length'] );
            }

            $field['not_null'] = 0;
            if ( $row['attnotnull'] == 't' )
            {
                $field['not_null'] = '1';
            }

            $field['default'] = false;
            $field['default'] = self::parseDefault ( $field, $row['default'] );

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
                    if ( !is_array( $field['default'] ) and
                         ( $field['not_null'] or is_numeric( $field['default'] ) ) )
                    {
                        $field['default'] = (int)$field['default'];
                    }
                }
                else if ( $field['type'] == 'float' )
                {
                    if ( !is_array( $field['default'] ) and
                         ( $field['not_null'] or is_numeric( $field['default'] ) ) )
                    {
                        $field['default'] = (float)$field['default'];
                    }
                }
            }
            else if ( in_array( $field['type'], $blobTypes ) )
            {
                // We do not want default for blobs.
                $field['default'] = false;
            }

            if ( !$field['not_null'] )
                unset( $field['not_null'] );

            $fields[$row['attname']] = $field;
        }
        //ksort( $fields );

        return $fields;

    }

    protected static function  fetchTableIndexes( $db, $table )
    {
        $metaData = false;
        if ( isset( $params['meta_data'] ) )
        {
            $metaData = $params['meta_data'];
        }

        $indexes = array();

        $resultArray = $db->query( str_replace( '<<tablename>>', $table, EZC_DBSCHEMA_FETCH_TABLE_OID_QUERY ) );
        $rows = $resultArray->fetchAll();
        $oid = $rows[0]['oid'];

        $resultArray = $db->query( str_replace( '<<oid>>', $oid, EZC_DBSCHEMA_FETCH_INDEX_DEF_QUERY ) );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );

        foreach ( $resultArray as $row )
        {
            $fields = array();
            $kn = $row['relname'];

            $column_id_array = split( ' ', $row['indkey'] );
            if ( $row['indisprimary'] == 't' )
            {
                // If the name of the key matches our primary key naming standard
                // we change the name to PRIMARY, this makes it 100% similar to
                // primary keys in MySQL
                $correctName = self::primaryKeyIndexName( $table, $kn, $column_id_array );
                if ( strlen( $correctName ) > 63 )
                {
                    trigger_error( "The index name '$correctName' (" .
                                   strlen( $correctName ) . ") " .
                                   "exceeds 63 characters " .
                                   "which is the PostgreSQL limit for names", E_USER_ERROR );

                }
                if ( $kn == $correctName )
                {
                    $kn = 'PRIMARY';
                }

                // Extra meta data:
                // Include the name of the index that postgresql will use
                if ( $metaData )
                {
                    $indexes[$kn]['postgresql:name'] = $correctName;
                }

                $indexes[$kn]['type'] = 'primary';
            }
            else
            {
                $indexes[$kn]['type'] = $row['indisunique'] == 't' ? 'unique' : 'non-unique';
            }

            /* getting fieldnames requires yet another query and it doesn't return it 'in order' either.
             * grumble, stupid pgsql :) */
            $att_ids = join( ', ',  $column_id_array );
            $query = str_replace( '<<indexrelid>>', $row['indrelid'], EZC_DBSCHEMA_FETCH_INDEX_COL_NAMES_QUERY );
            $query = str_replace( '<<attids>>', $att_ids, $query );

            $fieldsArray = $db->query( $query );
            $fieldsArray->setFetchMode( PDO::FETCH_ASSOC );
            foreach ( $fieldsArray as $fields_row )
            {
                $fields[$fields_row['attnum']] = $fields_row['attname'];
            }
            foreach ( $column_id_array as $rank => $id )
            {
                $indexes[$kn]['fields'][$rank] = $fields[$id];
            }

            ksort( $indexes[$kn] );
        }
        ksort( $indexes );

        return $indexes;
    }

    protected static function parseType( $type_info, &$length_info )
    {
        preg_match ( "@([a-z ]*)(\(([0-9]*)\))?@", $type_info, $matches );
        if ( isset( $matches[3] ) )
        {
            $length_info = $matches[3];
            if ( is_numeric( $length_info ) )
                $length_info = (int)$length_info;
        }
        $type = self::convertToStandardType ( $matches[1], $length_info );
        return $type;
    }

    protected static function convertToStandardType( $type, &$length )
    {
        switch ( $type )
        {
            case 'bigint':
            {
                return 'int';
            } break;
            case 'integer':
            {
                $length = 11;
                return 'int';
            } break;
            case 'character varying':
            {
                return 'varchar';
            } break;
            case 'text':
            {
                return 'longtext';
            } break;
            case 'double precision':
            {
                return 'float';
            } break;
            case 'character':
            {
                $lenght = 1;
                return 'char';
            } break;
            case 'timestamp without time zone':
            {
                return 'timestamp';
            } break;
            case 'date':
            {
                return 'date';
            } break;
            case 'time without time zone':
            {
                return 'time';
            } break;
        default:
            throw new ezcDbSchemaException(
                ezcDbSchemaException::GENERIC_ERROR,
                "UNHANDLED TYPE: '$type'" );
        }
    }

    protected static function convertFromStandardType( $type, &$length )
    {
        switch ( $type )
        {
            case 'char':
            {
                if ( $length == 1 )
                {
                    return 'character';
                }
                else
                {
                    return 'character varying';
                }
            } break;
            case 'int':
            {
                return 'integer';
            } break;
            case 'varchar':
            {
                return 'character varying';
            } break;
            case 'longtext':
            {
                return 'text';
            } break;
            case 'mediumtext':
            {
            return 'text';
            } break;
            case 'text':
            {
                return 'text';
            } break;
            case 'float':
            case 'double':
            {
                return 'double precision';
            } break;
            case 'timestamp':
            {
                return 'timestamp without time zone';
            } break;
            case 'date':
            {
                return 'date';
            } break;
            case 'time':
            {
                return 'time without time zone';
            } break;

        default:
            throw new ezcDbSchemaException(
                ezcDbSchemaException::GENERIC_ERROR,
                "UNHANDLED TYPE: '$type'" );
        }
    }

    protected static function parseDefault( &$fieldSchema, $default )
    {
        if ( preg_match( "@^nextval\('([a-z_]+_s)'::text\)$@", $default, $matches ) )
        {
            $fieldSchema['options']['default_nextval'] = $matches[1];
            return false;
        }

        if ( preg_match( "@^\(?([^()]*)\)?::double precision@", $default, $matches ) )
        {
            return $matches[1];
        }

        if ( preg_match( "@^(.*)::bigint@", $default, $matches ) )
        {
            return $matches[1];
        }

        if ( preg_match( "@^'(.*)'::character\ varying$@", $default, $matches ) )
        {
            return $matches[1];
        }

        if ( preg_match( "@^'(.*)'::[a-zA-Z ]+$@", $default, $matches ) )
        {
            return $matches[1];
        }

        if ( preg_match( "@^'(.*)'$@", $default, $matches ) )
        {
            return $matches[1];
        }

        return $default;
    }

    /**
     * The name will consist of the table name and _pkey, since it is only allowed
     * to have one primary key pre table that shouldn't be a problem.
     *
     * @return A string representing the name of the primary key index.
     */
    protected static function primaryKeyIndexName( $tableName, $indexName, $fields )
    {
        return $tableName . '_pkey';
    }

    /**
     * Dump specified schema as an array of SQL queries.
     *
     * @throws ezcDbSchemaException::GENERIC_ERROR if there's no schema
     *         to generate SQL queries for.
     * @return array The queries.
     * @static
     */
    protected function generateSchemaAsSQL( $schema )
    {
        if ( !isset( $schema['schema'] ) )
             throw new ezcDbSchemaException( ezcDbSchemaException::GENERIC_ERROR,
                                             'You should load schema before using it.' );

        $queries = array();

        // create sequences (if any)
        if ( isset( $schema['schema']['sequences'] ) )
        {
            foreach ( $schema['schema']['sequences'] as $seqName => $seqSchema )
                $queries[] = self::generateCreateSequenceSql( $seqName, $seqSchema );
        }

        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
        {
            // dump table
            $queries = array_merge( $queries, $this->generateCreateTableSql( $tableName, $tableSchema ) );


            /*// dump table indexes
            *foreach ( $tableSchema['indexes'] as $indexName => $indexSchema )
            *{
            *    $queries[] = self::generateAddIndexSql( $tableName, $indexName, $indexSchema );
            *}*/

        }

        return $queries;
    }

    protected static function generateFieldSql( $table_name, $field_name, $def, $params = array() )
    {
        $add_default_not_null = true;
        $diffFriendly = isset( $params['diff_friendly'] ) ? $params['diff_friendly'] : false;

        if ( in_array( $field_name, self::reservedKeywordList() ) )
        {
            $sql_def = '"' . $field_name . '"';
        }
        else
        {
            $sql_def = $field_name;
        }

        $sql_def .= ( $diffFriendly ? "\n    " : " " );
        if ( $def['type'] != 'auto_increment' )
        {
            $pgType = self::convertFromStandardType( $def['type'], $def['length'] );
            $sql_def .= $pgType;
            if ( self::isTypeLengthSupported( $pgType ) and isset( $def['length'] ) && $def['length'] )
            {
                $sql_def .= "({$def['length']})";
            }
            if ( $add_default_not_null )
            {
                $defaultDef = self::generateDefaultDef( false, false, $def, $params );
                if ( $defaultDef )
                {
                    $sql_def .= ( $diffFriendly ? "\n    " : " " );
                    $sql_def .= rtrim( $defaultDef );
                }
                $nullDef = self::generateNullDef( false, false, $def, $params );
                if ( $nullDef )
                {
                    $sql_def .= ( $diffFriendly ? "\n    " : " " );
                    $sql_def .= trim( $nullDef );
                }
            }
        }
        else
        {
            if ( $diffFriendly )
            {
                $sql_def .= "integer\n    DEFAULT nextval('{$table_name}_s'::text)\n    NOT NULL";
            }
            else
            {
                $sql_def .= "integer DEFAULT nextval('{$table_name}_s'::text) NOT NULL";
            }
        }
        return $sql_def;
    }

    /*!
     \return An array with keywords that are reserved by PostgreSQL.
    */
    protected static function reservedKeywordList()
    {
        return array( 'abort',
                      'absolute',
                      'access',
                      'action',
                      'add',
                      'after',
                      'aggregate',
                      'all',
                      'alter',
                      'analyse',
                      'analyze',
                      'and',
                      'any',
                      'as',
                      'asc',
                      'assertion',
                      'assignment',
                      'at',
                      'authorization',
                      'backward',
                      'before',
                      'begin',
                      'between',
                      'bigint',
                      'binary',
                      'bit',
                      'boolean',
                      'both',
                      'by',
                      'cache',
                      'called',
                      'cascade',
                      'case',
                      'cast',
                      'chain',
                      'char',
                      'character',
                      'characteristics',
                      'check',
                      'checkpoint',
                      'class',
                      'close',
                      'cluster',
                      'coalesce',
                      'collate',
                      'column',
                      'comment',
                      'commit',
                      'committed',
                      'constraint',
                      'constraints',
                      'conversion',
                      'convert',
                      'copy',
                      'create',
                      'createdb',
                      'createuser',
                      'cross',
                      'current_date',
                      'current_time',
                      'current_timestamp',
                      'current_user',
                      'cursor',
                      'cycle',
                      'database',
                      'day',
                      'deallocate',
                      'dec',
                      'decimal',
                      'declare',
                      'default',
                      'deferrable',
                      'deferred',
                      'definer',
                      'delete',
                      'delimiter',
                      'delimiters',
                      'desc',
                      'distinct',
                      'do',
                      'domain',
                      'double',
                      'drop',
                      'each',
                      'else',
                      'encoding',
                      'encrypted',
                      'end',
                      'escape',
                      'except',
                      'exclusive',
                      'execute',
                      'exists',
                      'explain',
                      'external',
                      'extract',
                      'false',
                      'fetch',
                      'float',
                      'for',
                      'force',
                      'foreign',
                      'forward',
                      'freeze',
                      'from',
                      'full',
                      'function',
                      'get',
                      'global',
                      'grant',
                      'group',
                      'handler',
                      'having',
                      'hour',
                      'ilike',
                      'immediate',
                      'immutable',
                      'implicit',
                      'in',
                      'increment',
                      'index',
                      'inherits',
                      'initially',
                      'inner',
                      'inout',
                      'input',
                      'insensitive',
                      'insert',
                      'instead',
                      'int',
                      'integer',
                      'intersect',
                      'interval',
                      'into',
                      'invoker',
                      'is',
                      'isnull',
                      'isolation',
                      'join',
                      'key',
                      'lancompiler',
                      'language',
                      'leading',
                      'left',
                      'level',
                      'like',
                      'limit',
                      'listen',
                      'load',
                      'local',
                      'localtime',
                      'localtimestamp',
                      'location',
                      'lock',
                      'match',
                      'maxvalue',
                      'minute',
                      'minvalue',
                      'mode',
                      'month',
                      'move',
                      'names',
                      'national',
                      'natural',
                      'nchar',
                      'new',
                      'next',
                      'no',
                      'nocreatedb',
                      'nocreateuser',
                      'none',
                      'not',
                      'nothing',
                      'notify',
                      'notnull',
                      'null',
                      'nullif',
                      'numeric',
                      'of',
                      'off',
                      'offset',
                      'oids',
                      'old',
                      'on',
                      'only',
                      'operator',
                      'option',
                      'or',
                      'order',
                      'out',
                      'outer',
                      'overlaps',
                      'overlay',
                      'owner',
                      'partial',
                      'password',
                      'path',
                      'pendant',
                      'placing',
                      'position',
                      'precision',
                      'prepare',
                      'primary',
                      'prior',
                      'privileges',
                      'procedural',
                      'procedure',
                      'read',
                      'real',
                      'recheck',
                      'references',
                      'reindex',
                      'relative',
                      'rename',
                      'replace',
                      'reset',
                      'restrict',
                      'returns',
                      'revoke',
                      'right',
                      'rollback',
                      'row',
                      'rule',
                      'schema',
                      'scroll',
                      'second',
                      'security',
                      'select',
                      'sequence',
                      'serializable',
                      'session',
                      'session_user',
                      'set',
                      'setof',
                      'share',
                      'show',
                      'similar',
                      'simple',
                      'smallint',
                      'some',
                      'stable',
                      'start',
                      'statement',
                      'statistics',
                      'stdin',
                      'stdout',
                      'storage',
                      'strict',
                      'substring',
                      'sysid',
                      'table',
                      'temp',
                      'template',
                      'temporary',
                      'then',
                      'time',
                      'timestamp',
                      'to',
                      'toast',
                      'trailing',
                      'transaction',
                      'treat',
                      'trigger',
                      'trim',
                      'true',
                      'truncate',
                      'trusted',
                      'type',
                      'unencrypted',
                      'union',
                      'unique',
                      'unknown',
                      'unlisten',
                      'until',
                      'update',
                      'usage',
                      'user',
                      'using',
                      'vacuum',
                      'valid',
                      'validator',
                      'values',
                      'varchar',
                      'varying',
                      'verbose',
                      'version',
                      'view',
                      'volatile',
                      'when',
                      'where',
                      'with',
                      'without',
                      'work',
                      'write',
                      'year',
                      'zone' );
    }

    protected static function generateDefaultDef( $table_name, $field_name, $def, $params )
    {
        $postgresqlCompatible = isset( $params['compatible_sql'] ) ? $params['compatible_sql'] : false;
        $sql_def = '';
        if ( $table_name and $field_name )
        {
            $sql_def .= "ALTER TABLE $table_name ALTER $field_name SET ";
        }
        if ( array_key_exists( 'default', $def ) and
             $def['default'] !== false )
        {
            if ( $def['default'] === null )
            {
                if ( !$postgresqlCompatible )
                    $sql_def .= "DEFAULT NULL ";
            }
            else if ( $def['default'] !== false )
            {
                if ( is_array( $def['default'] ) )
                {
                    $nextval = $def['default'];
                    $procname = $nextval[1];
                    $seqname  = $nextval[2];
                    $sql_def .= "DEFAULT $procname('$seqname')";
                }
                elseif ( $def['type'] == 'int' )
                {
                    $sql_def .= "DEFAULT {$def['default']} ";
                }
                else if ( $def['type'] == 'float' )
                {
                    $sql_def .= "DEFAULT {$def['default']}::double precision ";
                }
                else if ( $def['type'] == 'varchar' )
                {
                    $sql_def .= "DEFAULT '{$def['default']}'::character varying ";
                }
                else if ( $def['type'] == 'char' )
                {
                    $sql_def .= "DEFAULT '{$def['default']}'::bpchar ";
                }
                else
                {
                    $sql_def .= "DEFAULT '{$def['default']}' ";
                }
            }
        }
        else if ( $table_name and $field_name )
        {
            return false;
        }
        return $sql_def;
    }

    protected static function generateNullDef( $table_name, $field_name, $def, $params )
    {
        $sql_def = '';
        if ( $table_name and $field_name )
        {
            $sql_def .= "ALTER TABLE $table_name ALTER $field_name SET ";
        }
        if ( isset( $def['not_null'] ) && ( $def['not_null'] ) )
        {
            $sql_def .= 'NOT NULL ';
        }
        else if ( $table_name and $field_name )
        {
            return false;
        }
        return $sql_def;
    }

    protected static function isTypeLengthSupported( $pgType )
    {
        switch ( $pgType )
        {
            case 'integer':
            case 'double precision':
            case 'real':
            {
                return false;
            } break;
        }
        return true;
    }

    protected static function generateDataAsSQL( $schema )
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
                    $valStrings[] = self::generateDataValueTextSQL( $fieldsDef[$i], $val );;
                $values = join( ',', $valStrings );
                $query = "INSERT INTO $tableName VALUES ($values)";
                $queries[] = $query;
            }
        }

        return $queries;
    }

    protected static function generateDataValueTextSQL( $fieldDef, $value )
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

    protected static function generateUpdateSequencesSQL( $schema )
    {
        $updateSeqQueries = array();
        foreach ( $schema['schema']['tables'] as $tableName => $tableSchema )
        {
            foreach ( $tableSchema['fields'] as $fieldName => $fieldSchema )
            {
                // if the field is actually an auto-increment field
                if ( is_array( $fieldSchema['default'] )  &&
                     count( $fieldSchema['default'] ) > 0 &&
                     $fieldSchema['default'][0] == 'sequence' )
                {
                    $seqName  = $fieldSchema['default'][2];
                    $query = "SELECT pg_catalog.setval('$seqName', max($fieldName)) FROM $tableName";
                    $updateSeqQueries[] = $query;
                }
            }
        }

        return $updateSeqQueries;
    }

    protected static function generateCreateSequenceSql( $seqName, $seqSchema )
    {
        return "CREATE SEQUENCE $seqName";
    }

    /**
     * Actually transfer data [source].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function transfer( $storage, $storageType, $dstHandler )
    {
        $db = $storage;
        $rsltTables = $db->query( "SELECT tablename FROM pg_tables WHERE tablename NOT LIKE 'pg_%'" );
        $rsltTables->setFetchMode( PDO::FETCH_NUM );
        $tables = $rsltTables->fetchAll();
        unset( $rsltTables );
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


    /**
     * Prepare destination handler for transfer [destination].
     *
     * @see ezcDbSchemaHandlerDataTransfer
     */
    public function openTransferDestination( $storage, $storageType )
    {
        $this->currentTableBeingStored = null;

        if ( $storageType == 'pgsql-db' )
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

            // update sequences values
            /*$updateSeqQueries = $this->generateUpdateSequencesSQL( $schema );
            foreach ( $updateSeqQueries as $query )
                $db->exec( $query );*/
        }
        else
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
            $this->storage->query( $query );
        else
            fputs( $this->storage, $query );
    }


    //------------- Delta handling methods ---------------

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
            $fieldsSQL[] = '  ' . self::generateFieldSQL( $tableName, $fieldName, $fieldSchema );

        $createTableSql .= join( ",\n", $fieldsSQL ) . "\n)";

        $sqls[] = $createTableSql;


        // dump table indexes
        foreach ( $tableSchema['indexes'] as $indexName => $indexSchema )
        {
            $createIndexSQL = '  ' .
                self::generateAddIndexSql( $tableName, $indexName, $indexSchema,
                                           array(), true );
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
        return "DROP TABLE $tableName;\n";
    }

    /**
     * Generate SQL query for adding a table field.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateAddFieldSql()
     */
    protected function generateAddFieldSql( $tableName, $fieldName, $fieldSchema, $params = array() )
    {
        $table_name = $tableName;
        $field_name = $fieldName;
        $def        = $fieldSchema;

        $sql = "ALTER TABLE $table_name ADD COLUMN ";
        $sql .= $this->generateFieldSql( $table_name, $field_name, $def, false, $params ) . ";\n";
        $defaultSQL = $this->generateDefaultDef( $table_name, $field_name, $def, $params );
        if ( $defaultSQL )
            $sql .= $defaultSQL . ";\n";
        $nullSQL = $this->generateNullDef( $table_name, $field_name, $def, $params );
        if ( $nullSQL )
            $sql .= $nullSQL . ";\n";
        $sql .= "\n";
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
        $table_name = $tableName;
        $field_name = $fieldName;
        $def        = $fieldSchema;
        $params     = $diffParams;

        $sql = "ALTER TABLE $table_name RENAME COLUMN $field_name TO " . $field_name . "_tmp;\n";
        $sql .= "ALTER TABLE $table_name ADD COLUMN ";
        $sql .= $this->generateFieldSql( $table_name, $field_name, $def, false, $params ) . ";\n";
        $defaultSQL = $this->generateDefaultDef( $table_name, $field_name, $def, $params );
        if ( $defaultSQL )
            $sql .= $defaultSQL . ";\n";
        $nullSQL = $this->generateNullDef( $table_name, $field_name, $def, $params );
        if ( $nullSQL )
            $sql .= $nullSQL . ";\n";
        $sql .= "UPDATE $table_name SET $field_name=" . $field_name . "_tmp;\n";
        $sql .= "ALTER TABLE $table_name DROP COLUMN " . $field_name . "_tmp;\n\n";
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
    protected function generateAddIndexSql( $tableName, $indexName, $indexSchema, $params = array(), $isEmbedded = false  )
    {
        $def         = $indexSchema;
        $table_name  = $tableName;
        $index_name  = $indexName;
        $withClosure = false; // we don't need trailing semicolons

        $diffFriendly = false;
        $postgresqlCompatible = false;
        $spacing = $postgresqlCompatible ? "\n    " : " ";

        switch ( $def['type'] )
        {
            case 'primary':
            {
                $pkeyName = self::primaryKeyIndexName( $table_name, $index_name, $def['fields'] );
                if ( strlen( $pkeyName ) > 63 )
                {
                    trigger_error( "The primary key '$pkeyName' (" .
                                   strlen( $pkeyName ) . ") " .
                                   "exceeds 63 characters " .
                                   "which is the PostgreSQL limit for names", E_USER_ERROR );
                }
                $sql = "ALTER TABLE ONLY $table_name" . $spacing . "ADD CONSTRAINT $pkeyName PRIMARY KEY";
            } break;

            case 'non-unique':
            {
                $sql = "CREATE INDEX $index_name ON $table_name USING btree";
            } break;

            case 'unique':
            {
                $sql = "CREATE UNIQUE INDEX $index_name ON $table_name USING btree";
            } break;
        }

        $sql .= ( $postgresqlCompatible ? ' (' : ' ( ' );
        $i = 0;
        foreach ( $def['fields'] as $fieldDef )
        {
            if ( $i > 0 )
            {
                $sql .= $diffFriendly ? ",\n    " : ', ';
            }
            if ( is_array( $fieldDef ) )
            {
                $fieldName = $fieldDef['name'];
            }
            else
            {
                $fieldName = $fieldDef;
            }
            if ( in_array( $fieldName, self::reservedKeywordList() ) )
            {
                $sql .= '"' . $fieldName . '"';
            }
            else
            {
                $sql .= $fieldName;
            }
            ++$i;
        }

        $sql .= ( $diffFriendly ? "\n)" : ( $postgresqlCompatible ? ')' : ' )' ) );

        return $sql . ( $withClosure ? ";\n" : "" );
    }

    /**
     * Generate drop index SQL query.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateDropIndexSql()
     */
    protected function generateDropIndexSql( $tableName, $indexName, $indexSchema, $params = array() )
    {
        if ( $indexSchema['type'] == 'primary' )
            $sql = "ALTER TABLE $tableName DROP CONSTRAINT $indexName";
        else
            $sql = "DROP INDEX $indexName";

        return $sql;
    }

}

?>
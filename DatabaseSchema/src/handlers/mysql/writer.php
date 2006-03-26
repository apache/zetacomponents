<?php
/**
 * File containing the ezcDbSchemaMysqlWriter class.
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
class ezcDbSchemaMysqlWriter implements ezcDbSchemaDbWriter
{
    static private $typeMap = array(
        'integer' => 'bigint',
        'boolean' => 'boolean',
        'float' => 'double',
        'decimal' => 'numeric',
        'date' => 'date',
        'timestamp' => 'timestamp',
        'text' => 'varchar',
        'blob' => 'longblob',
        'clob' => 'longtext'
    );

    /**
     */
    public function getWriterType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Save schema to an .php file
     */
    public function saveToDb( ezcDbHandler $db, ezcDbSchema $dbSchema )
    {
        $this->schema = $dbSchema->getSchema();
        $data = $dbSchema->getData();

        // reset queries
        $this->queries = array();
        $this->context = array();

        $this->generateSchemaAsSql();
        foreach ( $this->queries as $query )
        {
            $db->query( $query );
        }
    }

    /**
     * Get schema as database specific DDL
     *
     * @returns array
     */
    public function convertToDDL( ezcDbSchema $dbSchema )
    {
        $this->schema = $dbSchema->getSchema();

        // reset queries
        $this->queries = array();
        $this->context = array();

        $this->generateSchemaAsSql();
        return $this->queries;
    }

    /**
     * Dump specified schema as an array of SQL queries.
     *
     * @return array The queries.
     */
    private function generateSchemaAsSql()
    {
        foreach ( $this->schema as $tableName => $tableDefinition )
        {
            $this->generateCreateTableSql( $tableName, $tableDefinition );
        }
    }

    /**
     * Generate SQL queries for table creation.
     */
    private function generateCreateTableSql( $tableName, ezcDbSchemaTable $tableDefinition )
    {
        $sql = '';

        $this->queries[] = "DROP TABLE IF EXISTS $tableName";
        
        $sql .= "CREATE TABLE $tableName (\n";

        // dump fields
        $fieldsSQL = array();

        foreach ( $tableDefinition->fields as $fieldName => $fieldDefinition )
        {
            $fieldsSQL[] = "\t" . $this->generateFieldSql( $fieldName, $fieldDefinition );
        }

        $sql .= join( ",\n", $fieldsSQL );

        $sql .= "\n)";

        $this->queries[] = $sql;

        // dump indexes
        foreach ( $tableDefinition->indexes as $indexName => $indexDefinition)
        {
            $fieldsSQL[] = $this->generateAddIndexSql( $tableName, $indexName, $indexDefinition );
        }

    }

    static function convertFromGenericType( ezcDbSchemaField $fieldDefinition )
    {
        $typeAddition = '';
        if ( in_array( $fieldDefinition->type, array( 'numeric', 'text' ) ) )
        {
            if ( $fieldDefinition->length !== false && $fieldDefinition->length !== 0 )
            {
                $typeAddition = "({$fieldDefinition->length})";
            }
        }
        if ( $fieldDefinition->type == 'text' && !$fieldDefinition->length )
        {
            $typeAddition = "(255)";
        }

        $type = self::$typeMap[$fieldDefinition->type];

        return "$type$typeAddition";
    }

    /**
     * Dumps field schema as part of a DDL query.
     * @param   string $fieldName   Field name.
     * @param   array  $fieldSchema Field schema.
     * @return string              Field schema in SQL.
     */
    private function generateFieldSql( $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        $sqlDefinition = $fieldName . ' ';

        $defList = array();

        $type = self::convertFromGenericType( $fieldDefinition );
        $defList[] = $type;

        if ( $fieldDefinition->notNull )
        {
            $defList[] = 'NOT NULL';
        }

        if ( $fieldDefinition->autoIncrement )
        {
            $defList[] = "AUTO_INCREMENT PRIMARY KEY";
            $this->context['skip_primary'] = true;
        }
        
        if ( !is_null( $fieldDefinition->default ) && !$fieldDefinition->autoIncrement )
        {
            $default = $this->generateDefault( $fieldDefinition->type, $fieldDefinition->default );
            $defList[] = "DEFAULT $default";
        }

        $sqlDefinition .= join( ' ', $defList );

        return $sqlDefinition;
    }

    /**
     * Generate index creation SQL query.
     *
     * @return string The query.
     * @see ezcDbSchemaHandlerSql::generateAddIndexSql()
     */
    protected function generateAddIndexSql( $tableName, $indexName, ezcDbSchemaIndex $indexDefinition )
    {
        $sql = "ALTER TABLE $tableName ADD ";

        if ( $indexDefinition->primary )
        {
            if ( $this->context['skip_primary'] )
            {
                return;
            }
            $sql .= 'PRIMARY KEY';
        }
        else if ( $indexDefinition->unique )
        {
            $sql .= "UNIQUE $indexName";
        }
        else
        {
            $sql .= "INDEX $indexName";
        }

        $sql .= " ( ";

        $indexFieldSql = array();
        foreach ( $indexDefinition->indexFields as $indexFieldName => $IndexFieldDefinition )
        {
            if ( in_array( $this->schema[$tableName]->fields[$indexFieldName]->type, array( 'blob', 'clob' ) ) )
            {
                $indexFieldSql[] = "{$indexFieldName}(250)";
            }
            else
            {
                $indexFieldSql[] = "$indexFieldName";
            }
        }
        $sql .= join( ', ', $indexFieldSql ) . " )";

        $this->queries[] = $sql;
    }

    private function generateDefault( $type, $value )
    {
        switch ( $type )
        {
            case 'boolean':
                return $value ? 'true' : 'false';

            case 'integer':
                return (int) $value;

            case 'float':
            case 'decimal':
                return (float) $value;

            case 'timestamp':
                return (int) $value;

            default:
                return "'$value'";
        }
    }
}
?>

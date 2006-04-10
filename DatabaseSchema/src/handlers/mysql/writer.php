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
class ezcDbSchemaMysqlWriter extends ezcDbSchemaCommonSqlWriter implements ezcDbSchemaDbWriter, ezcDbSchemaDiffDbWriter
{
    private $typeMap = array(
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
        foreach ( $this->convertToDDL( $dbSchema ) as $query )
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
     */
    public function getDiffWriterType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Save schema to an .php file
     */
    public function applyDiffToDb( ezcDbHandler $db, ezcDbSchemaDiff $dbSchemaDiff )
    {
        $db->query( "BEGIN" );
        foreach ( $this->convertDiffToDDL( $dbSchemaDiff ) as $query )
        {
            $db->query( $query );
        }
        $db->query( "COMMIT" );
    }

    /**
     * Get schema as database specific DDL
     *
     * @returns array
     */
    public function convertDiffToDDL( ezcDbSchemaDiff $dbSchemaDiff )
    {
        $this->diffSchema = $dbSchemaDiff;

        // reset queries
        $this->queries = array();
        $this->context = array();

        $this->generateDiffSchemaAsSql();
        return $this->queries;
    }

    protected function generateDropTableSql( $tableName )
    {
        $this->queries[] = "DROP TABLE IF EXISTS $tableName";
    }

    protected function convertFromGenericType( ezcDbSchemaField $fieldDefinition )
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

        $type = $this->typeMap[$fieldDefinition->type];

        return "$type$typeAddition";
    }

    protected function generateAddFieldSql( $tableName, $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        $this->queries[] = "ALTER TABLE $tableName ADD " . $this->generateFieldSql( $fieldName, $fieldDefinition );
    }

    protected function generateChangeFieldSql( $tableName, $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        $this->queries[] = "ALTER TABLE $tableName CHANGE $fieldName " . $this->generateFieldSql( $fieldName, $fieldDefinition );
    }

    protected function generateDropFieldSql( $tableName, $fieldName )
    {
        $this->queries[] = "ALTER TABLE $tableName DROP $fieldName";
    }

    /**
     * Dumps field schema as part of a DDL query.
     * @param   string $fieldName   Field name.
     * @param   array  $fieldSchema Field schema.
     * @return string              Field schema in SQL.
     */
    protected function generateFieldSql( $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        $sqlDefinition = $fieldName . ' ';

        $defList = array();

        $type = $this->convertFromGenericType( $fieldDefinition );
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

    protected function generateDropIndexSql( $tableName, $indexName )
    {
        $this->queries[] = "ALTER TABLE $tableName DROP INDEX `$indexName`";
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
            if ( isset( $this->context['skip_primary'] ) && $this->context['skip_primary'] )
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
        foreach ( $indexDefinition->indexFields as $indexFieldName => $dummy )
        {
            if ( isset( $this->schema[$tableName] ) &&
                isset( $this->schema[$tableName]->fields[$indexFieldName] ) &&
                isset( $this->schema[$tableName]->fields[$indexFieldName]->type ) &&
                in_array( $this->schema[$tableName]->fields[$indexFieldName]->type, array( 'blob', 'clob' ) ) )
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
}
?>

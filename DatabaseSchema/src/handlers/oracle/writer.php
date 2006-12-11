<?php
/**
 * File containing the ezcDbSchemaOracleWriter class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for storing database schemas and applying differences that uses Oracle as backend.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaOracleWriter extends ezcDbSchemaCommonSqlWriter implements ezcDbSchemaDbWriter, ezcDbSchemaDiffDbWriter
{
    /**
     * Contains a type map from DbSchema types to Oracle native types.
     *
     * @var array
     */
    private $typeMap = array(
        'integer' => 'number',
        'boolean' => 'char',
        'float' => 'float',
        'decimal' => 'number',
        'date' => 'date',
        'timestamp' => 'timestamp',
        'text' => 'varchar2',
        'blob' => 'blob',
        'clob' => 'clob'
    );

    /**
     * Returns what type of schema writer this class implements.
     *
     * This method always returns ezcDbSchema::DATABASE
     *
     * @return int
     */
    public function getWriterType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Creates tables defined in $dbSchema in the database referenced by $db.
     *
     * This method uses {@link convertToDDL} to create SQL for the schema
     * definition and then executes the return SQL statements on the database
     * handler $db.
     *
     * @todo check for failed transaction
     *
     * @param ezcDbHandler $db
     * @param ezcDbSchema  $dbSchema
     */
    public function saveToDb( ezcDbHandler $db, ezcDbSchema $dbSchema )
    {
        $db->beginTransaction();
        foreach ( $this->convertToDDL( $dbSchema ) as $query )
        {
            if ( $this->isQueryAllowed( $db, $query ) ) 
            {
                $db->exec( $query );
            }
        }
        $db->commit();
    }

    /**
     * Checks if query allowed.
     *
     * Perform testing if table exist for DROP TABLE query 
     * to avoid stoping execution while try to drop not existent table.
     * 
     * @param ezcDbHandler    $db
     * @param string $query
     * 
     *
     * @return boolean false if query should not be executed.
     */
    private function isQueryAllowed( ezcDbHandler $db, $query )
    {
        if ( strstr($query, 'AUTO_INCREMENT') ) //detect AUTO_INCREMENT and return imediately. Will process later.
        {
            return false;
        }

        if ( substr($query, 0, 10) == 'DROP TABLE' )
        {
            $tableName = substr($query, strlen( 'DROP TABLE "' ), -1 ); //get table name without quotes

            $result = $db->query( "SELECT count( table_name ) AS count FROM user_tables WHERE table_name='$tableName'" )->fetchAll();
            if ( $result[0]['count'] == 1 )
            {
                $sequences = $db->query( "SELECT sequence_name FROM user_sequences" )->fetchAll();
                array_walk( $sequences, create_function( '&$item,$key', '$item = $item[0];' ) );
                foreach ( $sequences as $sequenceName )
                {
                    //try to drop sequences related to dropped table.
                    if ( substr( $sequenceName, 0, strlen($tableName) ) == $tableName )
                    {
                        $db->query( "DROP SEQUENCE \"{$sequenceName}\"" );
                    }
                }
                return true;
            }
            else
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the definition in $dbSchema as database specific SQL DDL queries.
     *
     * @param ezcDbSchema $dbSchema
     *
     * @return array(string)
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
     * Returns what type of schema difference writer this class implements.
     *
     * This method always returns ezcDbSchema::DATABASE
     *
     * @return int
     */
    public function getDiffWriterType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Applies the differences defined in $dbSchemaDiff to the database referenced by $db.
     *
     * This method uses {@link convertDiffToDDL} to create SQL for the
     * differences and then executes the returned SQL statements on the
     * database handler $db.
     *
     * @todo check for failed transaction
     *
     * @param ezcDbHandler    $db
     * @param ezcDbSchemaDiff $dbSchemaDiff
     */
    public function applyDiffToDb( ezcDbHandler $db, ezcDbSchemaDiff $dbSchemaDiff )
    {
        $db->beginTransaction();
        foreach ( $this->convertDiffToDDL( $dbSchemaDiff ) as $query )
        {
            if ( $this->isQueryAllowed( $db, $query ) )
            {
                $db->exec( $query );
            }
            else
            {
                if ( strstr($query, 'AUTO_INCREMENT') ) //detect AUTO_INCREMENT and emulate it by adding sequence and trigger
                {
                    $db->commit();
                    $db->beginTransaction();
                    if ( preg_match ( "/ALTER TABLE (.*) MODYFY (.*) (.*) AUTO_INCREMENT/" , $query, $matches ) ) 
                    {
                        $tableName = $matches[1];
                        $autoIncrementFieldName = $matches[2];
                        $autoIncrementFieldType = $matches[3];
                        $this->addAutoIncrementField( $db, $tableName, $autoIncrementFieldName, $autoIncrementFieldType );
                    }
                }
                $db->commit();
                $db->beginTransaction();
            }
        }
        $db->commit();
    }

    /**
    * Performs changing field in Oracle table.
    * (workaround for "ALTER TABLE table MODIFY field fieldType AUTO_INCREMENT " that not alowed in Oracle ).
    * 
    * @param ezcDbHandler    $db
    * @param string          $tableName
    * @param string          $autoIncrementFieldName
    * @param string          $autoIncrementFieldType
    */
    private function addAutoIncrementField( $db, $tableName, $autoIncrementFieldName, $autoIncrementFieldType )
    {
        //fetching field info from Oracle, getting column position of autoincrement field
        $resultArray = $this->db->query( "SELECT   a.column_name AS field, " .    
                                         "         a.column_id AS field_pos " .
                                         "FROM     user_tab_columns a " .
                                         "WHERE    a.table_name = '{$tableName}' AND a.column_name = '{$autoIncrementFieldName}'" .
                                         "ORDER BY a.column_id" );
        $resultArray->setFetchMode( PDO::FETCH_ASSOC );

        if ( count ($resultArray) != 1 )
        {
            return;
        }

        $fieldPos = $resultArray[0]['field_pos'];

        //emulation of autoincrement through adding sequence, trigger and constraint
        $sequence = $this->db->query( "SELECT sequence_name FROM user_sequences WHERE sequence_name = '{$tableName}_{$fieldPos}_seq'" )->fetchAll();
        if ( count ($sequence) > 0  )
        {
            $db->query( "DROP SEQUENCE \"{$sequenceName}\"" );
        }

        $db->exec( "CREATE SEQUENCE \"{$tableName}_{$fieldPos}_seq\" start with 1 increment by 1 nomaxvalue" );
        $db->exec( "CREATE OR REPLACE TRIGGER \"{$tableName}_{$fieldPos}_trg\" ".
                                  "before insert on \"{$tableName}\" for each row ".
                                  "begin ".
                                  "select \"{$tableName}_{$fieldPos}_seq\".nextval into :new.\"{$fieldName}\" from dual; ".
                                  "end;" );

        $constraint = $this->db->query( "SELECT constraint_name FROM user_cons_columns WHERE constraint_name = '{$tableName}_pkey'" )->fetchAll();
        if ( count ($constraint) > 0  )
        {
            $db->query( "ALTER TABLE \"$tableName\" DROP CONSTRAINT \"{$tableName}_pkey\"" );
        }
        $db->exec( "ALTER TABLE \"{$tableName}\" ADD CONSTRAINT \"{$tableName}_pkey\" PRIMARY KEY ( \"{$fieldName}\" )" );
        $this->context['skip_primary'] = true;
    }

    /**
     * Returns the differences definition in $dbSchema as database specific SQL DDL queries.
     *
     * @param ezcDbSchema $dbSchema
     *
     * @return array(string)
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

    /**
     * Adds a "drop table" query for the table $tableName to the internal list of queries.
     *
     * @param string $tableName
     */
    protected function generateDropTableSql( $tableName )
    {
        $this->queries[] = "DROP TABLE \"$tableName\"";
    }

    /**
     * Converts the generic field type contained in $fieldDefinition to a database specific field definition.
     *
     * @param ezcDbSchemaField $fieldDefinition
     * @return string
     */
    protected function convertFromGenericType( ezcDbSchemaField &$fieldDefinition )
    {
        $typeAddition = '';
        if ( in_array( $fieldDefinition->type, array( 'decimal', 'text' ) ) )
        {
            if ( $fieldDefinition->length !== false && $fieldDefinition->length !== 0 )
            {
                $typeAddition = "({$fieldDefinition->length})";
            } 
            else
            {
                $typeAddition = "(4000)"; //default length for varchar2 in Oracle
            }
        }
        if ( $fieldDefinition->type == 'boolean' )
        {
            $typeAddition = "(1)";
            if ( $fieldDefinition->default )
            {
                $fieldDefinition->default = ( $fieldDefinition->default == 'true' ) ? '1': '0';
            }
        }

        $type = $this->typeMap[$fieldDefinition->type];

        return "$type$typeAddition";
    }

    /**
     * Adds a "create table" query for the table $tableName with 
     * definition $tableDefinition to the internal list of queries.
     * 
     * Adds additional CREATE queries for sequences and triggers
     * to implement autoincrement fields that not supported in Oracle directly.
     * 
     * @param string           $tableName
     * @param ezcDbSchemaTable $tableDefinition
     */
    protected function generateCreateTableSql( $tableName, ezcDbSchemaTable $tableDefinition )
    {
        $sql = '';
        $sql .= "CREATE TABLE \"{$tableName}\" (\n";
        $this->context['skip_primary'] = false;

        // dump fields
        $fieldsSQL = array();
        $autoincrementSQL = array();
        $fieldCounter = 1;

        foreach ( $tableDefinition->fields as $fieldName => $fieldDefinition )
        {
            $fieldsSQL[] = "\t" . $this->generateFieldSql( $fieldName, $fieldDefinition );

            if ( $fieldDefinition->autoIncrement && !$this->context['skip_primary'] )
            {
                $autoincrementSQL[] = "CREATE SEQUENCE \"{$tableName}_{$fieldCounter}_seq\" start with 1 increment by 1 nomaxvalue";
                $autoincrementSQL[] = "CREATE OR REPLACE TRIGGER \"{$tableName}_{$fieldCounter}_trg\" ".
                                          "before insert on \"{$tableName}\" for each row ".
                                          "begin ".
                                          "select \"{$tableName}_{$fieldCounter}_seq\".nextval into :new.\"{$fieldName}\" from dual; ".
                                          "end;";
                $autoincrementSQL[] = "ALTER TABLE \"{$tableName}\" ADD CONSTRAINT \"{$tableName}_pkey\" PRIMARY KEY ( \"{$fieldName}\" )";
                $this->context['skip_primary'] = true;
            }
            $fieldCounter++;
        }

        $sql .= join( ",\n", $fieldsSQL );
        $sql .= "\n)";

        $this->queries[] = $sql;

        if ( count( $autoincrementSQL ) > 0 ) //adding autoincrement emulation queries if exists
        {
            $this->queries = array_merge( $this->queries, $autoincrementSQL );
        }

        // dump indexes
        foreach ( $tableDefinition->indexes as $indexName => $indexDefinition)
        {
            $fieldsSQL[] = $this->generateAddIndexSql( $tableName, $indexName, $indexDefinition );
        }
    }

    /**
     * Generates queries to upgrade a the table $tableName with the differences in $tableDiff.
     *
     * This method generates queries to migrate a table to a new version
     * with the changes that are stored in the $tableDiff property. It
     * will call different subfunctions for the different types of changes, and
     * those functions will add queries to the internal list of queries that is
     * stored in $this->queries.
     *
     * @param string $tableName
     * @param string $tableDiff
     */
    protected function generateDiffSchemaTableAsSql( $tableName, ezcDbSchemaTableDiff $tableDiff )
    {
        $this->context['skip_primary'] = false;
        parent::generateDiffSchemaTableAsSql( $tableName, $tableDiff );
    }

    /**
     * Adds a "alter table" query to add the field $fieldName to $tableName with the definition $fieldDefinition.
     *
     * @param string           $tableName
     * @param string           $fieldName
     * @param ezcDbSchemaField $fieldDefinition
     */
    protected function generateAddFieldSql( $tableName, $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        $this->queries[] = "ALTER TABLE \"$tableName\" ADD " . $this->generateFieldSql( $fieldName, $fieldDefinition );
    }

    /**
     * Adds a "alter table" query to change the field $fieldName to $tableName with the definition $fieldDefinition.
     *
     * @param string           $tableName
     * @param string           $fieldName
     * @param ezcDbSchemaField $fieldDefinition
     */
    protected function generateChangeFieldSql( $tableName, $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        if ( !$fieldDefinition->autoIncrement )
        {
            $this->queries[] = "ALTER TABLE \"$tableName\" MODIFY " .
                               $this->generateFieldSql( $fieldName, $fieldDefinition );
        }
        else
        {    // mark query to make autoincrement emulation when executing
            $this->queries[] = "ALTER TABLE \"$tableName\" MODIFY " .
                               $this->generateFieldSql( $fieldName, $fieldDefinition ) .
                               " AUTO_INCREMENT";
        }
    }

    /**
     * Adds a "alter table" query to drop the field $fieldName from $tableName.
     *
     * @param string $tableName
     * @param string $fieldName
     */
    protected function generateDropFieldSql( $tableName, $fieldName )
    {
        $this->queries[] = "ALTER TABLE \"$tableName\" DROP COLUMN \"$fieldName\"";
    }

    /**
     * Returns a column definition for $fieldName with definition $fieldDefinition.
     *
     * @param  string           $fieldName
     * @param  ezcDbSchemaField $fieldDefinition
     * @param  string           $autoincrementField
     * @return string
     */
    protected function generateFieldSql( $fieldName, ezcDbSchemaField $fieldDefinition )
    {
        $sqlDefinition = '"'.$fieldName.'" ';
        $defList = array();

        $type = $this->convertFromGenericType( &$fieldDefinition );
        $defList[] = $type;

        if ( !is_null( $fieldDefinition->default ) && !$fieldDefinition->autoIncrement )
        {
            $default = $this->generateDefault( $fieldDefinition->type, $fieldDefinition->default );
            $defList[] = "DEFAULT $default";
        }

        if ( $fieldDefinition->notNull )
        {
            $defList[] = 'NOT NULL';
        }

        $sqlDefinition .= join( ' ', $defList );

        return $sqlDefinition;
    }

    /**
     * Returns an appropriate default value for $type with $value.
     *
     * @param string $type
     * @param mixed  $value
     * @return string
     */
    protected function generateDefault( $type, $value )
    {
        switch ( $type )
        {
            case 'boolean':
                return ( $value && $value != 'false' ) ? '1' : '0';

            case 'integer':
                return (int) $value;

            case 'float':
            case 'decimal':
                return (float) $value;

            default:
                return "'$value'";
        }
    }

    /**
     * Adds a "alter table" query to add the index $indexName to the table $tableName with definition $indexDefinition to the internal list of queries
     *
     * @param string           $tableName
     * @param string           $indexName
     * @param ezcDbSchemaIndex $indexDefinition
     */
    protected function generateAddIndexSql( $tableName, $indexName, ezcDbSchemaIndex $indexDefinition )
    {

        $sql = "";
        if ( $indexDefinition->primary )
        {
            if ( $this->context['skip_primary'] )
            {
                return;
            }
            $sql = "ALTER TABLE \"$tableName\" ADD CONSTRAINT \"{$tableName}_pkey\" PRIMARY KEY";
        }
        else if ( $indexDefinition->unique )
        {
            $sql = "CREATE UNIQUE INDEX \"$indexName\" ON \"$tableName\"";
        }
        else
        {
            $sql = "CREATE INDEX \"$indexName\" ON \"$tableName\"";
        }

        $sql .= " ( ";

        $indexFieldSql = array();
        foreach ( $indexDefinition->indexFields as $indexFieldName => $dummy )
        {
                $indexFieldSql[] = "\"$indexFieldName\"";
        }
        $sql .= join( ', ', $indexFieldSql ) . " )";

        $this->queries[] = $sql;
    }
    
    /**
     * Adds a "alter table" query to remote the index $indexName from the table $tableName to the internal list of queries.
     *
     * @param string           $tableName
     * @param string           $indexName
     */
    protected function generateDropIndexSql( $tableName, $indexName )
    {
        if ( $indexName == 'primary' ) //handling primary indexes
        {
            $this->queries[] = "ALTER TABLE \"$tableName\" DROP CONSTRAINT \"{$tableName}_pkey\"";
        }
        else
        {
            $this->queries[] = "DROP INDEX \"$indexName\"";
        }
    }
}
?>

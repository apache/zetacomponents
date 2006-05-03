<?php
/**
 * File containing the ezcDbSchemaPersistentReader class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler to read PersistentObject definitions and create DatabaseSchema from those.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaPersistentReader implements ezcDbSchemaFileReader
{

    private $schema;

    /**
     * Returns what type of reader writer this class implements.
     *
     * This method always returns ezcDbSchema::FILE
     *
     * @return int The type of this schema reader.
     */
    public function getReaderType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Returns the database schema stored in the PersistentObject definitions in $dir.
     *
     * @param string $file
     * @return ezcDbSchema
     *
     * @throws ezcBaseFileNotFoundException If the given directory could not be
     *                                      found.
     * @throws ezcBaseFilePermissionException If the given directory is not 
     *                                        writable.
     */
    public function loadFromFile( $dir )
    {
        if ( !is_dir( $dir ) ) 
        {
            throw new ezcBaseFileNotFoundException( $dir, 'directory' );
        }

        if ( !is_readable( $dir ) )
        {
            ezcBaseFilePermissionException( $dir, ezcBaseFileException::READ );
        }
        
        $this->schemaArr = array();

        $d = dir( $dir );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry == '.' || $entry == '..' )
            {
                continue;
            }
            if ( is_file( ( $fullEntry =  $dir . DIRECTORY_SEPARATOR . $entry ) ) )
            $this->loadTableSchema( $fullEntry );
        }
        return new ezcDbSchema( $this->schema );
    }

    private function loadTableSchema( $file )
    {
        if ( ( $definition = include $file) === false )
        {
            return;
        }
        $fields = array();
        foreach ( $def->properties as $field )
        {
            $fields[$field->columnName] =  new ezcDbSchemaField(
                $this->translateType( $field->propertyType ),
                false,
                false,
                null,
                false,
                false
            );
        }
        
        $indexes = array();
        if ( $def->idProperty !== null )
        {
            $fields[$def->idProperty->columnName] = new ezcDbSchemaField(
                'integer',
                false,
                true,
                '0',
                true,
                false
            );

            $indexes = array(
                new ezcDbSchemaIndex(
                    array(
                        $def->idProperty->columnName => new ezcDbSchemaIndexField( null ),
                    ),
                    true,
                    false
                ),
            );
        }

        $this->schema[$def->table] = new ezcDbSchemaTable( $fields, $indexes );
    }

    /**
     * Translates eZ DatabaseSchema data types to eZ PersistentObject types.
     * This method receives a type string from a ezcDbSchemaField object and
     * returns the corresponding type value from PersistentObject.
     *
     * @todo Why does PersistentObject not support "boolean" types?
     *
     * @see ezcPersistentObjectProperty::TYPE_INT
     * @see ezcPersistentObjectProperty::TYPE_FLOAT
     * @see ezcPersistentObjectProperty::TYPE_STRING
     *
     * @param string $dbType The DatabaseSchema type string.
     * @return int The ezcPersistentObjectProperty::TYPE_* value.
     */
    private function translateType( $dbType )
    {
        switch ( $dbType )
        {
            case ezcPersistentObjectProperty::PHP_TYPE_INT:
                return 'integer';
            case ezcPersistentObjectProperty::PHP_TYPE_FLOAT:
                return 'float';
            default:
                return 'text';
        }
    }
}
?>

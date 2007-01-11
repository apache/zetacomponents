<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store a table definition in.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaTable extends ezcBaseStruct
{
    /**
     * A list of all the fields in this table.
     *
     * @var array(string=>ezcDbSchemaField)
     */
    public $fields;

    /**
     * A list of all the indexes on this table.
     *
     * @var array(string=>ezcDbSchemaIndex)
     */
    public $indexes;
    
    /**
     * Constructs an ezcDbSchemaTable object.
     *
     * @param array(string=>ezcDbSchemaField) $fields
     * @param array(string=>ezcDbSchemaIndex) $indexes
     */
    function __construct( $fields, $indexes = array() )
    {
        ksort( $fields );
        ksort( $indexes );
        $this->fields = $fields;
        $this->indexes = $indexes;
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaTable(
            $array['fields'], $array['indexes']
        );
    }
}
?>

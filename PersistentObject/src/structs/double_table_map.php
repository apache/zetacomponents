<?php
/**
 * File containing the ezcPersistentDoubleTableMap.
 *
 * @package PersistentObject
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class to create {ezcPersistentRelation::$columnMap} properties.
 * Maps a source table and column and to a destination table and column, to
 * establish a relation between the 2 tables.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcPersistentDoubleTableMap extends ezcBaseStruct
{

    /**
     * Name of the first table this relation map refers to. 
     * 
     * @var string
     */
    public $sourceTable;

    /**
     * Column of the first table used for mapping. 
     * 
     * @var string
     */
    public $sourceColumn;

    /**
     * Name of the relation table, which contains the mapping records. 
     * 
     * @var string
     */
    public $relationTable;

    /**
     * Name of the column in the relation table, that maps to the source table
     * column.
     * 
     * @var string
     */
    public $relationSourceColumn;

    /**
     * Name of the column in the relation table, that maps to the destination
     * table column.
     * 
     * @var string
     */
    public $relationDestinationColumn

    /**
     * Name of the second table this relation refers to. 
     * 
     * @var string
     */
    public $destinationTable;

    /**
     * Column of the second table, which should be mapped to the first column. 
     * 
     * @var string
     */
    public $destinationColumn;

    /**
     * Create a new ezcPersistentDoubleTableMap. 
     * 
     * @param string $sourceTable               {@see $sourceTable}
     * @param string $sourceColumn              {@see $sourceColumn}
     * @param string $relationTable             {@see $relationTable}
     * @param string $relationSourceColumn      {@see $relationSourceColumn}
     * @param string $relationDestinationColumn {@see $relationDestinationColumn}
     * @param string $destinationTable          {@see $destinationTable}
     * @param string $destinationColumn         {@see $destinationColumn}
     */
    public function __construct( $sourceTable, $sourceColumn,
                                 $relationTable, $relationSourceColumn, $relationDestinationColumn,
                                 $destinationTable, $destinationColumn )
    {
        $this->sourceTable                  = $sourceTable;
        $this->sourceColumn                 = $sourceColumn;

        $this->relationTable                = $relationTable;
        $this->relationSourceColumn         = $relationSourceColumn;
        $this->relationDestinationColumn    = $relationDestinationColumn;


        $this->destinationTable             = $destinationTable;
        $this->destinationColumn            = $destinationColumn;
    }
}

?>

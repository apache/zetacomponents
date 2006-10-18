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
     * Column of the first table used for mapping. 
     * 
     * @var string
     */
    public $sourceColumn;

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
    public $relationDestinationColumn;

    /**
     * Column of the second table, which should be mapped to the first column. 
     * 
     * @var string
     */
    public $destinationColumn;

    /**
     * Create a new ezcPersistentDoubleTableMap. 
     * 
     * @param string $sourceColumn              {@see $sourceColumn}
     * @param string $relationSourceColumn      {@see $relationSourceColumn}
     * @param string $relationDestinationColumn {@see $relationDestinationColumn}
     * @param string $destinationColumn         {@see $destinationColumn}
     */
    public function __construct( $sourceColumn,
                                 $relationSourceColumn, $relationDestinationColumn,
                                 $destinationColumn )
    {
        $this->sourceColumn                 = $sourceColumn;

        $this->relationSourceColumn         = $relationSourceColumn;
        $this->relationDestinationColumn    = $relationDestinationColumn;

        $this->destinationColumn            = $destinationColumn;
    }

    public static function __set_state( array $state )
    {
        return new ezcPersistentDoubleTableMap(
            $state["sourceColumn"],
            $state["relationSourceColumn"],
            $state["relationDestinationColumn"],
            $state["destinationColumn"]
        );
    }
}

?>

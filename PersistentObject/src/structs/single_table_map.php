<?php
/**
 * File containing the ezcPersistentSingleTableMap.
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
class ezcPersistentSingleTableMap extends ezcBaseStruct
{

    /**
     * Column of the first table used for mapping. 
     * 
     * @var string
     */
    public $sourceColumn;

    /**
     * Column of the second table, which should be mapped to the first column. 
     * 
     * @var string
     */
    public $destinationColumn;

    /**
     * Create a new ezcPersistentSingleTableMap. 
     * 
     * @param string $sourceColumn      {@see $sourceColumn}
     * @param string $destinationColumn {@see $destinationColumn}
     */
    public function __construct( $sourceColumn, $destinationColumn )
    {
        $this->sourceColumn         = $sourceColumn;
        $this->destinationColumn    = $destinationColumn;
    }
}

?>

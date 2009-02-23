<?php
/**
 * File containing the ezcGraphDatabaseTooManyColumnsException class
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a data set has too many columns for a key value 
 * association.
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 */
class ezcGraphDatabaseTooManyColumnsException extends ezcGraphDatabaseException
{
    /**
     * Constructor
     * 
     * @param array $row
     * @return void
     * @ignore
     */
    public function __construct( $row )
    {
        $columnCount = count( $row );
        parent::__construct( "'{$columnCount}' columns are too many in a result." );
    }
}

?>

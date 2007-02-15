<?php
/**
 * File containing the ezcGraphPdoDataSetTooManyColumnsException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a data set has too many columns for a key value 
 * association.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphPdoDataSetTooManyColumnsException extends ezcGraphException
{
    public function __construct( $row )
    {
        $columnCount = count( $row );
        parent::__construct( "'{$columnCount}' columns are too many in a result." );
    }
}

?>

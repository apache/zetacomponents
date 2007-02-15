<?php
/**
 * File containing the ezcGraphPdoDataSetStatementNotExecutedException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a given statement has not been executed.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphPdoDataSetStatementNotExecutedException extends ezcGraphException
{
    public function __construct( $statement )
    {
        parent::__construct( "Empty result set. Execute the statement before using with ezcGraphPdoDataSet." );
    }
}

?>

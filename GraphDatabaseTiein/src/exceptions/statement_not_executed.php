<?php
/**
 * File containing the ezcGraphDatabaseStatementNotExecutedException class
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a given statement has not been executed.
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 */
class ezcGraphDatabaseStatementNotExecutedException extends ezcGraphDatabaseException
{
    public function __construct( $statement )
    {
        parent::__construct( "Empty result set. Execute the statement before using with ezcGraphDatabaseTiein." );
    }
}

?>

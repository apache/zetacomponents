<?php
/**
 * File containing the ezcGraphDatabaseMissingColumnException class
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a requetsted column could not be found in result set
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 */
class ezcGraphDatabaseMissingColumnException extends ezcGraphDatabaseException
{
    /**
     * Constructor
     * 
     * @param string $column
     * @return void
     * @ignore
     */
    public function __construct( $column )
    {
        parent::__construct( "Missing column '{$column}' in result set." );
    }
}

?>

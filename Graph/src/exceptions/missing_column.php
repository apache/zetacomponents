<?php
/**
 * File containing the ezcGraphPdoDataSetMissingColumnException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a requetsted column could not be found in result set
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphPdoDataSetMissingColumnException extends ezcGraphException
{
    public function __construct( $column )
    {
        parent::__construct( "Missing column '{$column}' in result set." );
    }
}

?>

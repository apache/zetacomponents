<?php
/**
 * File containing the ezcGraphNoSuchDataSetException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when trying to access a non exising dataset.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphNoSuchDataSetException extends ezcGraphException
{
    public function __construct( $name )
    {
        parent::__construct( "No dataset with identifier <{$name}> could be found." );
    }
}

?>

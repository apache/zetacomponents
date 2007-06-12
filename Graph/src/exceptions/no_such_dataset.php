<?php
/**
 * File containing the ezcGraphNoSuchDataSetException class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when trying to access a non exising dataset.
 *
 * @package Graph
 * @version //autogentag//
 */
class ezcGraphNoSuchDataSetException extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @param string $name
     * @return void
     * @ignore
     */
    public function __construct( $name )
    {
        parent::__construct( "No dataset with identifier '{$name}' could be found." );
    }
}

?>

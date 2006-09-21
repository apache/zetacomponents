<?php
/**
 * File containing the ezcGraphNoSuchDataException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception shown, when trying to access not existing data in datasets.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphNoSuchDataException extends ezcGraphException
{
    public function __construct( $name )
    {
        parent::__construct( "No data with name <{$name}> found." );
    }
}

?>

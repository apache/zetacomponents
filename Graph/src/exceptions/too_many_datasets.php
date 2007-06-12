<?php
/**
 * File containing the ezcGraphTooManyDataSetsExceptions class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when trying to insert too many data sets in a data set 
 * container.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphTooManyDataSetsExceptions extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @return void
     * @ignore
     */
    public function __construct()
    {
        parent::__construct( "You tried to insert to many datasets." );
    }
}

?>

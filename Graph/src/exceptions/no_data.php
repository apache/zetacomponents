<?php
/**
 * File containing the ezcGraphNoDataException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception shown, when trying to render a chart without assigning any data.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphNoDataException extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @return void
     * @ignore
     */
    public function __construct()
    {
        parent::__construct( "No data sets assigned to chart." );
    }
}

?>

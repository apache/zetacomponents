<?php
/**
 * File containing the ezcGraphDatasetAverageInvalidKeysException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a dataset with non numeric keys is used with average 
 * datasets.
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphDatasetAverageInvalidKeysException extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @return void
     * @ignore
     */
    public function __construct()
    {
        parent::__construct( "You can not use non numeric keys with Average datasets." );
    }
}

?>

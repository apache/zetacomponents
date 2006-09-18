<?php
/**
 * File containing the ezcGraphDatasetAverageInvalidKeysException class
 *
 * @package Graph
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcGraphDatasetAverageInvalidKeysException is the exception which is thrown when the
 * factory method tries to return an instance of an unknown chart type
 *
 * @package Graph
 * @version //autogen//
 */
class ezcGraphDatasetAverageInvalidKeysException extends ezcGraphException
{
    public function __construct( )
    {
        parent::__construct( "You can not use non numeric keys with Average datasets." );
    }
}

?>

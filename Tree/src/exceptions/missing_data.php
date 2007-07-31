<?php
/**
 * File containing the ezcTreeDataStoreMissingDataException class
 *
 * @package Tree
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when a node is added through the ArrayAccess
 * interface with a key that is different from the node's ID.
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeDataStoreMissingDataException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeDataStoreMissingDataException
     *
     * @param string $nodeId
     * @return void
     */
    function __construct( $nodeId )
    {
        parent::__construct( "The data store does not have data stored for the node with ID '$nodeId'." );
    }
}
?>

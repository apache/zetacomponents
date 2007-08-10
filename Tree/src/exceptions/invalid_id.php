<?php
/**
 * File containing the ezcTreeInvalidIdException class
 *
 * @package Tree
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when a node is request through an invalid
 * (non-existing) ID.
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeInvalidIdException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeInvalidIdException for the ID $nodeId.
     *
     * @param string $nodeId
     * @return void
     */
    function __construct( $nodeId )
    {
        parent::__construct( "The node with ID '{$nodeId}' could not be found." );
    }
}
?>

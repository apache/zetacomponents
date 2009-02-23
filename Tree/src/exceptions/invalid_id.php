<?php
/**
 * File containing the ezcTreeInvalidIdException class.
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when a node is created with an invalid ID.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeInvalidIdException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeInvalidIdException for the ID $nodeId.
     *
     * @param string $nodeId
     * @param string $invalidChar
     */
    public function __construct( $nodeId, $invalidChar )
    {
        parent::__construct( "The node ID '{$nodeId}' contains the invalid character '{$invalidChar}'." );
    }
}
?>

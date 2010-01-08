<?php
/**
 * File containing the ezcTreeDbInvalidSchemaException
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when an incompatible schema is detected with
 * one of the Tree operations.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeDbInvalidSchemaException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeDbInvalidSchemaException
     *
     * @param string $operation
     * @param string $message
     */
    public function __construct( $operation, $message )
    {
        parent::__construct( "While {$operation}, an incompatible schema was found: {$message}." );
    }
}
?>

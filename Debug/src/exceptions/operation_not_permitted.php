<?php
/**
 * File containing the ezcDebugOperationNotPermittedException class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown if an operation is not permitted.
 *
 * Changing of {@link ezcDebugStacktraceIterator} contents via ArrayAccess is
 * not permitted. If tried, this exception is throwen.
 * 
 * @package Debug
 * @version //autogen//
 */
class ezcDebugOperationNotPermittedException extends ezcDebugException
{
    /**
     * Creates an new ezcDebugOperationNotPermittedException.
     *
     * Creates a new ezcDebugOperationNotPermittedException for the given
     * $operation.
     * 
     * @param string $operation 
     */
    public function __construct( $operation )
    {
        parent::__construct(
            "The operation '$operation' is not permitted."
        );
    }
}

?>

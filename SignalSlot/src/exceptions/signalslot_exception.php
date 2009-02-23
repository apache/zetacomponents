<?php
/**
 * File containing the ezcSignalSlotException class
 *
 * @package SignalSlot
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * ezcSignalSlotExceptions are thrown when an exceptional state
 * occures in the SignalSlot package.
 *
 * @package SignalSlot
 * @version //autogen//
 */
class ezcSignalSlotException extends ezcBaseException
{
    /**
     * Constructs a new ezcSignalSlotlException with error message $message.
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>

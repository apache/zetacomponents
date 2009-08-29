<?php
/**
 * File containing the ezcWorkflowSignalSlotReturnValue struct.
 *
 * @package WorkflowSignalSlotTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct used to pass return values to/from slots.
 *
 * @package WorkflowSignalSlotTiein
 * @version //autogen//
 */
class ezcWorkflowSignalSlotReturnValue
{
    /**
     * The return value encapsulated by this struct.
     *
     * @var mixed
     */
    public $value;

    /**
     * Constructor.
     *
     * @param mixed $value
     * @ignore
     */
    public function __construct( $value = true )
    {
        $this->value = $value;
    }
}
?>

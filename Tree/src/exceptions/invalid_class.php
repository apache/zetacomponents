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
 * Exception that is thrown when a wrong class is used.
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeInvalidClassException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeInvalidClassException
     *
     * @param string $expected
     * @param string $actual
     * @return void
     */
    function __construct( $expected, $actual )
    {
        parent::__construct( "An object of class '$expected' is used, but an object of class '$actual' is expected." );
    }
}
?>

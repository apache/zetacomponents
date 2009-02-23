<?php
/**
 * File containing the ezcPersistentRelationInvalidException class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, if the class of a relation definition was invalid.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelationInvalidException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentRelationInvalidException for the given
     * relation class $class.
     *
     * @param string $class
     * @return void
     */
    public function __construct( $class )
    {
        parent::__construct( "Class '{$class}' is not a valid relation defitinion class." );
    }
}
?>

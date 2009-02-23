<?php
/**
 * File containing the ezcPersistentIdentityAlreadyExistsException class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if the same identity is added twice to the identity map.
 *
 * {@link ezcPersistentIdentityMap::addIdentity()} will throw this exception,
 * if the same identity is added twice.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityAlreadyExistsException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityAlreadyExistsException.
     *
     * Creates a new ezcPersistentIdentityAlreadyExistsException for the object
     * of $class with ID $id.
     *
     * @param string $class
     * @param mixed $id
     */
    public function __construct( $class, $id )
    {
        parent::__construct(
            "An identity for the object of {$class} with ID {$id} already exists in the identity map."
        );
    }
}
?>

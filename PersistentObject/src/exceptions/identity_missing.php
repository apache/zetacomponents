<?php
/**
 * File containing the ezcPersistentIdentityMissingException class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if an identity is expected to exist, but was not found.
 *
 * {@link ezcPersistentIdentityMap::addRelatedObjects()} will throw this
 * exception, if an identity of a related object does not exist.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityMissingException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityMissingException.
     *
     * Creates a new ezcPersistentIdentityMissingException for the object of
     * $class with ID $id.
     *
     * @param string $class
     * @param mixed $id
     * @param string $relatedClass
     * @param string $relationName
     */
    public function __construct( $class, $id )
    {
        parent::__construct(
            "The identity of the object of class {$class} with ID {$id} was expected to exists, but not found."
        );
    }
}
?>

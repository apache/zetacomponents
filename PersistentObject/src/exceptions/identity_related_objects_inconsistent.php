<?php
/**
 * File containing the ezcPersistentIdentityRelatedObjectsInconsistentException class.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a set of related objects is inconsistent. 
 *
 * {@link ezcPersistentIdentityMap::addRelatedObjects()} will throw this
 * exception, if one relation set contains 2 or more different classes.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentIdentityRelatedObjectsInconsistentException extends ezcPersistentObjectException
{

    /**
     * Creates a new ezcPersistentIdentityRelatedObjectsInconsistentException.
     *
     * Creates a new ezcPersistentIdentityRelatedObjectsInconsistentException
     * for the object of $class with ID $id where $firstClass and $secondClass were
     * both found in the same relation set.
     *
     * @param string $class
     * @param mixed $id
     * @param string $firstClass
     * @param string $secondClass
     */
    public function __construct( $class, $id, $firstClass, $secondClass )
    {
        parent::__construct(
            "Inconsistent relation set for object of class {$class} with ID {$id}. {$firstClass} and {$secondClass} occured in the same relation set."
        );
    }
}
?>

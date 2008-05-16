<?php
/**
 * File containing the ezcPersistentObject interface
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcPersistentObject is an (optional) interface for classes that provide persistent objects.
 *
 * The PersistentObject component does not require a class to inherit from a
 * certain base class or implement a certain interface to be used with the
 * component. However, this interface can (optionally) be implemented by your
 * persistent classes, to ensure they provide all necessary methods.
 *
 * @package PersistentObject
 * @version //autogen//
 */
interface ezcPersistentObject extends ezcBasePersistable
{
    /**
     * Returns the current state of an object.
     * This method returns an array representing the current state of the
     * object. The array must contain a key for every attribute of the
     * object, assigned to the value of the attribute.
     * 
     * @return array(string=>mixed) The state of the object.
     */
    public function getState();

    /**
     * Sets the state of the object.
     * This method sets the state of the object accoring to a given array,
     * which must conform to the standards defined at {@link getState()}.
     * 
     * @param array $state The new state for the object.
     * @return void
     */
    public function setState( array $state );
}

?>

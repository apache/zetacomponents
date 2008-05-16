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
}

?>

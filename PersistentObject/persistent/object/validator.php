<?php
/**
 * File containing the ezcPersistentObjectRow class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * A class for validating eczPersistentObject::definitions
 *
 * @package PersistentObject
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcPersistentObjectValidator
{
    /**
     * Returns an array of strings each describing one problem with the definition.
     * If no problems are found an empty array will be returned.
     *
     * In order to be valid it must comply to all the rules specified
     * in ezsPersistentObject. Note that this function is meant for testing only
     * and should not be run in a production environment.
     *
     * @param array $def
     * @return array(string)
     */
    public static function validateDefinition( $def )
    {
    }
}
?>

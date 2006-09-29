<?php
/**
 * File containing the ezcPersistentObjectException class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * General exception class for the PersistentObject package.
 *
 * All exceptions in the persistent object package are derived from this exception.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentRelationNotFoundException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentRelationNotFoundException for the class $class
     * which does not have a relation for $relatedClass.
     *
     * @param string $class
     * @param string $relatedClass
     * @return void
     */
    public function __construct( $class, $relatedClass )
    {
        parent::__construct( "Class <{$class}> does not have a relation to <{$relatedClass}>" );
    }
}
?>

<?php
/**
 * File running the ezcPersistentObjectSchemaGenerator class
 *
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once("Base/src/base.php");

function __autoload( $class_name )
{
    ezcBase::autoload( $class_name );
}

$generator = new ezcPersistentObjectSchemaGenerator();
$generator->run();

?>

<?php
/**
 * File running the ezcPersistentObjectSchemaGenerator class
 *
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require "Base/src/base.php";

function __autoload( $className )
{
    ezcBase::autoload( $className );
}

$generator = new ezcPersistentObjectSchemaGenerator();
$generator->run();

?>

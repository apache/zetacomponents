<?php
/**
 * Autoloading helper.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @ignore
 */

return array( 'ezcDbSchema'                    => 'DatabaseSchema/schema.php',
              'ezcDbSchemaException'           => 'DatabaseSchema/exceptions/exception.php',
              'ezcDbSchemaComparator'          => 'DatabaseSchema/comparator.php',
              'ezcDbSchemaTransformations'     => 'DatabaseSchema/transformations.php',
              'ezcDbSchemaHandlerManager'      => 'DatabaseSchema/handler_manager.php',
              'ezcDbSchemaHandler'             => 'DatabaseSchema/handler.php',
              'ezcDbSchemaHandlerDataTransfer' => 'DatabaseSchema/handlers/data_transfer.php',
              'ezcDbSchemaHandlerPhpArray'     => 'DatabaseSchema/handlers/php_array.php',
              'ezcDbSchemaHandlerXml'          => 'DatabaseSchema/handlers/xml.php',
              'ezcDbSchemaHandlerSql'          => 'DatabaseSchema/handlers/sql.php',
              'ezcDbSchemaHandlerPgsql'        => 'DatabaseSchema/handlers/pgsql.php',
              'ezcDbSchemaHandlerMysql'        => 'DatabaseSchema/handlers/mysql.php',
              'ezcDbSchemaHandlerOracle'       => 'DatabaseSchema/handlers/oracle.php',
              );
?>

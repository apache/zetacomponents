<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

require_once 'schema_test.php';
require_once 'handler_manager_test.php';
require_once 'php_array_test.php';
require_once 'php_array_diff_test.php';
require_once 'xml_test.php';
require_once 'xml_diff_test.php';
require_once 'mysql_test.php';
require_once 'mysql_diff_test.php';
require_once 'validator_test.php';
require_once 'comparator_test.php';
require_once 'persistent_test.php';

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaSuite extends ezcTestSuite
{
	public function __construct()
	{
        parent::__construct();
        $this->setName( 'DatabaseSchema' );

        $this->addTest( ezcDatabaseSchemaTest::suite() );
        $this->addTest( ezcDatabaseSchemaHandlerManagerTest::suite() );
        $this->addTest( ezcDatabaseSchemaValidatorTest::suite() );
        $this->addTest( ezcDatabaseSchemaComparatorTest::suite() );
        $this->addTest( ezcDatabaseSchemaPhpArrayTest::suite() );
        $this->addTest( ezcDatabaseSchemaPhpArrayDiffTest::suite() );
        $this->addTest( ezcDatabaseSchemaXmlTest::suite() );
        $this->addTest( ezcDatabaseSchemaXmlDiffTest::suite() );
        $this->addTest( ezcDatabaseSchemaMysqlTest::suite() );
        $this->addTest( ezcDatabaseSchemaMysqlDiffTest::suite() );
        $this->addTest( ezcDatabaseSchemaPersistentTest::suite() );
	}

    public static function suite()
    {
        return new ezcDatabaseSchemaSuite();
    }
}

?>

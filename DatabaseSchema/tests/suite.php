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
require_once 'xml_test.php';
require_once 'mysql_test.php';
require_once 'validator_test.php';
require_once 'comparator_test.php';

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
        $this->addTest( ezcDatabasePhpArrayTest::suite() );
        $this->addTest( ezcDatabaseXmlTest::suite() );
        $this->addTest( ezcDatabaseSchemaMysqlTest::suite() );
	}

    public static function suite()
    {
        return new ezcDatabaseSchemaSuite();
    }
}

?>

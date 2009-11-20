<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

require_once 'schema_test.php';
require_once 'schema_field_test.php';
require_once 'handler_manager_test.php';

require_once 'php_array_test.php';
require_once 'xml_test.php';
require_once 'mysql_test.php';
require_once 'pgsql_test.php';
require_once 'sqlite_test.php';
require_once 'oracle_test.php';

require_once 'php_array_diff_test.php';
require_once 'xml_diff_test.php';
require_once 'mysql_diff_test.php';
require_once 'pgsql_diff_test.php';
require_once 'sqlite_diff_test.php';
require_once 'oracle_diff_test.php';

require_once 'validator_test.php';
require_once 'comparator_test.php';
require_once 'persistent_test.php';

require_once 'custom_class_test.php';

require_once 'oracle_nodb_test.php';

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( 'DatabaseSchema' );

        $this->addTest( ezcDatabaseSchemaTest::suite() );
        $this->addTest( ezcDatabaseSchemaFieldTest::suite() );
        $this->addTest( ezcDatabaseSchemaHandlerManagerTest::suite() );
        $this->addTest( ezcDatabaseSchemaValidatorTest::suite() );
        $this->addTest( ezcDatabaseSchemaComparatorTest::suite() );
        $this->addTest( ezcDatabaseSchemaPhpArrayTest::suite() );
        $this->addTest( ezcDatabaseSchemaPhpArrayDiffTest::suite() );
        $this->addTest( ezcDatabaseSchemaXmlTest::suite() );
        $this->addTest( ezcDatabaseSchemaXmlDiffTest::suite() );
        
        try
        {
            $dbType = ezcDbInstance::get()->getName();

            switch ( $dbType )
            {
                case 'mysql':
                    $this->addTest( ezcDatabaseSchemaMysqlTest::suite() );
                    $this->addTest( ezcDatabaseSchemaMysqlDiffTest::suite() );
                break;
                case 'pgsql':
                    $this->addTest( ezcDatabaseSchemaPgsqlTest::suite() );
                    $this->addTest( ezcDatabaseSchemaPgsqlDiffTest::suite() );
                break;
                case 'sqlite':
                    $this->addTest( ezcDatabaseSchemaSqliteTest::suite() );
                    $this->addTest( ezcDatabaseSchemaSqliteDiffTest::suite() );
                break;
                case 'oracle':
                    $this->addTest( ezcDatabaseSchemaOracleTest::suite() );
                    $this->addTest( ezcDatabaseSchemaOracleDiffTest::suite() );
                break;                
            }
        }
        catch ( ezcDbHandlerNotFoundException $e )
        {
        }

        $this->addTest( ezcDatabaseSchemaPersistentTest::suite() );
        $this->addTest( ezcDatabaseSchemaCustomClassesTest::suite() );

        $this->addTest( ezcDatabaseSchemaOracleNoDbTest::suite() );
    }

    public static function suite()
    {
        return new ezcDatabaseSchemaSuite();
    }
}

?>

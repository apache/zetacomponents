<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once 'managers/code_manager_test.php';
require_once 'managers/cache_manager_test.php';
require_once 'managers/multi_manager_test.php';

require_once 'persistent_session_delete_test.php';
require_once 'persistent_session_find_test.php';
require_once 'persistent_session_load_test.php';
require_once 'persistent_session_misc_test.php';
require_once 'persistent_session_save_test.php';

require_once 'find_iterator_test.php';
require_once 'manual_generator_test.php';
require_once 'native_generator_test.php';
require_once 'persistent_session_instance_test.php';
require_once 'one_to_many_relation_test.php';
require_once 'many_to_one_relation_test.php';
require_once 'one_to_one_relation_test.php';
require_once 'many_to_many_relation_test.php';
require_once 'keyword_test.php';
require_once 'string_identifier_test.php';
require_once 'object_property_test.php';
require_once 'object_id_property_test.php';
require_once 'object_definition_test.php';
require_once 'object_relations_test.php';
require_once 'object_properties_test.php';
require_once 'object_columns_test.php';
require_once 'property_date_time_converter_test.php';

require_once 'database_type_test.php';

require_once 'persistent_object_test.php';
require_once 'instance_delayed_init_test.php';

require_once 'find_query_test.php';

/**
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("PersistentObject");

        $this->addTest( ezcPersistentCodeManagerTest::suite() );
        $this->addTest( ezcPersistentCacheManagerTest::suite() );
        $this->addTest( ezcPersistentMultiManagerTest::suite() );
        $this->addTest( ezcPersistentSessionDeleteTest::suite() );
        $this->addTest( ezcPersistentSessionFindTest::suite() );
        $this->addTest( ezcPersistentSessionLoadTest::suite() );
        $this->addTest( ezcPersistentSessionMiscTest::suite() );
        $this->addTest( ezcPersistentSessionSaveTest::suite() );
        $this->addTest( ezcPersistentFindIteratorTest::suite() );
        $this->addTest( ezcPersistentManualGeneratorTest::suite() );
        $this->addTest( ezcPersistentNativeGeneratorTest::suite() );
        $this->addTest( ezcPersistentSessionInstanceTest::suite() );
        $this->addTest( ezcPersistentOneToManyRelationTest::suite() );
        $this->addTest( ezcPersistentOneToOneRelationTest::suite() );
        $this->addTest( ezcPersistentManyToOneRelationTest::suite() );
        $this->addTest( ezcPersistentManyToManyRelationTest::suite() );
        $this->addTest( ezcPersistentKeywordTest::suite() );
        $this->addTest( ezcPersistentStringIdentifierTest::suite() );
        $this->addTest( ezcPersistentObjectPropertyTest::suite() );
        $this->addTest( ezcPersistentObjectIdPropertyTest::suite() );
        $this->addTest( ezcPersistentObjectDefinitionTest::suite() );
        $this->addTest( ezcPersistentObjectRelationsTest::suite() );
        $this->addTest( ezcPersistentObjectPropertiesTest::suite() );
        $this->addTest( ezcPersistentObjectColumnsTest::suite() );
        $this->addTest( ezcPersistentPropertyDateTimeConverterTest::suite() );
        $this->addTest( ezcPersistentDatabaseTypeTest::suite() );
        $this->addTest( ezcPersistentObjectTest::suite() );
        $this->addTest( ezcPersistentObjectInstanceDelayedInitTest::suite() );
        $this->addTest( ezcPersistentFindQueryTest::suite() );
    }

    public static function suite()
    {
        return new ezcPersistentObjectSuite();
    }
}

?>

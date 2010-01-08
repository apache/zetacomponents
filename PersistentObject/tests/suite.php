<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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

require_once 'persistent_session/delete_test.php';
require_once 'persistent_session/find_test.php';
require_once 'persistent_session/load_test.php';
require_once 'persistent_session/misc_test.php';
require_once 'persistent_session/save_test.php';
require_once 'persistent_session/instance_test.php';

require_once 'persistent_session_identity_decorator/options_test.php';
require_once 'persistent_session_identity_decorator/misc_test.php';
require_once 'persistent_session_identity_decorator/delete_test.php';
require_once 'persistent_session_identity_decorator/find_test.php';
require_once 'persistent_session_identity_decorator/load_test.php';
require_once 'persistent_session_identity_decorator/save_test.php';
require_once 'persistent_session_identity_decorator/relation_test.php';

require_once 'persistent_session_identity_decorator/relation_query_creator_test.php';
require_once 'persistent_session_identity_decorator/relation_object_extractor_test.php';

require_once 'persistent_session_identity_decorator/instance_test.php';

require_once 'find_iterator_test.php';
require_once 'manual_generator_test.php';
require_once 'native_generator_test.php';

require_once 'relations/one_to_many_relation_test.php';
require_once 'relations/many_to_one_relation_test.php';
require_once 'relations/one_to_one_relation_test.php';
require_once 'relations/many_to_many_relation_test.php';
require_once 'relations/multi_relation_test.php';

require_once 'keyword_test.php';
require_once 'string_identifier_test.php';

require_once 'object/object_test.php';
require_once 'object/property_test.php';
require_once 'object/id_property_test.php';
require_once 'object/definition_test.php';
require_once 'object/relations_test.php';
require_once 'object/relation_collection_test.php';
require_once 'object/properties_test.php';
require_once 'object/columns_test.php';
require_once 'object/property_date_time_converter_test.php';

require_once 'database_type_test.php';

require_once 'instance_delayed_init_test.php';

require_once 'find_query_test.php';
require_once 'relation_find_query_test.php';
require_once 'find_with_relations_query_test.php';

require_once 'basic_identity_map_test.php';

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

        $this->addTest( ezcPersistentSessionIdentityDecoratorOptionsTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorMiscTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorDeleteTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorFindTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorLoadTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorSaveTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorRelationTest::suite() );

        $this->addTest( ezcPersistentSessionIdentityDecoratorInstanceTest::suite() );

        $this->addTest( ezcPersistentFindIteratorTest::suite() );

        $this->addTest( ezcPersistentManualGeneratorTest::suite() );
        $this->addTest( ezcPersistentNativeGeneratorTest::suite() );

        $this->addTest( ezcPersistentSessionInstanceTest::suite() );

        $this->addTest( ezcPersistentOneToManyRelationTest::suite() );
        $this->addTest( ezcPersistentOneToOneRelationTest::suite() );
        $this->addTest( ezcPersistentManyToOneRelationTest::suite() );
        $this->addTest( ezcPersistentManyToManyRelationTest::suite() );
        $this->addTest( ezcPersistentMultiRelationTest::suite() );

        $this->addTest( ezcPersistentKeywordTest::suite() );
        $this->addTest( ezcPersistentStringIdentifierTest::suite() );

        $this->addTest( ezcPersistentObjectPropertyTest::suite() );
        $this->addTest( ezcPersistentObjectIdPropertyTest::suite() );
        $this->addTest( ezcPersistentObjectDefinitionTest::suite() );
        $this->addTest( ezcPersistentObjectRelationsTest::suite() );
        $this->addTest( ezcPersistentObjectPropertiesTest::suite() );
        $this->addTest( ezcPersistentObjectColumnsTest::suite() );
        $this->addTest( ezcPersistentRelationCollectionTest::suite() );

        $this->addTest( ezcPersistentPropertyDateTimeConverterTest::suite() );

        $this->addTest( ezcPersistentDatabaseTypeTest::suite() );

        $this->addTest( ezcPersistentObjectTest::suite() );
        $this->addTest( ezcPersistentObjectInstanceDelayedInitTest::suite() );

        $this->addTest( ezcPersistentFindQueryTest::suite() );
        $this->addTest( ezcPersistentRelationFindQueryTest::suite() );
        $this->addTest( ezcPersistentFindWithRelationsQueryTest::suite() );

        $this->addTest( ezcPersistentBasicIdentityMapTest::suite() );

        $this->addTest( ezcPersistentSessionIdentityDecoratorRelationQueryCreatorTest::suite() );
        $this->addTest( ezcPersistentSessionIdentityDecoratorRelationObjectExtractorTest::suite() );
    }

    public static function suite()
    {
        return new ezcPersistentObjectSuite();
    }
}

?>

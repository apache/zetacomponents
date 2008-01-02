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
require_once( 'managers/code_manager_test.php' );
require_once( 'managers/cache_manager_test.php' );
require_once( 'managers/multi_manager_test.php' );
require_once( 'persistent_session_test.php' );
require_once( 'find_iterator_test.php' );
require_once( 'manual_generator_test.php' );
require_once( 'native_generator_test.php' );
require_once( 'persistent_session_instance_test.php' );
require_once( 'one_to_many_relation_test.php' );
require_once( 'many_to_one_relation_test.php' );
require_once( 'one_to_one_relation_test.php' );
require_once( 'many_to_many_relation.php' );
require_once( 'keyword_test.php' );
require_once( 'string_identifier_test.php' );
require_once( 'object_property_test.php' );
require_once( 'object_id_property_test.php' );
require_once( 'object_definition_test.php' );
require_once( 'object_relations_test.php' );
require_once( 'object_properties_test.php' );
require_once( 'object_columns_test.php' );
require_once 'date_time_conversion_test.php';

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
        $this->addTest( ezcPersistentSessionTest::suite() );
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
        $this->addTest( ezcPersistentObjectPropertyDateTimeConversionTest::suite() );
    }

    public static function suite()
    {
        return new ezcPersistentObjectSuite();
    }
}

?>

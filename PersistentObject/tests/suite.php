<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
require_once( 'managers/multi_manager_test.php' );
require_once( 'persistent_session_test.php' );
require_once( 'find_iterator_test.php' );
require_once( 'manual_generator_test.php' );
require_once( 'persistent_session_instance_test.php' );
require_once( 'one_to_many_relation_test.php' );

/**
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("PersistentObject");

        $this->addTest( ezcPersistentCodeManagerTest::suite() );
        $this->addTest( ezcPersistentMultiManagerTest::suite() );
        $this->addTest( ezcPersistentSessionTest::suite() );
        $this->addTest( ezcPersistentFindIteratorTest::suite() );
        $this->addTest( ezcPersistentManualGeneratorTest::suite() );
        $this->addTest( ezcPersistentSessionInstanceTest::suite() );
        $this->addTest( ezcPersistentOneToManyRelationTest::suite() );
    }

    public static function suite()
    {
        return new ezcPersistentObjectSuite();
    }
}

?>

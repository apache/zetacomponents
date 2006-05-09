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
require_once( 'persistent_session_test.php' );
require_once( 'find_iterator_test.php' );
require_once( 'manual_generator_test.php' );

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
            $this->addTest( ezcPersistentSessionTest::suite() );
            $this->addTest( ezcPersistentFindIteratorTest::suite() );
            $this->addTest( ezcManualGeneratorTest::suite() );
	}

    public static function suite()
    {
        return new ezcPersistentObjectSuite();
    }
}

?>

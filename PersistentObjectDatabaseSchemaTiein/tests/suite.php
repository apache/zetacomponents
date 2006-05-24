<?php
/**
 * ezcPersistentObjectDatabaseSchemaTieinSuite
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require main test suite.
 */
require_once 'test.php';
/**
    
/**
 * Test suite for PersistentObjectDatabaseSchemaTiein package.
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */
class ezcPersistentObjectDatabaseSchemaTieinSuite extends ezcTestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName( "PersistentObjectDatabaseSchemaTiein" );
		$this->addTest( ezcPersistentObjectDatabaseSchemaTieinTest::suite() );
	}

    public static function suite()
    {
        return new ezcPersistentObjectDatabaseSchemaTieinSuite( "ezcPersistentObjectDatabaseSchemaTieinSuite" );
    }
}
?>

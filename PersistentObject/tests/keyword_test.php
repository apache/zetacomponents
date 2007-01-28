<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */
ezcTestRunner::addFileToFilter( __FILE__ );

require_once "data/keywordtest/table_class.php";

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentKeywordTest extends ezcTestCase
{
    private $session = null;
    private $hasTables = false;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }

//        Table::setupTable();
        Table::saveSchema();
//        $this->session = new ezcPersistentSession( ezcDbInstance::get(),
//                                                   new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/keywordtest" ) );
    }

    protected function tearDown()
    {
//        Table::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentKeywordTest' );
    }

    public function testSave()
    {
    }
}

?>

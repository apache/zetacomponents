<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . '/../data/persistent_test_object_casesensitive.php';

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionCasesensitiveTest extends ezcTestCase
{
    protected $session = null;

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

        PersistentTestObjectCasesensitive::setupTable();
        PersistentTestObjectCasesensitive::insertCleanData();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/../data/" )
        );
    }

    public function testFind()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObjectCasesensitive' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 1 ) );
        $objects = $this->session->find( $q, 'PersistentTestObjectCasesensitive' );
        $this->assertEquals( 1, count( $objects ) );
    }

    public function testLoad()
    {
        $object = $this->session->load( 'PersistentTestObjectCasesensitive', "1" );
        $this->assertEquals( 'PersistentTestObjectCasesensitive', get_class( $object ) );
    }

    public function testDelete()
    {
        $object = new PersistentTestObjectCasesensitive();
        $object->varChar = 'Finland';
        $object->integer = 42;
        $object->DECIMAL = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );
        $this->assertEquals( 5, $object->id );

        $this->session->delete( $object );
        try
        {
            $this->session->load( 'PersistentTestObjectCasesensitive', 5 );
            $this->fail( "Fetching a deleted object did not throw exception." );
        }
        catch ( ezcPersistentQueryException $e ) 
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObjectCasesensitive' with id '5'.",
                $e->getMessage()
            );
        }
    }
    
    public function testUpdate()
    {
        $object = $this->session->load( 'PersistentTestObjectCasesensitive', 1 );
        
        $this->assertEquals( 'PersistentTestObjectCasesensitive', get_class( $object ) );

        $object->varChar = 'Finland';
        $object->integer = 42;
        $object->DECIMAL = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->update( $object );

        // check that we got the correct values
        $object2 = $this->session->loadIfExists( 'PersistentTestObjectCasesensitive', 1 );
        $this->assertEquals( 'Finland', $object2->varChar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->DECIMAL );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    public function testSave()
    {
        $object = new PersistentTestObjectCasesensitive();
        $object->varChar = 'Finland';
        $object->integer = 42;
        $object->DECIMAL = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );

        $this->assertEquals( 5, $object->id );

        $object2 = $this->session->load( 'PersistentTestObjectCasesensitive', 5 );

        $this->assertEquals( 'Finland', $object2->varChar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->DECIMAL );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    protected function tearDown()
    {
        PersistentTestObjectCasesensitive::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}

?>

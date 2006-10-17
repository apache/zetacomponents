<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */
ezcTestRunner::addFileToFilter( __FILE__ );

require_once "data/manual_generator_test.php";

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentManualGeneratorTest extends ezcTestCase
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

        PersistentTestObject::setupTable();
        PersistentTestObject::insertCleanData();
//        PersistentTestObject::saveSqlSchemas();
        $this->session = new ezcPersistentSession( ezcDbInstance::get(),
                                                   new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" ) );
    }

    protected function tearDown()
    {
        PersistentTestObject::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentManualGeneratorTest' );
    }

    // test no id error
    public function testErrorID()
    {
        $object = new ManualGeneratorTest();
        $object->id = null;
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        try
        {
            $this->session->save( $object );
        }catch( ezcPersistentIdentifierGenerationException $e ){ return; }
        $this->fail( "Did not get exception when saving with null id." );
    }

    // test save single
    public function testSaveValid()
    {
        $object = new ManualGeneratorTest();
        $object->id = 42;
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );

        $this->assertEquals( 42, $object->id );
        $object2 = $this->session->loadIfExists( 'PersistentTestObject', 42 );
        $this->assertEquals( 'Finland', $object2->varchar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->decimal );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );

    }

    // test save already stored
    public function testSaveAlreadyPersistent()
    {
        $object = new ManualGeneratorTest();
        $object->id = 42;
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );
        try{
            $this->session->save( $object );
        }catch( Exception $e ){ return; }
        $this->fail( "Did not get exception when saving object twice.." );
    }
}

?>

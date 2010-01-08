<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once "data/native_generator_test.php";
require_once "data/persistent_test_object.php";

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentNativeGeneratorTest extends ezcTestCase
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

        if ( $db->getName() !== "mysql" && $db->getName() !== "sqlite" )
        {
            $this->markTestSkipped( 'Only MySQL and SQLite support the native generator' );
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
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentNativeGeneratorTest' );
    }

    // test no id error
    public function testSaveValid()
    {
        $object = new NativeGeneratorTest();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );

        $this->assertEquals( 5, $object->id );
    }

}

?>

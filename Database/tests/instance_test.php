<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * Test the instance class
 *
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseInstanceTest extends ezcTestCase
{
    private $default;
    public function setUp()
    {
        $this->default = ezcDbInstance::get();
    }

    public function tearDown()
    {
        ezcDbInstance::reset();
        ezcDbInstance::set( $this->default );
    }

    public function testGetWithIdentifierValid()
    {
        $db = ezcDbInstance::get();
        $db = clone( $db );
        $db->a = "something";
        ezcDbInstance::set( $db, 'secondary' );
        $this->assertEquals( true, isset( ezcDbInstance::get( 'secondary' )->a ) );
    }

    public function testChooseDefault()
    {
        $db = ezcDbInstance::get();
        $db = clone $db;
        $db->a = "something";
        ezcDbInstance::set( $db, 'secondary' );

        ezcDbInstance::chooseDefault( 'secondary' );
        $this->assertEquals( true, isset( ezcDbInstance::get()->a ) );
    }

    public function testWithIdentifierInvalid()
    {
        try
        {
            ezcDbInstance::get( "NoSuchInstance" );
            $this->fail( "Getting a non existent instance did not fail." );
        }
        catch ( ezcDbHandlerNotFoundException $e ) {}
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcDatabaseInstanceTest" );
    }
}

?>

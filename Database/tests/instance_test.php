<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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

    protected function setUp()
    {
        try
        {
            $this->default = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }
    }

    protected function tearDown()
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

    public function testGetIdentifiers()
    {
        $this->assertTrue( count( ezcDbInstance::getIdentifiers() ) >= 1 );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcDatabaseInstanceTest" );
    }
}

?>

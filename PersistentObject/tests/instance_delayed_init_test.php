<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'test_classes.php';

/**
 * Test the delayed init for instance class
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentObjectInstanceDelayedInitTest extends ezcTestCase
{
    private $default;

    public function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }
    }

    public function testDelayedInit1()
    {
        ezcBaseInit::setCallback( 'ezcInitPersistentSessionInstance', 'testDelayedInitPersistentSessionInstance' );
        $instance1 = ezcPersistentSessionInstance::get( 'delayed1' );
    }

    public function testDelayedInit2()
    {
        try
        {
            $instance2 = ezcPersistentSessionInstance::get( 'delayed2' );
        }
        catch ( ezcPersistentSessionNotFoundException $e )
        {
            $this->assertEquals( "Could not find the persistent session: delayed2.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcPersistentObjectInstanceDelayedInitTest" );
    }
}

?>

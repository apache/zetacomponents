<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

require_once 'test_classes.php';

/**
 * Test the delayed init for instance class
 *
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseInstanceDelayedInitTest extends ezcTestCase
{
    private $default;

    public function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'pdo_sqlite') )
        {
            $this->markTestSkipped();
            return;
        }
    }

    public function testDelayedInit1()
    {
        ezcBaseInit::setCallback( 'ezcInitDatabaseInstance', 'testDelayedInitDatabaseInstance' );
        $instance1 = ezcDbInstance::get( 'delayed1' );
    }

    public function testDelayedInit2()
    {
        try
        {
            $instance2 = ezcDbInstance::get( 'delayed2' );
        }
        catch ( ezcDbHandlerNotFoundException $e )
        {
            $this->assertEquals( "Could not find the database handler: 'delayed2'.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcDatabaseInstanceDelayedInitTest" );
    }
}

?>

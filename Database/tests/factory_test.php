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
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseFactoryTest extends ezcTestCase
{
    public function testWithoutImplementationType()
    {
        try
        {
            $dbparams = array( 'host' => 'localhost', 'user' => 'root', 'database' => 'ezc' );
            $db = ezcDbFactory::create( $dbparams );

            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcDbHandlerNotFoundException $e )
        {
        }
    }

    public function testWithWrongImplementationType()
    {
        try
        {
            $dbparams = array( 'type' => 'unknown', 'host' => 'localhost', 'user' => 'root', 'database' => 'ezc' );
            $db = ezcDbFactory::create( $dbparams );

            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcDbHandlerNotFoundException $e )
        {
        }
    }

    public function testGetImplementations()
    {
        $array = ezcDbFactory::getImplementations();
        $this->assertEquals( array( 'mysql', 'pgsql', 'oracle', 'sqlite' ), $array );
    }

    public function testGetImplementationsAfterAddingOne()
    {
        ezcDbFactory::addImplementation( 'test', 'ezcDbHandlerTest' );
        $array = ezcDbFactory::getImplementations();
        $this->assertEquals( array( 'mysql', 'pgsql', 'oracle', 'sqlite', 'test' ), $array );
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcDatabaseFactoryTest" );
    }
}
?>

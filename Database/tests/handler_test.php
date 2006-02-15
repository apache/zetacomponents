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
 * Test the handler classes.
 *
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseHandlerTest extends ezcTestCase
{
    public function setUp()
    {
    }

    public function testConstructorNoDatabaseName()
    {
        try
        {
            // we'll create an instance of the correct type simply by making a similar one to the default.
            $db = ezcDbInstance::get();
            $className = get_class( $db );
            $db = new $className( array() );
            $this->fail( "Instantiating a handler with no database name should not be successful" );
        }
        catch( ezcDbMissingParameterException $e ) {}
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcDatabaseHandlerTest" );
    }
}

?>

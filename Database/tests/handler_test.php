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
    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }
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
        catch ( ezcDbMissingParameterException $e ) {}
    }

    public function testIdentifierQuotingNoEscape()
    {
        $db = ezcDbInstance::get();
        switch ( get_class( $db ) )
        {
            case "ezcDbHandlerMysql":
                $quoteChars = array( "`", "`" );
                break;
            case "ezcDbHandlerOracle":
            case "ezcDbHandlerPgsql":
            case "ezcDbHandlerSqlite":
                $quoteChars = array( '"', '"' );
                break;
                
            default:
                $this->markTestSkipped( "No quoting test defined for handler class '{" . get_class( $db ) . "}'" );
        }

        $this->assertEquals(
            $quoteChars[0] . "TestIdentifier" . $quoteChars[1],
            $db->quoteIdentifier( "TestIdentifier" )
        );
    }

    public function testIdentifierQuotingEscape()
    {
        $db = ezcDbInstance::get();
        switch ( get_class( $db ) )
        {
            case "ezcDbHandlerMysql":
                $quoteChars = array( "`", "`" );
                break;
            case "ezcDbHandlerOracle":
            case "ezcDbHandlerPgsql":
            case "ezcDbHandlerSqlite":
                $quoteChars = array( '"', '"' );
                break;
                
            default:
                $this->markTestSkipped( "No quoting test defined for handler class '{" . get_class( $db ) . "}'" );
        }

        $this->assertEquals(
            $quoteChars[0] . "Test" . $quoteChars[1] . $quoteChars[1] . "Identifier" . $quoteChars[1],
            $db->quoteIdentifier( "Test" . $quoteChars[1] . "Identifier" )
        );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcDatabaseHandlerTest" );
    }
}

?>

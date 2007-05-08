<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * @package AuthenticationDatabaseTiein
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationDatabaseTest extends ezcTestCase
{
    public static $table = 'authusers';
    public static $fieldId = 'uniqueid';
    public static $fieldUser = 'username';
    public static $fieldPassword = 'pass';
    

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationDatabaseTest" );
    }

    public function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
            $tables = array( self::$table => new ezcDbSchemaTable(
                                array (
                                    self::$fieldId       => new ezcDbSchemaField( 'integer', false, true, null, true ),
                                    self::$fieldUser     => new ezcDbSchemaField( 'text', 32, true ),
                                    self::$fieldPassword => new ezcDbSchemaField( 'text', 64, true ),
                                ),
                                array (
                                    self::$fieldUser => new ezcDbSchemaIndex( array ( self::$fieldUser => new ezcDbSchemaIndexField() ), false, false ),
                                ) ) );
            $schema = new ezcDbSchema( $tables );
            $schema->writeToDb( $this->db );
        }
        catch ( Exception $e )
        {
            // Oracle seems to skip every other test if the next line is enabled
            // $this->markTestSkipped( "Cannot create test table '" . self::$table . "'. " . $e->getMessage() );
        }

        try
        {
            $query = new ezcQueryInsert( $this->db );
            $query->insertInto( $this->db->quoteIdentifier( self::$table ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldId ), $query->bindValue( '1' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldUser ), $query->bindValue( 'jan.modaal' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldPassword ), $query->bindValue( sha1( 'qwerty' ) ) );
            $stmt = $query->prepare();
            $stmt->execute();

            $query = new ezcQueryInsert( $this->db );
            $query->insertInto( $this->db->quoteIdentifier( self::$table ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldId ), $query->bindValue( '2' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldUser ), $query->bindValue( 'john.doe' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldPassword ), $query->bindValue( crypt( 'foobar', 'jo' ) ) );
            $stmt = $query->prepare();
            $stmt->execute();

            $query = new ezcQueryInsert( $this->db );
            $query->insertInto( $this->db->quoteIdentifier( self::$table ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldId ), $query->bindValue( '3' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldUser ), $query->bindValue( 'zhang.san' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldPassword ), $query->bindValue( md5( 'asdfgh' ) ) );
            $stmt = $query->prepare();
            $stmt->execute();

            $query = new ezcQueryInsert( $this->db );
            $query->insertInto( $this->db->quoteIdentifier( self::$table ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldId ), $query->bindValue( '4' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldUser ), $query->bindValue( 'hans.mustermann' ) )
                  ->set( $this->db->quoteIdentifier( self::$fieldPassword ), $query->bindValue( 'abcdef' ) );
            $stmt = $query->prepare();
            $stmt->execute();

        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( "Cannot insert test values into table '" . self::$table . "'. " . $e->getMessage() );
        }
    }

    public function tearDown()
    {
        $this->db->exec( 'DROP TABLE ' . $this->db->quoteIdentifier( self::$table ) );
    }

    public function testDatabasePasswordNull()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', null );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testDatabaseSha1Correct()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testDatabaseSha1Fail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'jan.modaal', 'wrong password' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testDatabaseCryptCorrect()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'joB9EZ4O1cXDk' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testDatabaseCryptFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'john.doe', 'wrong password' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testDatabaseMd5Correct()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'a152e841783914146e4bcd4f39100686' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testDatabaseMd5Fail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'zhang.san', 'wrong password' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testDatabasePlainCorrect()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'abcdef' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( true, $authentication->run() );
    }

    public function testDatabasePlainFail()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'hans.mustermann', 'wrong password' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testDatabasePlainFailIncorrectUsername()
    {
        $credentials = new ezcAuthenticationPasswordCredentials( 'no such user', 'wrong password' );
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $authentication = new ezcAuthentication( $credentials );
        $authentication->addFilter( new ezcAuthenticationDatabaseFilter( $database ) );
        $this->assertEquals( false, $authentication->run() );
    }

    public function testDatabaseInfo()
    {
        $database = ezcAuthenticationDatabaseInfo::__set_state( array( 'instance' => $this->db, 'table' => self::$table, 'fields' => array( self::$fieldUser, self::$fieldPassword ) ) );
        $this->assertEquals( $this->db, $database->instance );
        $this->assertEquals( self::$table, $database->table );
        $this->assertEquals( array( self::$fieldUser, self::$fieldPassword ), $database->fields );
    }

    public function testDatabaseOptions()
    {
        $options = new ezcAuthenticationDatabaseOptions();

        try
        {
            $options->no_such_option = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_option'.", $e->getMessage() );
        }

        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $filter = new ezcAuthenticationDatabaseFilter( $database );
        $filter->setOptions( $options );
        $this->assertEquals( $options, $filter->getOptions() );
    }

    public function testDatabaseProperties()
    {
        $database = new ezcAuthenticationDatabaseInfo( $this->db, self::$table, array( self::$fieldUser, self::$fieldPassword ) );
        $filter = new ezcAuthenticationDatabaseFilter( $database );
        $this->assertEquals( true, isset( $filter->database ) );
        $this->assertEquals( false, isset( $filter->no_such_property ) );

        try
        {
            $filter->no_such_property = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }

        try
        {
            $filter->database = 'wrong value';
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'database' is invalid. Allowed values are: instance of ezcAuthenticationDatabaseInfo.", $e->getMessage() );
        }

        try
        {
            $value = $filter->no_such_property;
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }
}
?>

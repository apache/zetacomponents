<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * A factory to create a database connections
 * using previously set parameters.
 *
 * We use MyDB::create() to create a database connection from any place
 * without passing connection parameters every time.
 * (this is not the same as singleton since the connection is not stored in
 * a static member)

 * @package Database
 * @subpackage Tests
 */
class MyDB
{
    static private $instance = null;
    static private $dbParams = null;

    static public function setParams( $dbParams )
    {
        self::$dbParams = $dbParams;
    }

    static public function create()
    {
        // create instance
        if ( self::$dbParams === null )
            throw new Exception( "Missing database " .
                                 "connection parameteters." );

        return ezcDbFactory::create( self::$dbParams );
    }
}

/**
 * Testing how nested transactions work.
 *
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseTransactionsTest extends ezcTestCase
{
    protected function setUp()
    {
        try
        {
            $dbparams = ezcTestSettings::getInstance()->db->dsn;
            MyDB::setParams( $dbparams );
            $this->db = MyDB::create();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }
    }

    // normal: test nested transactions
    public function test1()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->beginTransaction();
            $this->db->commit();
            $this->db->beginTransaction();
            $this->db->commit();
            $this->db->commit();
        }
        catch ( ezcDbTransactionException $e )
        {
            $this->fail( "Exception (" . get_class( $e ) . ") caught: " . $e->getMessage() );
        }
    }

    public function test2()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->beginTransaction();
            $this->db->beginTransaction();
            $this->db->beginTransaction();
            $this->db->commit();
            $this->db->commit();
        }
        catch ( Exception $e )
        {
            $this->fail( "Should not throw exception here since the action doesn't have to be user initiated" );
        }

    }

    // error: more COMMITs than BEGINs
    public function test3()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->commit();
            $this->db->commit();
            $this->db->commit();
            $this->db->commit();
            $this->db->commit();
        }
        catch ( ezcDbTransactionException $e )
        {
            return;
        }

        $this->fail( "The case when there were more COMMITs than BEGINs did not fail.\n" );
    }

    // normal: BEGIN, BEGIN, COMMIT, then ROLLBACK
    public function test4()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->beginTransaction();
            $this->db->commit();
            $this->db->rollback();
        }
        catch ( ezcDbException $e )
        {
            $this->fail( "Exception (" . get_class( $e ) . ") caught: " . $e->getMessage() );
        }
    }

    // normal: BEGIN, BEGIN, ROLLBACK, then COMMIT
    public function test5()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->beginTransaction();
            $this->db->rollback();
            $this->db->commit();
        }
        catch ( ezcDbException $e )
        {
            $this->fail( "Exception (" . get_class( $e ) . ") caught: " . $e->getMessage() );
        }
    }

    // error: BEGIN, ROLLBACK, COMMIT
    public function test6()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->rollback();
            $this->db->commit();
        }
        catch ( ezcDbTransactionException $e )
        {
            return;
        }

        $this->fail( "The case with consequent BEGIN, ROLLBACK, COMMIT did not fail.\n" );
    }

    // error: BEGIN, COMMIT, ROLLBACK
    public function test7()
    {
        try
        {
            $this->db->beginTransaction();
            $this->db->commit();
            $this->db->rollback();
        }
        catch ( ezcDbTransactionException $e )
        {
            return;
        }

        $this->fail( "The case with consequent BEGIN, COMMIT, ROLLBACK did not fail.\n" );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcDatabaseTransactionsTest" );
    }
}
?>

<?php
/**
 * Test script.
 *
 * This script contains some typical example of how to use Database component.
 * The examples does not show the SQL abstraction layer usage since it's not implemented yet.
 *
 * Examples:
 * 1. Create a connection to MySQL with the factory class.
 * 2. Use the singleton API to keep database connection handle.
 * 3. Keeping two named connection in singletons.
 * 4. Connecting to PostgreSQL.
 * 5. Connecting to Oracle using user-specified handler.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @ignore
 */

/**
 * User-specified handler for Oracle.
 * Used in runTest5().
 *
 * @see Tests::runTest5().
 *
 * @package Database
 * @ignore
 *
 */
class MyOciDbHandler extends ezcDbHandler
{
    public function __construct( $dbParams )
    {
        if ( isset( $dbParams['database'] ) )
        {
            $database = $dbParams['database'];
        }
        else
        {
            throw new ezcDbException( ezcDbException::MISSING_DATABASE_NAME );
        }

        $dsn = "oci:dbname=$database";
        parent::__construct( $dbParams, $dsn );
    }


    static public function getName()
    {
        return 'myoracle';
    }
}

/**
 * Show typical simple use-cases for the Database component.
 *
 * @package Database
 * @ignore
 */
class Tests
{
    private $DbSettings;

    public function __construct( $dbsettings )
    {
        $this->DbSettings = $dbsettings;
    }

    /**
     * Run all the tests.
     */
    public function runAll()
    {
        $this->runTest1();
        $this->runTest2();
        $this->runTest3();
        $this->runTest4();
        $this->runTest5();
    }

    /**
     * The simpliest case: not using the ezcDbInstance class.
     * Application just creates a database handler instance using the factory class,
     * then uses the instance for database operations.
     */
    private function runTest1()
    {
        echo "test1:\n";
        $dbparams = array( 'type'     => 'mysql',
                           'database' => $this->DbSettings['my_dbname1'],
                           'user'     => $this->DbSettings['my_user'],
                           'pass'     => $this->DbSettings['my_pass'] );
        $db = ezcDbFactory::create( $dbparams );
        $this->showTablesCount( $db );
    }

    /**
     * A more complex case: using singleton.
     * After creating a handler instance, the instance is saved in a singleton.
     * That allows us to avoid passing instance to every functions that needs to use it.
     * Instead, we just call ezcDbInstance::get().
     */
    private function runTest2()
    {
        echo "test2:\n";
        $dbparams = array( 'type'     => 'mysql',
                           'database' => $this->DbSettings['my_dbname1'],
                           'user'     => $this->DbSettings['my_user'],
                           'pass'     => $this->DbSettings['my_pass'] );
        $db = ezcDbFactory::create( $dbparams );

        ezcDbInstance::set( $db );
        unset( $db );

        $db = ezcDbInstance::get();

        $this->showTablesCount( $db );
    }

    /**
     * The most complex case: using two named instances.
     */
    private function runTest3()
    {
        echo "test3:\n";
        $dbparams1 = array( 'type'     => 'mysql',
                            'database' => $this->DbSettings['my_dbname1'],
                            'user'     => $this->DbSettings['my_user'],
                            'pass'     => $this->DbSettings['my_pass'] );
        $dbparams2 = array( 'type'     => 'mysql',
                            'database' => $this->DbSettings['my_dbname2'],
                            'user'     => $this->DbSettings['my_user'],
                            'pass'     => $this->DbSettings['my_pass'] );
        try
        {
            $db1 = ezcDbFactory::create( $dbparams1 );
        }
        catch ( PDOException $e )
        {
            echo "Error connecting to db #1: " . $e->getMessage() . "\n";
            return;
        }

        try
        {
            $db2 = ezcDbFactory::create( $dbparams2 );
        }
        catch ( PDOException $e )
        {
            echo "Error connecting to db #2: " . $e->getMessage() . "\n";
            return;
        }

        ezcDbInstance::reset();
        ezcDbInstance::set( $db1, 'db1' );
        ezcDbInstance::set( $db2, 'db2' );
        unset( $db1, $db2 );

        $db1 = ezcDbInstance::get( 'db1' );
        $db2 = ezcDbInstance::get( 'db2' );

        $this->showTablesCount( $db1 );
        $this->showTablesCount( $db2 );
    }

    /**
     * Test PostgreSQL connectivity.
     */
    private function runTest4()
    {
        echo "test4:\n";
        $dbparams = array( 'type'     => 'pgsql',
                           'database' => $this->DbSettings['pg_dbname'],
                           'user'     => $this->DbSettings['pg_user'],
                           'pass'     => $this->DbSettings['pg_pass'] );
        $db = ezcDbFactory::create( $dbparams );

        $rslt = $db->query( "SELECT COUNT( relname ) as cnt FROM pg_class ".
                            "WHERE relkind='r' AND NOT relname~'pg_.*'" );
        $rows = $rslt->fetchAll();
        echo $rows[0]['cnt'] . " tables in the database.\n";
    }


    /**
     * Using a user-specified database handler to connect to Oracle.
     */
    private function runTest5()
    {
        echo "test5:\n";
        ezcDbFactory::addImplementation( 'myoci', 'MyOciDbHandler' );

        $dbparams = array( 'type'     => 'myoci',
                           'database' => $this->DbSettings['ora_dbname'],
                           'user'     => $this->DbSettings['ora_user'],
                           'pass'     => $this->DbSettings['ora_pass'] );
        $db = ezcDbFactory::create( $dbparams );

        $rslt = $db->query( 'SELECT count(*) AS cnt FROM user_tables' );
        $rows = $rslt->fetchAll();
        echo $rows[0]['cnt'] . " tables in the database.\n";
    }

    /**
     * Fetches number of tables in the given database.
     *
     * @param $db ezcDbHandler Database connection handle.
     */
    private function showTablesCount( $db )
    {
        $rslt = $db->query( 'SHOW TABLES' );
        echo count( $rslt->fetchAll() ) . " tables in the database.\n";
    }

}

/**
 * Loads component's classes automatically.
 *
 * @ignore
 */
function __autoload( $className )
{
    $path = strtolower( preg_replace( '/([A-Z])/', '/\\1', $className ) );
    $path = str_replace( 'ezc/', '', $path ) . '.php';
    require_once( $path );
}


##############################################################################
error_reporting( E_ALL );
$dbSettings = array( 'my_dbname1' => 'trunk',
                     'my_dbname2' => 'stable35',
                     'my_user'    => 'root',
                     'my_pass'    => '',
                     'pg_dbname'  => 'trunk',
                     'pg_user'    => 'fred',
                     'pg_pass'    => '',
                     'ora_user'   => 'scott',
                     'ora_pass'   => 'tiger',
                     'ora_dbname' => 'orcl' );

try
{
    $tests = new Tests( $dbSettings );
    $tests->runAll();
}
catch ( Exception $e )
{
    echo "Exception of class " . get_class( $e ) .
         " occured: " . $e->getMessage() . "\n";
    exit( 1 );
}
?>

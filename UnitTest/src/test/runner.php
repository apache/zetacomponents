<?php
// Prevent that our extended class starts to run.
if ( !defined( 'PHPUnit_MAIN_METHOD' ) )
{
    define( 'PHPUnit_MAIN_METHOD', 'TestRunner::main' );
}

require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Util/Filter.php';

class ezcTestRunner extends PHPUnit_TextUI_TestRunner
{
    const SUITE_FILENAME = "tests/suite.php";

    public function __construct()
    {
        // Call this method only once?
        $printer = new ezcTestPrinter();
        $this->setPrinter( $printer );

        // Remove this file name from the assertion trace.
        // (Displayed when a test fails)
        PHPUnit_Util_Filter::addFileToFilter( __FILE__ );
    }

    /**
     * For now, until the Console Tools is finished, we use the following
     * parameters:
     *
     * Arguments:
     *
     * [1] => Database DSN
     * [2] => Database DSN, Suite file.
     * [3] => Database DSN, file, class name.
     *
     */
    public static function main()
    {
        $tr = new ezcTestRunner();
        $tr->runFromArguments();
    }

    /** 
     * Registers the consoleInput options and arguments.
     *
     * The options and arguments are registered in the given $consoleInput object.
     *
     * @param ezcConsoleInput $consoleInput
     * @return void
     */
    protected static function registerConsoleArguments( $consoleInput )
    {
        // Help option
        $help = new ezcConsoleOption( '', 'help', ezcConsoleInput::TYPE_NONE );
        $help->shorthelp = "Show this help";
        $consoleInput->registerOption( $help  );

        $help = new ezcConsoleOption( 'r', 'release', ezcConsoleInput::TYPE_STRING );
        $help->shorthelp = "The release from the svn. e.g: trunk, 1.0, 1.0rc1, etc. Default release is trunk.";
        $consoleInput->registerOption( $help  );

        // DSN option
        $dsn = new ezcConsoleOption( 'D', 'dsn', ezcConsoleInput::TYPE_STRING );
        $dsn->shorthelp = "Use the database specified with a DSN: type://user:password@host/database.";
        $dsn->longhelp   = "An example to connect with the local MySQL database is:\n";
        $dsn->longhelp  .= "mysql://root@mypass@localhost/unittests";
        $consoleInput->registerOption( $dsn  );

        // host 
        $host = new ezcConsoleOption( 'h', 'host', ezcConsoleInput::TYPE_STRING );
        $host->shorthelp = "Hostname of the database";
        $consoleInput->registerOption( $host  );

        // type 
        $type = new ezcConsoleOption( 't', 'type', ezcConsoleInput::TYPE_STRING );
        $type->shorthelp = "Type of the database: (mysql, postsql, oracle, etc).";
        $consoleInput->registerOption( $type );

        // user 
        $user = new ezcConsoleOption( 'u', 'user', ezcConsoleInput::TYPE_STRING );
        $user->shorthelp = "User to connect with the database.";
        $consoleInput->registerOption( $user );

        // password 
        $password = new ezcConsoleOption( 'p', 'password', ezcConsoleInput::TYPE_STRING );
        $password->shorthelp = "Password that belongs to the user that connect with the database.";
        $consoleInput->registerOption( $password );

        // database 
        $database = new ezcConsoleOption( 'd', 'database', ezcConsoleInput::TYPE_STRING );
        $database->shorthelp = "Database name.";
        $consoleInput->registerOption( $database );

        // Add relations, one for all.
        $type->addDependency( new ezcConsoleOptionRule( $host ) );
        $user->addDependency( new ezcConsoleOptionRule( $host ) );
        $database->addDependency( new ezcConsoleOptionRule( $host ) );

        // Add relations, all for one.
        $host->addDependency( new ezcConsoleOptionRule( $type ) );
        $host->addDependency( new ezcConsoleOptionRule( $user ) );
        $host->addDependency( new ezcConsoleOptionRule( $database ) );

        // And the password belongs to the user.
        $password->addDependency( new ezcConsoleOptionRule( $user ) );

        // Exclude DSN from the host parameters.
        $host->addExclusion( new ezcConsoleOptionRule( $dsn ) );
    }

    protected static function processConsoleArguments( $consoleInput )
    {
        try
        {
             $consoleInput->process();
        }
        catch ( ezcConsoleOptionException $e )
        {
            die ( $e->getMessage() );
        }
    }

    protected static function displayHelp( $consoleInput )
    {
        echo ("runtests [OPTION...]  [PACKAGE | FILE] [PACKAGE | FILE] ... \n\n" );
        $options = $consoleInput->getOptions();

        foreach ( $options as $option )
        {
            echo "-{$option->short}, --{$option->long}\t    {$option->shorthelp}\n";
        }

        echo "\n";
    }

    public function runFromArguments()
    {
        $consoleInput = new ezcConsoleInput();
        self::registerConsoleArguments( $consoleInput );
        self::processConsoleArguments( $consoleInput );

        if ( $consoleInput->getOption( "help" )->value )
        {
            self::displayHelp( $consoleInput );
            exit();
        }

        if ( $consoleInput->getOption( 'dsn' )->value || $consoleInput->getOption( 'host' )->value )
        {
            $dsn = $consoleInput->getOption( 'dsn' )->value;
            $type = $consoleInput->getOption( 'type' )->value;
            $user = $consoleInput->getOption( 'user' )->value;
            $password = $consoleInput->getOption( 'password' )->value;
            $host = $consoleInput->getOption( 'host' )->value;
            $database = $consoleInput->getOption( 'database' )->value;

            try 
            {
                $this->initializeDatabase( $dsn, $type, $user, $password, $host, $database );
            }
            catch ( Exception $e )
            {
                print( "Database initialization error: {$e->getMessage()}\n" );
                return;
            }
        }
        $this->printCredits();

        print( '[Preparing tests]:' );

        // Set the release. Default is trunk. 
        $release = $consoleInput->getOption( 'release' )->value;
        $release = ( $release == false || $release == "trunk" ? "trunk" : "releases/$release" );

        $allSuites = $this->prepareTests( $consoleInput->getArguments(),  $release );

        $this->doRun( $allSuites );
    }

    protected function printCredits()
    {
        $version = PHPUnit_Runner_Version::getVersionString();
        $pos = strpos( $version, "by Sebastian" );

        print( "ezcUnitTest uses the " . substr( $version, 0, $pos ) . "framework from Sebastian Bergmann.\n\n" );
    }

    protected function prepareTests( $packages, $release )
    {
        $directory = dirname( __FILE__ ) . "/../../..";
 
        $allSuites = new ezcTestSuite();
        $allSuites->setName( "[Testing]" );

        if ( sizeof( $packages ) == 0 )
        {
            $packages = $this->getPackages( $directory );
        }

        foreach ( $packages as $package )
        {
            if ( strpos( $package, "/" ) !== false )
            {
                if ( file_exists( $package ) )
                {
                    require_once( $package );
                    $class = $this->getClassName( $package );

                    if ( $class !== false )
                    {
                        $allSuites->addTest( call_user_func( array( $class, 'suite' ) ) );
                    }
                    else
                    {
                        echo "\n Cannot load: $package. \n";
                    }
                }
            }
            else 
            {
                $suite = $this->getTestSuite( $directory, $package, $release );

                if ( !is_null( $suite ) )
                {
                    $allSuites->addTest( $suite );
                }
            }
        }

        return $allSuites;
    }

    public function runTest( $filename )
    {
    }

    public function getClassName( $file )
    {
        $classes = get_declared_classes();

        $size = count( $classes );
        $total = $size > 30 ? 30 : $size;

        // check only the last 30 classes.
        for ( $i = $size - 1; $i > $size - $total - 1; $i-- )
        {
            $rf = new ReflectionClass( $classes[$i] );

            $len = strlen( $file );
            if ( strcmp( $file, substr( $rf->getFileName(), -$len ) ) == 0 )
            {
                return $classes[$i];
            }
        }
    }

    /**
     * @param string $dir Absolute or relative path to directory to look in.
     *
     * @return array Package names.
     */
    protected function getPackages( $dir )
    {
        $packages = array();

        if ( is_dir( $dir ) )
        {
            if ( $dh = opendir( $dir ) )
            {
                while ( ( $entry = readdir( $dh ) ) !== false )
                {
                    if ( $this->isPackage( $dir, $entry ) )
                    {
                        $packages[] = $entry;
                    }
                }
                closedir( $dh );
            }
         }

        return $packages;
    }

    protected function isPackage( $dir, $entry )
    {
        // Prepend directory if needed.
        $fullPath = $dir == "" ? $entry : $dir ."/". $entry;

        // Check if it is a package.
        if ( !is_dir( $fullPath ) )
        {
            return false;
        }
        if ( $entry[0] == "." )
        {
            return false; // .svn, ., ..
        }

        return true;
    }

    // Not used anymore.
    protected function isRelease( $dir, $entry )
    {
        // for now, they have the same rules.
        return $this->isPackage( $dir, $entry );
    }

    /**
     * @return array Releases from a package.
     * TODO: not used anymore.
     */
    protected function getReleases( $dir, $package )
    {
        $dir .= "/" . $package;

        $releases = array();
        if ( is_dir( $dir ) )
        {
            if ( $dh = opendir( $dir ) )
            {
                while ( ( $entry = readdir( $dh ) ) !== false )
                {
                    if ( $this->isRelease( $dir, $entry ) )
                    {
                        $releases[] = $entry;
                    }
                }
                closedir( $dh );
            }
         }

        return $releases;
    }

    /**
     * Runs a specific test suite from a package and release.
     *
     * @return bool True if the test has been run, false if not.
     */
    protected function getTestSuite( $dir, $package, $release )
    {
        $suitePath = implode( "/", array( $dir, '..', $release, $package, self::SUITE_FILENAME ) );

        if ( file_exists( $suitePath ) )
        {
            require_once( $suitePath );

            $className = "ezc". $package . "Suite";
           
            if ( method_exists( $className, "canRun" ) )
            {
                $canRun = call_user_func( array( $className, 'canRun' ) );
                if ( $canRun == false )
                {
                    print( "\n  Skipped: $className because the requirements for this test are not met. canRun() method returned false." );
                    return null;
                }
            }
            
            $s = call_user_func( array( $className, 'suite' ) );

            return $s;
        }

        return null;
    }

    protected function initializeDatabase( $dsn, $type, $user, $password, $host, $database )
    {
        $ts = ezcTestSettings::getInstance();

        if ( $dsn )
        {
            $settings = ezcDbFactory::parseDSN( $dsn );

            // Store the settings
            $ts->db->dsn = $dsn;
        }
        else
        {
            $settings = array( "type" => $type, 
                               "user" => $user, 
                               "password" => $password, 
                               "host" => $host, 
                               "database" => $database );
        }
    
        try
        {
            $ts->setDatabaseSettings( $settings );
            $db = ezcDbFactory::create( $settings );
            ezcDbInstance::set( $db );
        }
        catch ( ezcDbException $e )
        {
            die( $e->getMessage() );
        }

        // TODO Check if the database exists, and whether it is empty.

    }

    protected function printError( $errorString )
    {
        print( $errorString . "\n\n" );

        print( "The DSN should look like: <Driver>://<User>[:Password]@<Host>/<Database> \n" );
        print( "For example: mysql://root:root@localhost/unittests\n\n" );
        exit();
    }
}
?>

<?php
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Util/Filter.php';

class ezcTestRunner extends PHPUnit_TextUI_TestRunner
{
    const SUITE_FILENAME = "tests/suite.php";

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
        $help->shorthelp = "The release from the svn. Use either 'trunk' or 'stable'.";
        $help->default = 'trunk';
        $consoleInput->registerOption( $help  );

        // DSN option
        $dsn = new ezcConsoleOption( 'D', 'dsn', ezcConsoleInput::TYPE_STRING );
        $dsn->shorthelp = "Use the database specified with a DSN: type://user:password@host/database.";
        $dsn->longhelp   = "An example to connect with the local MySQL database is:\n";
        $dsn->longhelp  .= "mysql://root@mypass@localhost/unittests";
        $consoleInput->registerOption( $dsn  );

        // coverage report dir
        $report = new ezcConsoleOption( 'c', 'report-dir', ezcConsoleInput::TYPE_STRING );
        $report->shorthelp = "Directory to store test reports and code coverage reports in.";
        $consoleInput->registerOption( $report );

        // xml logfile
        $xml = new ezcConsoleOption( 'x', 'log-xml', ezcConsoleInput::TYPE_STRING );
        $xml->shorthelp = "Log test execution in XML format to file.";
        $consoleInput->registerOption( $xml );

        // Verbose option
        $verbose = new ezcConsoleOption( 'v', 'verbose', ezcConsoleInput::TYPE_NONE );
        $verbose->shorthelp = "Output more verbose information.";
        $consoleInput->registerOption( $verbose  );
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
        echo $consoleInput->getHelpText( 'eZ components test runner' );
    }

    public function runFromArguments()
    {
        /* The following hack is needed so that we can also test the console tools in the stable branch */
        if ( in_array( 'stable', $_SERVER['argv'] ) )
        {
            ezcBase::setWorkingDirectory( getcwd() );
        }

        $consoleInput = new ezcConsoleInput();
        self::registerConsoleArguments( $consoleInput );
        self::processConsoleArguments( $consoleInput );

        if ( $consoleInput->getOption( "help" )->value )
        {
            self::displayHelp( $consoleInput );
            exit();
        }

        if ( $consoleInput->getOption( 'dsn' )->value )
        {
            $dsn = $consoleInput->getOption( 'dsn' )->value;

            try 
            {
                $this->initializeDatabase( $dsn );
            }
            catch ( Exception $e )
            {
                print( "Database initialization error: {$e->getMessage()}\n" );
                return;
            }
        }
        $this->printCredits();

        print( '[Preparing tests]:' );
        $params = array();

        // Set the release. Default is trunk. 
        $release = $consoleInput->getOption( 'release' )->value;

        $allSuites = $this->prepareTests( $consoleInput->getArguments(),  $release );
        $logfile   = $consoleInput->getOption( 'log-xml' )->value;
        $reportDir = $consoleInput->getOption( 'report-dir' )->value;

        if ( $logfile )
        {
            $params['xmlLogfile'] = $logfile;
        }

        if ( $reportDir )
        {
            $params['reportDirectory'] = $reportDir;
        }

        if ( $consoleInput->getOption( "verbose" )->value )
        {
            $params['verbose'] = true;
        }
        else
        {
            $params['verbose'] = false;
        }

        $printer = new ezcTestPrinter( $params['verbose'] );
        $this->setPrinter( $printer );

        $this->doRun( $allSuites, $params );
    }

    protected function printCredits()
    {
        print( "ezcUnitTest uses the PHPUnit " . PHPUnit_Runner_Version::id() . " framework from Sebastian Bergmann.\n\n" );
    }

    protected function prepareTests( $packages, $release )
    {
        $directory = getcwd();

        $allSuites = new ezcTestSuite();
        $allSuites->setName( "eZ components" );

        if ( sizeof( $packages ) == 0 )
        {
            $packages = $this->getPackages( $release, $directory );
        }

        foreach ( $packages as $package )
        {
            $slashCount = substr_count( $package, '/' );
            if ( ( $release == 'trunk' && $slashCount !== 0 ) || ( $release == 'stable' && $slashCount > 1 ) )
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
     * @param string $release Release branch (stable or trunk)
     * @param string $dir Absolute or relative path to directory to look in.
     *
     * @return array Package names.
     */
    protected function getPackages( $release, $dir )
    {
        $packages = array();

        if ( is_dir( $dir ) )
        {
            $entries = glob( $release == 'trunk' ? "$dir/*" : "$dir/*/*" );
            foreach ( $entries as $entry )
            {
                if ( $this->isPackageDir( $entry ) )
                {
                    $packages[] = str_replace( $dir . '/', '', $entry );
                }
            }
        }

        return $packages;
    }

    protected function isPackageDir( $dir )
    {
        // Check if it is a package.
        if ( !is_dir( $dir ) || !file_exists( $dir . '/tests/suite.php' ) )
        {
            return false;
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

            if ( $release == 'stable' )
            {
                $package = substr( $package, 0, strpos( $package, '/' ) );
            }
            $className = "ezc". $package . "Suite";

            $s = call_user_func( array( $className, 'suite' ) );

            return $s;
        }

        return null;
    }

    protected function initializeDatabase( $dsn )
    {
        $ts = ezcTestSettings::getInstance();
        $settings = ezcDbFactory::parseDSN( $dsn );

        // Store the settings
        $ts->db->dsn = $dsn;
    
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
    }

    public static function addFileToFilter( $filename, $group = 'DEFAULT' )
    {
        PHPUnit_Util_Filter::addFileToFilter( $filename, $group );
    }
}

ezcTestRunner::addFileToFilter( __FILE__ );
?>

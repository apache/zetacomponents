<?php
/**
 * File contaning the ezcTestRunner class.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Util/Class.php';
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Test runner to run eZ Components test suites.
 *
 * @package UnitTest
 * @version //autogentag//
 */
class ezcTestRunner extends PHPUnit_TextUI_TestRunner
{
    const SUITE_FILENAME = 'tests/suite.php';

    public static function main()
    {
        $version = PHPUnit_Runner_Version::id();

        if ( version_compare( $version, '3.1.2' ) == -1 && $version !== '@package_version@' )
        {
            echo "You need PHPUnit 3.1.2 (or later) to run this testsuite.\n";
            die();
        }

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
        $help->shorthelp = 'Show this help';
        $consoleInput->registerOption( $help );

        // Release option
        $help = new ezcConsoleOption( 'r', 'release', ezcConsoleInput::TYPE_STRING );
        $help->shorthelp = "The release from the svn. Use either 'trunk' or 'stable'.";
        $help->default = 'trunk';
        $consoleInput->registerOption( $help );

        // DSN option
        $dsn = new ezcConsoleOption( 'D', 'dsn', ezcConsoleInput::TYPE_STRING );
        $dsn->shorthelp = 'Use the database specified with a DSN: type://user:password@host/database.';
        $dsn->longhelp   = 'An example to connect with the local MySQL database is:\n';
        $dsn->longhelp  .= 'mysql://root@mypass@localhost/unittests';
        $consoleInput->registerOption( $dsn );

        // Code Coverage HTML option
        $report = new ezcConsoleOption( '', 'coverage-html', ezcConsoleInput::TYPE_STRING );
        $report->shorthelp = 'Generate code coverage report in HTML format to directory.';
        $consoleInput->registerOption( $report );

        // Code Coverage XML option
        $coverage = new ezcConsoleOption( '', 'coverage-xml', ezcConsoleInput::TYPE_STRING );
        $coverage->shorthelp = 'Write code coverage data in Clover XML format.';
        $consoleInput->registerOption( $coverage );

        // Filter option
        $filter = new ezcConsoleOption( '', 'filter', ezcConsoleInput::TYPE_STRING );
        $filter->shorthelp = 'Filter which tests to run.';
        $consoleInput->registerOption( $filter );

        // Project Mess Detector (PMD) XML option
        $pmd = new ezcConsoleOption( '', 'log-pmd', ezcConsoleInput::TYPE_STRING );
        $pmd->shorthelp = 'Write violations report in PMD XML format.';
        $consoleInput->registerOption( $pmd );

        // Logfile XML option
        $xml = new ezcConsoleOption( '', 'log-xml', ezcConsoleInput::TYPE_STRING );
        $xml->shorthelp = 'Log test execution in XML format to file.';
        $consoleInput->registerOption( $xml );

        // XML Configuration File option
        $configuration = new ezcConsoleOption( '', 'configuration', ezcConsoleInput::TYPE_STRING );
        $configuration->shorthelp = 'Read configuration from XML file.';
        $consoleInput->registerOption( $configuration );

        // Verbose option
        $verbose = new ezcConsoleOption( 'v', 'verbose', ezcConsoleInput::TYPE_NONE );
        $verbose->shorthelp = 'Output more verbose information.';
        $consoleInput->registerOption( $verbose );
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
        echo $consoleInput->getHelpText( 'eZ Components Test Runner' );
    }

    public function runFromArguments()
    {
        /* The following hack is needed so that we can also test the
           console tools in the stable branch */
        if ( in_array( 'stable', $_SERVER['argv'] ) )
        {
            ezcBase::setWorkingDirectory( getcwd() );
        }

        $consoleInput = new ezcConsoleInput();
        self::registerConsoleArguments( $consoleInput );
        self::processConsoleArguments( $consoleInput );

        if ( $consoleInput->getOption( 'help' )->value )
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

        $params = array(
          'backupStaticAttributes'      => false,
          'convertErrorsToExceptions'   => true,
          'convertNoticesToExceptions'  => false,
          'convertWarningsToExceptions' => false
        );

        // Set the release. Default is trunk. 
        $release = $consoleInput->getOption( 'release' )->value;

        $config    = $consoleInput->getOption( 'configuration' )->value;
        $reportDir = $consoleInput->getOption( 'coverage-html' )->value;
        $coverage  = $consoleInput->getOption( 'coverage-xml' )->value;
        $filter    = $consoleInput->getOption( 'filter' )->value;
        $pmd       = $consoleInput->getOption( 'log-pmd' )->value;
        $logfile   = $consoleInput->getOption( 'log-xml' )->value;

        $fillWhitelist = false;

        if ( $filter )
        {
            $params['filter'] = $filter;
        }

        if ( $config )
        {
            $params['configuration'] = $config;
        }

        if ( $logfile )
        {
            $params['xmlLogfile'] = $logfile;
        }

        if ( $coverage )
        {
            $params['coverageXML'] = $coverage;
            $fillWhitelist = true;
        }

        if ( $pmd )
        {
            $params['pmdXML'] = $pmd;
            $fillWhitelist = true;
        }

        if ( $reportDir )
        {
            $params['reportDirectory'] = $reportDir;
            $fillWhitelist = true;
        }

        if ( $consoleInput->getOption( 'verbose' )->value )
        {
            $params['verbose'] = true;
        }
        else
        {
            $params['verbose'] = false;
        }

        $this->setPrinter( new ezcTestPrinter( $params['verbose'] ) );

        $allSuites = $this->prepareTests( $consoleInput->getArguments(), $release, $fillWhitelist );
        $result    = $this->doRun( $allSuites, $params );

        if ( $result->errorCount() > 0 )
        {
            exit( PHPUnit_TextUI_TestRunner::EXCEPTION_EXIT );
        }

        if ( $result->failureCount() > 0 )
        {
            exit( PHPUnit_TextUI_TestRunner::FAILURE_EXIT );
        }

        exit( PHPUnit_TextUI_TestRunner::SUCCESS_EXIT );
    }

    protected function printCredits()
    {
        print( "ezcUnitTest uses the PHPUnit " . PHPUnit_Runner_Version::id() . " framework from Sebastian Bergmann.\n\n" );
    }

    protected function prepareTests( $packages, $release, $fillWhitelist )
    {
        print( '[Preparing tests]:' );

        $directory = getcwd();

        $allSuites = new PHPUnit_Framework_TestSuite;
        $allSuites->setName( 'eZ Components' );

        if ( sizeof( $packages ) == 0 )
        {
            $packages = $this->getPackages( $release, $directory );
        }

        foreach ( $packages as $package )
        {
            $added      = false;
            $slashCount = substr_count( $package, DIRECTORY_SEPARATOR );

            if ( ( $release == 'trunk'  && $slashCount !== 0 ) ||
                 ( $release == 'stable' && $slashCount > 1 ) )
            {
                if ( file_exists( $package ) )
                {
                    PHPUnit_Util_Class::collectStart();
                    require_once( $package );
                    $class = PHPUnit_Util_Class::collectEnd();

                    if ( count( $class ) > 0 )
                    {
                        $allSuites->addTest( call_user_func( array( array_pop( $class ), 'suite' ) ) );
                        $added   = true;
                        $package = substr($package, 0, strpos($package, DIRECTORY_SEPARATOR));
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
                    $added = true;
                }
            }

            if ( $fillWhitelist && $added )
            {
                foreach ( glob( $directory . '/' . $package . '/src/*_autoload.php' ) as $autoloadFile )
                {
                    foreach ( include $autoloadFile as $className => $fileName )
                    {
                        if ( strpos($fileName, 'xmlwritersubstitute.php') === false )
                        {
                            PHPUnit_Util_Filter::addFileToWhitelist(
                              $directory . '/' . str_replace( $package, $package . '/src', $fileName )
                            );
                        }
                    }
                }
            }
        }

        return $allSuites;
    }

    /**
     * @param  string $release Release branch (stable or trunk)
     * @param  string $dir     Absolute or relative path to packages directory
     * @return array           Package names
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
        if ( !is_dir( $dir ) || !file_exists( $dir . '/tests/suite.php' ) )
        {
            return false;
        }

        return true;
    }

    protected function getTestSuite( $dir, $package, $release )
    {
        $suitePath = implode( '/', array( $dir, '..', $release, $package, self::SUITE_FILENAME ) );

        if ( file_exists( $suitePath ) )
        {
            require_once( $suitePath );

            if ( $release == 'stable' )
            {
                $package = substr( $package, 0, strpos( $package, '/' ) );
            }

            $className = 'ezc'. $package . 'Suite';
            $suite     = call_user_func( array( $className, 'suite' ) );

            return $suite;
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
}
?>

<?php

class ezcWebdavTestCadaverTester
{
    protected $client;

    public function __construct( ezcWebdavTestCadaverClient $client )
    {
        $this->client = $client;
    }

    public function run( array $commands, array $expectedResults )
    {
        $this->checkConsistency( $commands, $expectedResults );

        foreach ( $commands as $section => $comms )
        {
            foreach ( $comms as $id => $command )
            {
                $this->client->send( $command );
                if ( ($act = $this->client->receive() ) !== ( $exp = $expectedResults[$section][$id] ) )
                {
                    throw new RuntimeException(
                        "Invalid response from client. Expected: '$exp'. Actual: '$act'."
                    );
                }
            }
        }
    }

    public function generate( array $commands )
    {
        $results = array();
        foreach ( $commands as $section => $comms )
        {
            foreach ( $comms as $id => $command )
            {
                $this->client->send( $command );
                $results[$section][$id] = $this->client->receive();
            }
        }
        return $results;
    }

    public function inspect( array $commands, array $results )
    {
        $this->checkConsistency( $commands, $results );

        foreach ( $commands as $section => $comms )
        {
            echo "\n=========== $section ==========\n";
            foreach ( $comms as $id => $command )
            {
                echo "------------------- Command ------------------\n";
                echo $command;
                echo "------------------- Result -------------------\n";
                echo $results[$section][$id] . "\n";
                echo "----------------------------------------------\n\n";
            }
        }
    }

    public static function setupEnv()
    {
        $testBaseDir = 'run-tests-tmp';

        if ( !is_dir( $testBaseDir ) )
        {
            mkdir( $testBaseDir );
        }

        $testDir = tempnam( $testBaseDir, 'cadaver_client_test' );

        unlink( $testDir );
        mkdir( $testDir );

        mkdir( "{$testDir}/down" );
        mkdir( $targetDir = "{$testDir}/up" );

        self::copyRecursive(
            dirname( __FILE__ ) . '/../../data/put_test',
            $targetDir
        );

        return $testDir;
    }

    private static function copyRecursive( $sourceDir, $targetDir )
    {
        if ( !is_dir( $targetDir ) )
        {
            mkdir( $targetDir );
        }
        $dh = opendir( $sourceDir );
        while ( ( $file = readdir( $dh) ) !== false )
        {
            if ( $file[0] === '.' )
            {
                continue;
            }
            if ( is_dir( $nextSourceDir = "{$sourceDir}/{$file}" ) )
            {
                self::copyRecursive( $nextSourceDir, "{$targetDir}/{$file}" );
            }
            else
            {
                copy( "{$sourceDir}/{$file}", "{$targetDir}/{$file}" );
            }
        }
    }

    protected function checkConsistency( array $commands, $results )
    {
        if ( count( $commands ) !== count( $results ) )
        {
            throw new RuntimeException( 'Inconsistent commands / results.' );
        }

        foreach ( $commands as $section => $containedCommands )
        {
            if ( !isset( $results[$section] ) )
            {
                throw new RuntimeException( "Missing section $section in results." );
            }
            if ( count( $containedCommands ) !== count( $results[$section] ) )
            {
                throw new RuntimeException( "Inconsistent number of commands and results in section $section." );
            }
        }
    }
}

?>

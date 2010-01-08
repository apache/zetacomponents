<?php
/**
 * ezcGraphDatabaseTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphDatabaseTest extends ezcTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphDatabaseTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';

        // Try to build up database connection
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'Database connection required for PDO statement tests.' );
        }

        $this->q = new ezcQueryInsert( $db );
        try
        {
            $db->exec( 'DROP TABLE graph_pdo_test' );
        }
        catch ( Exception $e ) {} // eat

        // Create test table
        $db->exec( 'CREATE TABLE graph_pdo_test ( id INT, browser VARCHAR(255), hits INT )' );

        // Insert some data
        $db->exec( "INSERT INTO graph_pdo_test VALUES ( 0, 'Firefox', 2567 )" );
        $db->exec( "INSERT INTO graph_pdo_test VALUES ( 0, 'Opera', 543 )" );
        $db->exec( "INSERT INTO graph_pdo_test VALUES ( 0, 'Safari', 23 )" );
        $db->exec( "INSERT INTO graph_pdo_test VALUES ( 0, 'Konquror', 812 )" );
        $db->exec( "INSERT INTO graph_pdo_test VALUES ( 0, 'Lynx', 431 )" );
        $db->exec( "INSERT INTO graph_pdo_test VALUES ( 0, 'wget', 912 )" );
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }

        $db = ezcDbInstance::get();
        $db->exec( 'DROP TABLE graph_pdo_test' );
    }

    public function testAutomaticDataSetUsage()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT browser, hits FROM graph_pdo_test' );
        $statement->execute();

        $dataset = new ezcGraphDatabaseDataSet( $statement );

        $dataSetArray = array(
            'Firefox' => 2567,
            'Opera' => 543,
            'Safari' => 23,
            'Konquror' => 812,
            'Lynx' => 431,
            'wget' => 912,
        );

        $count = 0;
        foreach ( $dataset as $key => $value )
        {
            list( $compareKey, $compareValue ) = each( $dataSetArray );

            $this->assertEquals(
                $compareKey,
                $key,
                'Unexpected key for dataset value.'
            );

            $this->assertEquals(
                $compareValue,
                $value,
                'Unexpected value for dataset.'
            );

            ++$count;
        }

        $this->assertEquals(
            $count,
            count( $dataSetArray ),
            'Too few datasets found.'
        );
    }

    public function testAutomaticDataSetUsageSingleColumn()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT hits FROM graph_pdo_test' );
        $statement->execute();

        $dataset = new ezcGraphDatabaseDataSet( $statement );

        $dataSetArray = array(
            'Firefox' => 2567,
            'Opera' => 543,
            'Safari' => 23,
            'Konquror' => 812,
            'Lynx' => 431,
            'wget' => 912,
        );

        $count = 0;
        foreach ( $dataset as $key => $value )
        {
            list( $compareKey, $compareValue ) = each( $dataSetArray );

            $this->assertEquals(
                $count,
                $key,
                'Unexpected key for dataset value.'
            );

            $this->assertEquals(
                $compareValue,
                $value,
                'Unexpected value for dataset.'
            );

            ++$count;
        }

        $this->assertEquals(
            $count,
            count( $dataSetArray ),
            'Too few datasets found.'
        );
    }

    public function testAutomaticDataSetUsageTooManyRows()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT * FROM graph_pdo_test' );
        $statement->execute();

        try
        {
            $dataset = new ezcGraphDatabaseDataSet( $statement );
        }
        catch ( ezcGraphDatabaseTooManyColumnsException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphDatabaseTooManyColumnsException.' );
    }

    public function testSpecifiedDataSetUsage()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT * FROM graph_pdo_test' );
        $statement->execute();

        $dataset = new ezcGraphDatabaseDataSet(
            $statement,
            array(
                ezcGraph::KEY => 'browser',
                ezcGraph::VALUE => 'hits',
            )
        );

        $dataSetArray = array(
            'Firefox' => 2567,
            'Opera' => 543,
            'Safari' => 23,
            'Konquror' => 812,
            'Lynx' => 431,
            'wget' => 912,
        );

        $count = 0;
        foreach ( $dataset as $key => $value )
        {
            list( $compareKey, $compareValue ) = each( $dataSetArray );

            $this->assertEquals(
                $compareKey,
                $key,
                'Unexpected key for dataset value.'
            );

            $this->assertEquals(
                $compareValue,
                $value,
                'Unexpected value for dataset.'
            );

            ++$count;
        }

        $this->assertEquals(
            $count,
            count( $dataSetArray ),
            'Too few datasets found.'
        );
    }

    public function testSpecifiedDataSetUsageSingleColumn()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT * FROM graph_pdo_test' );
        $statement->execute();

        $dataset = new ezcGraphDatabaseDataSet(
            $statement,
            array(
                ezcGraph::VALUE => 'hits',
            )
        );

        $dataSetArray = array(
            'Firefox' => 2567,
            'Opera' => 543,
            'Safari' => 23,
            'Konquror' => 812,
            'Lynx' => 431,
            'wget' => 912,
        );

        $count = 0;
        foreach ( $dataset as $key => $value )
        {
            list( $compareKey, $compareValue ) = each( $dataSetArray );

            $this->assertEquals(
                $count,
                $key,
                'Unexpected key for dataset value.'
            );

            $this->assertEquals(
                $compareValue,
                $value,
                'Unexpected value for dataset.'
            );

            ++$count;
        }

        $this->assertEquals(
            $count,
            count( $dataSetArray ),
            'Too few datasets found.'
        );
    }

    public function testSpecifiedDataSetUsageBrokenKey()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT * FROM graph_pdo_test' );
        $statement->execute();

        try
        {
            $dataset = new ezcGraphDatabaseDataSet(
                $statement,
                array(
                    ezcGraph::KEY => 'nonexistant',
                    ezcGraph::VALUE => 'hits',
                )
            );
        }
        catch ( ezcGraphDatabaseMissingColumnException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphDatabaseMissingColumnException.' );
    }

    public function testSpecifiedDataSetUsageBrokenValue()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT * FROM graph_pdo_test' );
        $statement->execute();

        try
        {
            $dataset = new ezcGraphDatabaseDataSet(
                $statement,
                array(
                    ezcGraph::VALUE => 'nonexistant',
                )
            );
        }
        catch ( ezcGraphDatabaseMissingColumnException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphDatabaseMissingColumnException.' );
    }

    public function testNonExceutedQuery()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT browser, hits FROM graph_pdo_test' );

        try
        {
            $dataset = new ezcGraphDatabaseDataSet( $statement );
        }
        catch ( ezcGraphDatabaseStatementNotExecutedException $e )
        {
            return true;
        }
        
        $this->fail( 'Expected ezcGraphDatabaseStatementNotExecutedException.' );
    }

    public function testDataSetCount()
    {
        $db = ezcDbInstance::get();

        $statement = $db->prepare( 'SELECT * FROM graph_pdo_test' );
        $statement->execute();

        $dataset = new ezcGraphDatabaseDataSet(
            $statement,
            array(
                ezcGraph::VALUE => 'hits',
            )
        );

        $this->assertEquals(
            count( $dataset ),
            6,
            'Wrong data set item count returned'
        );
    }
}

?>

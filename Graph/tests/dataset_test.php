<?php
/**
 * ezcGraphDatasetTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphDatasetTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphDatasetTest" );
	}

    /**
     * setUp 
     * 
     * @access public
     */
    public function setUp()
    {
    }

    /**
     * tearDown 
     * 
     * @access public
     */
    public function tearDown()
    {
    }

    public function testCreateDatasetFromArray()
    {
        try 
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->humanoids = array( 'monkey' => 54, 'ape' => 37, 'human' => 9 );
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $datasets = $this->getNonPublicProperty( $chart, 'data' );
        $this->assertTrue(
            $datasets['humanoids'] instanceof ezcGraphDataset,
            'No ezcGraphDataset was created.'
        );
    }

    public function testGetDataset()
    {
        try 
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->humanoids = array( 'monkey' => 54, 'ape' => 37, 'human' => 9 );
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertTrue(
            $chart->humanoids instanceof ezcGraphDataset,
            'No ezcGraphDataset was created.'
        );
    }

    public function testDatasetContent()
    {
        try 
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->example = array( 'monkey' => 54, 2001 => 37 );
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $data = $this->getNonPublicProperty( $chart->example, 'data' );

        $this->assertSame( 
            54.,
            $data['monkey']
        );
        $this->assertSame( 
            37.,
            $data['2001']
        );
    }

    public function testCreateMultipleDatasetsFromArray()
    {
        try 
        {
            $chart = ezcGraph::create( 'Line' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );
        } 
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $datasets = $this->getNonPublicProperty( $chart, 'data' );
        $this->assertTrue(
            $datasets['income'] instanceof ezcGraphDataset,
            'No ezcGraphDataset was created.'
        );
        $this->assertTrue(
            $datasets['spending'] instanceof ezcGraphDataset,
            'No second ezcGraphDataset was created.'
        );
    }

    public function testCreateMultiplePiechartDatasetsFromArray()
    {
        try 
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->spending = array( 2000 => 2347.2, 2458.3, 2569.4 );
        }
        catch ( ezcGraphTooManyDatasetsExceptions $e )
        {
            return true;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphTooManyDatasetsExceptions.' );
    }

    public function testDatasetLabel()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            'income',
            $chart->income->label->default
        );
    }

    public function testDatasetSetLabel()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->label = 'Income Label';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            'Income Label',
            $chart->income->label->default
        );
    }

    public function testDatasetSetColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->color = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->income->color->default
        );
    }

    public function testDatasetSetSymbol()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->symbol = ezcGraph::DIAMOND;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart->income->symbol->default
        );
    }

    public function testDatasetSetSingleColor()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->color[2001] = '#FF0000';
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->income->color[2001]
        );
    }

    public function testDatasetSetSingleSymbol()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->symbol[2001] = ezcGraph::DIAMOND;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart->income->symbol[2001]
        );
    }

    public function testDatasetPropertyValueFallback()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->symbol = ezcGraph::DIAMOND;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart->income->symbol[2001]
        );
    }

    public function testDatasetSetNonexistingSingle()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income->symbol[2006] = ezcGraph::DIAMOND;
        }
        catch ( ezcGraphNoSuchDataException $e )
        {
            return true;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->fail( 'Expected ezcGraphNoSuchDataException.' );
    }

    public function testDatasetGetSingleData()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertSame(
            2345.2,
            $chart->income[2000]
        );
    }

    public function testDatasetSetSingleData()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart->income = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart->income[2005] = 234.21;
        }
        catch ( Exception $e ) 
        {
            $this->fail( $e->getMessage() );
        }

        $this->assertSame(
            234.21,
            $chart->income[2005]
        );
    }

    public function testAutomaticColorization()
    {
        $this->fail( '@TODO: Add test to check automatic dataset colorization.' );
    }
}
?>

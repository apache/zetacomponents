<?php
/**
 * ezcGraphDataSetTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcGraphDataSetTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphDataSetTest" );
	}

    public function testCreateDataSetFromArray()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['humanoids'] = new ezcGraphArrayDataSet( array( 'monkey' => 54, 'ape' => 37, 'human' => 9 ) );

        $datasets = $this->getAttribute( $chart, 'data' );
        $this->assertTrue(
            $datasets['humanoids'] instanceof ezcGraphDataSet,
            'No ezcGraphDataSet was created.'
        );
    }

    public function testGetDataSet()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['humanoids'] = new ezcGraphArrayDataSet( array( 'monkey' => 54, 'ape' => 37, 'human' => 9 ) );

        $this->assertTrue(
            $chart->data['humanoids'] instanceof ezcGraphDataSet,
            'No ezcGraphDataSet was created.'
        );
    }

    public function testDataSetContent()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['example'] = new ezcGraphArrayDataSet( array( 'monkey' => 54, 2001 => 37 ) );

        $data = $this->getAttribute( $chart->data['example'], 'data' );

        $this->assertSame( 
            54,
            $data['monkey']
        );
        $this->assertSame( 
            37,
            $data['2001']
        );
    }

    public function testDataSetStringContent()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['example'] = new ezcGraphArrayDataSet( array( 'monkey' => 'alive', 2001 => 'year' ) );

        $data = $this->getAttribute( $chart->data['example'], 'data' );

        $this->assertSame( 
            'alive',
            $data['monkey']
        );
        $this->assertSame( 
            'year',
            $data['2001']
        );
    }

    public function testCreateMultipleDataSetsFromArray()
    {
        $chart = new ezcGraphLineChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['spending'] = new ezcGraphArrayDataSet( array( 2000 => 2347.2, 2458.3, 2569.4 ) );

        $datasets = $this->getAttribute( $chart, 'data' );
        $this->assertTrue(
            $datasets['income'] instanceof ezcGraphDataSet,
            'No ezcGraphDataSet was created.'
        );
        $this->assertTrue(
            $datasets['spending'] instanceof ezcGraphDataSet,
            'No second ezcGraphDataSet was created.'
        );
    }

    public function testCreateMultiplePiechartDataSetsFromArray()
    {
        try 
        {
            $chart = new ezcGraphPieChart();
            $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
            $chart->data['spending'] = new ezcGraphArrayDataSet( array( 2000 => 2347.2, 2458.3, 2569.4 ) );
        }
        catch ( ezcGraphTooManyDataSetsExceptions $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphTooManyDataSetsExceptions.' );
    }

    public function testDataSetLabel()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );

        $this->assertEquals(
            'income',
            $chart->data['income']->label->default
        );
    }

    public function testDataSetSetLabel()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->label = 'Income Label';

        $this->assertEquals(
            'Income Label',
            $chart->data['income']->label->default
        );
    }

    public function testDataSetSetColor()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->color = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->data['income']->color->default
        );
    }

    public function testDataSetSetHighlight()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->highlight = true;

        $this->assertEquals(
            true,
            $chart->data['income']->highlight->default
        );
    }

    public function testDataSetGetHighlight()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );

        $this->assertEquals(
            false,
            $chart->data['income']->highlight[2001]
        );

        $this->assertEquals(
            false,
            $chart->data['income']->highlight->default
        );
    }

    public function testDataSetSetHighlightSingle()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->highlight[2001] = true;

        $this->assertEquals(
            false,
            $chart->data['income']->highlight[2000]
        );

        $this->assertEquals(
            true,
            $chart->data['income']->highlight[2001]
        );
    }

    public function testDataSetSetSingleColor()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->color[2001] = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart->data['income']->color[2001]
        );
    }

    public function testDataSetSetSingleSymbol()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->symbol[2001] = ezcGraph::DIAMOND;

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart->data['income']->symbol[2001]
        );
    }

    public function testDataSetPropertyValueFallback()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income']->symbol = ezcGraph::DIAMOND;

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart->data['income']->symbol[2001]
        );
    }

    public function testDataSetSetNonexistingSingle()
    {
        try
        {
            $chart = new ezcGraphPieChart();
            $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
            $chart->data['income']->symbol[2006] = ezcGraph::DIAMOND;
        }
        catch ( ezcGraphNoSuchDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoSuchDataException.' );
    }

    public function testDataSetGetSingleData()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );

        $this->assertSame(
            2345.2,
            $chart->data['income'][2000]
        );
    }

    public function testDataSetSetSingleData()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( array( 2000 => 2345.2, 2456.3, 2567.4 ) );
        $chart->data['income'][2005] = 234.21;

        $this->assertSame(
            234.21,
            $chart->data['income'][2005]
        );

        $this->assertSame(
            2456.3,
            $chart->data['income'][2001]
        );
    }

    public function testIteratorToDataSet()
    {
        $chart = new ezcGraphPieChart();
        $chart->data['income'] = new ezcGraphArrayDataSet( new ArrayIterator( array( 2000 => 2345.2, 2456.3, 2567.4 ) ) );
        $chart->data['income'][2005] = 234.21;

        $this->assertSame(
            234.21,
            $chart->data['income'][2005]
        );

        $this->assertSame(
            2456.3,
            $chart->data['income'][2001]
        );
    }

    public function testDataSetInvalidDataSource()
    {
        $chart = new ezcGraphPieChart();
        try
        {
            $chart->data['income'] = new ezcGraphArrayDataSet( $chart );
        }
        catch ( ezcGraphInvalidArrayDataSourceException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphInvalidArrayDataSourceException.' );
    }
}
?>

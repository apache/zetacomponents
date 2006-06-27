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
        $chart = ezcGraph::create( 'Pie' );
        $chart['humanoids'] = array( 'monkey' => 54, 'ape' => 37, 'human' => 9 );

        $datasets = $this->getNonPublicProperty( $chart, 'data' );
        $this->assertTrue(
            $datasets['humanoids'] instanceof ezcGraphDataset,
            'No ezcGraphDataset was created.'
        );
    }

    public function testGetDataset()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['humanoids'] = array( 'monkey' => 54, 'ape' => 37, 'human' => 9 );

        $this->assertTrue(
            $chart['humanoids'] instanceof ezcGraphDataset,
            'No ezcGraphDataset was created.'
        );
    }

    public function testDatasetContent()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['example'] = array( 'monkey' => 54, 2001 => 37 );

        $data = $this->getNonPublicProperty( $chart['example'], 'data' );

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
        $chart = ezcGraph::create( 'Line' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['spending'] = array( 2000 => 2347.2, 2458.3, 2569.4 );

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
            $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart['spending'] = array( 2000 => 2347.2, 2458.3, 2569.4 );
        }
        catch ( ezcGraphTooManyDatasetsExceptions $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphTooManyDatasetsExceptions.' );
    }

    public function testDatasetLabel()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );

        $this->assertEquals(
            'income',
            $chart['income']->label->default
        );
    }

    public function testDatasetSetLabel()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->label = 'Income Label';

        $this->assertEquals(
            'Income Label',
            $chart['income']->label->default
        );
    }

    public function testDatasetSetColor()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->color = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart['income']->color->default
        );
    }

    public function testDatasetSetHighlight()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->highlight = true;

        $this->assertEquals(
            true,
            $chart['income']->highlight->default
        );
    }

    public function testDatasetGetHighlight()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );

        $this->assertEquals(
            false,
            $chart['income']->highlight[2001]
        );

        $this->assertEquals(
            false,
            $chart['income']->highlight->default
        );
    }

    public function testDatasetSetHighlightSingle()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->highlight[2001] = true;

        $this->assertEquals(
            false,
            $chart['income']->highlight[2000]
        );

        $this->assertEquals(
            true,
            $chart['income']->highlight[2001]
        );
    }

    public function testDatasetSetSingleColor()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->color[2001] = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart['income']->color[2001]
        );
    }

    public function testDatasetSetSingleSymbol()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->symbol[2001] = ezcGraph::DIAMOND;

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart['income']->symbol[2001]
        );
    }

    public function testDatasetPropertyValueFallback()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->symbol = ezcGraph::DIAMOND;

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart['income']->symbol[2001]
        );
    }

    public function testDatasetSetNonexistingSingle()
    {
        try
        {
            $chart = ezcGraph::create( 'Pie' );
            $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart['income']->symbol[2006] = ezcGraph::DIAMOND;
        }
        catch ( ezcGraphNoSuchDataException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphNoSuchDataException.' );
    }

    public function testDatasetGetSingleData()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );

        $this->assertSame(
            2345.2,
            $chart['income'][2000]
        );
    }

    public function testDatasetSetSingleData()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income'][2005] = 234.21;

        $this->assertSame(
            234.21,
            $chart['income'][2005]
        );
    }
}
?>

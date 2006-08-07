<?php
/**
 * ezcGraphDataSetTest 
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
class ezcGraphDataSetTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphDataSetTest" );
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

    public function testCreateDataSetFromArray()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['humanoids'] = array( 'monkey' => 54, 'ape' => 37, 'human' => 9 );

        $datasets = $this->getNonPublicProperty( $chart, 'data' );
        $this->assertTrue(
            $datasets['humanoids'] instanceof ezcGraphDataSet,
            'No ezcGraphDataSet was created.'
        );
    }

    public function testGetDataSet()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['humanoids'] = array( 'monkey' => 54, 'ape' => 37, 'human' => 9 );

        $this->assertTrue(
            $chart['humanoids'] instanceof ezcGraphDataSet,
            'No ezcGraphDataSet was created.'
        );
    }

    public function testDataSetContent()
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

    public function testCreateMultipleDataSetsFromArray()
    {
        $chart = ezcGraph::create( 'Line' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['spending'] = array( 2000 => 2347.2, 2458.3, 2569.4 );

        $datasets = $this->getNonPublicProperty( $chart, 'data' );
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
            $chart = ezcGraph::create( 'Pie' );
            $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
            $chart['spending'] = array( 2000 => 2347.2, 2458.3, 2569.4 );
        }
        catch ( ezcGraphTooManyDataSetsExceptions $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcGraphTooManyDataSetsExceptions.' );
    }

    public function testDataSetLabel()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );

        $this->assertEquals(
            'income',
            $chart['income']->label->default
        );
    }

    public function testDataSetSetLabel()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->label = 'Income Label';

        $this->assertEquals(
            'Income Label',
            $chart['income']->label->default
        );
    }

    public function testDataSetSetColor()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->color = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart['income']->color->default
        );
    }

    public function testDataSetSetHighlight()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->highlight = true;

        $this->assertEquals(
            true,
            $chart['income']->highlight->default
        );
    }

    public function testDataSetGetHighlight()
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

    public function testDataSetSetHighlightSingle()
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

    public function testDataSetSetSingleColor()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->color[2001] = '#FF0000';

        $this->assertEquals(
            ezcGraphColor::fromHex( '#FF0000' ),
            $chart['income']->color[2001]
        );
    }

    public function testDataSetSetSingleSymbol()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->symbol[2001] = ezcGraph::DIAMOND;

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart['income']->symbol[2001]
        );
    }

    public function testDataSetPropertyValueFallback()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );
        $chart['income']->symbol = ezcGraph::DIAMOND;

        $this->assertEquals(
            ezcGraph::DIAMOND,
            $chart['income']->symbol[2001]
        );
    }

    public function testDataSetSetNonexistingSingle()
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

    public function testDataSetGetSingleData()
    {
        $chart = ezcGraph::create( 'Pie' );
        $chart['income'] = array( 2000 => 2345.2, 2456.3, 2567.4 );

        $this->assertSame(
            2345.2,
            $chart['income'][2000]
        );
    }

    public function testDataSetSetSingleData()
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

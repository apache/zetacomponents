<?php
/**
 * ezcGraphDataSetAverageTest 
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
class ezcGraphDataSetAverageTest extends ezcTestCase
{

	public static function suite()
	{
		return new ezcTestSuite( "ezcGraphDataSetAverageTest" );
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

    public function testCreateDatasetFromDataset()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 1, 0 => 0, 1 => 1 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 2;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDataset2()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 2;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2 + 1.00',
            $polynom->__toString()
        );
    }

    public function testCreateDatasetFromDatasetLowOrder()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 1;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            '2.00 * x + 2.67',
            $polynom->__toString()
        );
    }
    public function testCreateDatasetFromDatasetHighOrder()
    {
        $arrayDataSet = new ezcGraphArrayDataSet( array( -1 => 2, 1 => 2, 3 => 10 ) );

        $averageDataSet = new ezcGraphDataSetAveragePolynom( $arrayDataSet );
        $averageDataSet->polynomOrder = 3;

        $polynom = $averageDataSet->getPolynom();

        $this->assertEquals(
            'x^2 + 1.00',
            $polynom->__toString()
        );
    }
}
?>

<?php
/**
 * ezcGraphRadarChartAxisTest 
 * 
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once dirname( __FILE__ ) . '/test_case.php';

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphRadarChartAxisTest extends ezcGraphTestCase
{
    protected $basePath;

    protected $tempDir;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphRadarChartAxisTest" );
	}

    protected function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    public function testCenteredMultipleDirections()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 13 ) );

        $chart->axis->axisLabelRenderer = new ezcGraphAxisCenteredLabelRenderer();

        $chart->render( 500, 500, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testBoxedMultipleDirections()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 13 ) );

        $chart->axis->axisLabelRenderer = new ezcGraphAxisBoxedLabelRenderer();

        $chart->render( 500, 500, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testExactMultipleDirections()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 13 ) );

        $chart->axis->axisLabelRenderer = new ezcGraphAxisExactLabelRenderer();
        $chart->axis->axisLabelRenderer->showLastValue = false;

        $chart->render( 500, 500, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testDateRotationAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( array( 
            strtotime( '2006-10-16' ) => 7.78507871321,
            strtotime( '2006-10-30' ) => 7.52224503765,
            strtotime( '2006-11-20' ) => 7.29226557153,
            strtotime( '2006-11-28' ) => 7.06228610541,
            strtotime( '2006-12-05' ) => 6.66803559206,
            strtotime( '2006-12-11' ) => 6.37234770705,
            strtotime( '2006-12-28' ) => 6.04517453799,
        ) );

        $chart->rotationAxis = new ezcGraphChartElementDateAxis();

        $chart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testNumericRotationAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 9 ) );

        $chart->rotationAxis = new ezcGraphChartElementNumericAxis();

        $chart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLabeledRotationAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( $this->getRandomData( 9 ) );

        $chart->rotationAxis = new ezcGraphChartElementLabeledAxis();

        $chart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }

    public function testLogarithmicalRotationAxis()
    {
        $filename = $this->tempDir . __FUNCTION__ . '.svg';

        $chart = new ezcGraphRadarChart();
        $chart->palette = new ezcGraphPaletteEzBlue();
        $chart->legend = false;
        $chart->data['sample'] = new ezcGraphArrayDataSet( array(
            1 => 12,
            5 => 7,
            10 => 234,
            132 => 34,
            1125 => 12,
            12346 => 6,
            140596 => 1,
        ) );

        $chart->rotationAxis = new ezcGraphChartElementLogarithmicalAxis();

        $chart->render( 400, 200, $filename );

        $this->compare(
            $filename,
            $this->basePath . 'compare/' . __CLASS__ . '_' . __FUNCTION__ . '.svg'
        );
    }
}
?>

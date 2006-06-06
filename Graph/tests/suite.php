<?php
/**
* ezcGraphSuite
*
* @package Graph
* @subpackage Tests
* @version //autogentag//
* @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
* @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
*/

/**
* Require test suite for Graph class.
*/
require_once 'graph_test.php';

/**
* Require test suites.
*/
require_once 'color_test.php';
require_once 'chart_test.php';
require_once 'pie_test.php';
require_once 'line_test.php';
require_once 'dataset_test.php';
require_once 'legend_test.php';
require_once 'text_test.php';
require_once 'numeric_axis_test.php';
require_once 'labeled_axis_test.php';
require_once 'renderer_2d_test.php';
require_once 'driver_gd_test.php';
require_once 'font_test.php';
require_once 'palette_test.php';

/**
* Test suite for ImageAnalysis package.
*
* @package ImageAnalysis
* @subpackage Tests
*/
class ezcGraphSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Graph" );

        $this->addTest( ezcGraphTest::suite() );
        $this->addTest( ezcGraphColorTest::suite() );
        $this->addTest( ezcGraphChartTest::suite() );
        $this->addTest( ezcGraphPieChartTest::suite() );
        $this->addTest( ezcGraphLineChartTest::suite() );
        $this->addTest( ezcGraphDatasetTest::suite() );
        $this->addTest( ezcGraphLegendTest::suite() );
        $this->addTest( ezcGraphNumericAxisTest::suite() );
        $this->addTest( ezcGraphLabeledAxisTest::suite() );
        $this->addTest( ezcGraphRenderer2dTest::suite() );
        $this->addTest( ezcGraphGdDriverTest::suite() );
        $this->addTest( ezcGraphFontTest::suite() );
        $this->addTest( ezcGraphTextTest::suite() );
        $this->addTest( ezcGraphPaletteTest::suite() );
    }

    public static function suite()
    {
        return new ezcGraphSuite( "ezcGraphSuite" );
    }
}
?>

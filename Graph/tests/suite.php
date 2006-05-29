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
* Require test suite for ezcGraphColor class.
*/
require_once 'color_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'chart_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'pie_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'line_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'dataset_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'legend_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'numeric_axis_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'labeled_axis_test.php';

/**
* Require test suite for ezcGraphChart class.
*/
require_once 'renderer_2d_test.php';

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
    }

    public static function suite()
    {
        return new ezcGraphSuite( "ezcGraphSuite" );
    }
}
?>

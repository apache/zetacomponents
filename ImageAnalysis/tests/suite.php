<?php
/**
 * ezcImageAnalysisSuite
 *
 * @package ImageAnalysis
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require test suite for ImageAnalyzer class.
 */
require_once 'analyzer_test.php';

/**
 * Test suite for ImageAnalysis package.
 *
 * @package ImageAnalysis
 * @subpackage Tests
 */
class ezcImageAnalysisSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "ImageAnalysis" );
        $this->addTest( ezcImageAnalysisAnalyzerTest::suite() );
    }

    public static function suite()
    {
        return new ezcImageAnalysisSuite( "ezcImageAnalysisSuite" );
    }
}
?>

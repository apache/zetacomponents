<?php
/**
 * ezcDocumentPdfDriverHaruTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'driver_tests.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfDriverSvgTests extends ezcDocumentPdfDriverTests
{
    /**
     * Extension of generated files
     * 
     * @var string
     */
    protected $extension = 'svg';

    /**
     * Expected font widths for calculateWordWidth tests
     * 
     * @var array
     */
    protected $expectedWidths = array(
        'testEstimateDefaultWordWidthWithoutPageCreation' => 21.6,
        'testEstimateDefaultWordWidth'                    => 21.6,
        'testEstimateWordWidthDifferentSize'              => 30.1,
        'testEstimateWordWidthDifferentSizeAndUnit'       => 10.6,
        'testEstimateBoldWordWidth'                       => 21.6,
        'testEstimateMonospaceWordWidth'                  => 25.8,
        'testFontStyleFallback'                           => 21.6,
        'testUtf8FontWidth'                               => 21.6,
        'testCustomFontWidthEstimation'                   => 51.6,
    );

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * Get driver to test
     * 
     * @return ezcDocumentPdfDriver
     */
    protected function getDriver()
    {
        return new ezcDocumentPdfSvgDriver();
    }
}

?>

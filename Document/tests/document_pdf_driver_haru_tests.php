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

require_once 'document_pdf_driver_tests.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfDriverHaruTests extends ezcDocumentPdfDriverTests
{
    /**
     * Name of the driver class to test
     * 
     * @var string
     */
    protected $driverClass = 'ezcDocumentPdfHaruDriver';

    /**
     * Expected font widths for calculateWordWidth tests
     * 
     * @var array
     */
    protected $expectedWidths = array(
        'testEstimateDefaultWordWidthWithoutPageCreation' => 22.9,
        'testEstimateDefaultWordWidth'                    => 22.9,
        'testEstimateWordWidthDifferentSize'              => 31.9,
        'testEstimateWordWidthDifferentSizeAndUnit'       => 11.3,
        'testEstimateBoldWordWidth'                       => 24.6,
        'testEstimateMonospaceWordWidth'                  => 36,
        'testFontStyleFallback'                           => 38.8,
        'testUtf8FontWidth'                               => 36,
    );

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'haru' ) )
        {
            $this->markTestSkipped( 'This test requires pecl/haru installed.' );
        }

        parent::setUp();
    }
}

?>

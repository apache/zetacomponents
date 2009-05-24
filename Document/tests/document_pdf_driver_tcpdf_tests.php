<?php
/**
 * ezcDocumentPdfDriverTcpdfTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'pdf_test.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfDriverTcpdfTests extends ezcDocumentPdfTestCase
{
    protected $oldErrorReporting;

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

        // Change error reporting - this is evil, but otherwise TCPDF will
        // abort the tests, because it throws lots of E_NOTICE and
        // E_DEPRECATED.
        $this->oldErrorReporting = error_reporting( E_PARSE | E_ERROR | E_WARNING );
    }

    public function tearDown()
    {
        error_reporting( $this->oldErrorReporting );
        parent::tearDown();
    }

    public function testEstimateDefaultWordWidthWithoutPageCreation()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();

        $this->assertEquals(
            9.4,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateDefaultWordWidth()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );

        $this->assertEquals(
            9.4,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateWordWidthDifferentSize()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-size', '14' );

        $this->assertEquals(
            31.1,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateWordWidthDifferentSizeAndUnit()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-size', '14pt' );

        $this->assertEquals(
            11.0,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateBoldWordWidth()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-weight', 'bold' );

        $this->assertEquals(
            9.6,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateMonospaceWordWidth()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-family', 'monospace' );
        $driver->setTextFormatting( 'font-size', '12' );

        $this->assertEquals(
            36,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testFontStyleFallback()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-family', 'ZapfDingbats' );
        $driver->setTextFormatting( 'font-weight', 'bold' );
        $driver->setTextFormatting( 'font-style', 'italic' );

        $this->assertEquals(
            16.3,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testUtf8FontWidth()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );

        $this->assertEquals(
            10.6,
            $driver->calculateWordWidth( 'ℋℇℒℒΩ' ),
            'Wrong word width estimation', .1
        );
    }

    public function testRenderHelloWorld()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-family', 'sans-serif' );
        $driver->setTextFormatting( 'font-size', '10' );

        $driver->drawWord( 0, 0, 'The quick brown fox jumps over the lazy dog' );
        $driver->drawWord( 0, 297 - 10, 'The quick brown fox jumps over the lazy dog' );
        $pdf = $driver->save();

        $this->assertPdfDocumentsSimilar( $pdf, __METHOD__ );
    }

    public function testRenderHelloWorldSmallFont()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-family', 'sans-serif' );
        $driver->setTextFormatting( 'font-size', '4' );

        $driver->drawWord( 0, 0, 'The quick brown fox jumps over the lazy dog' );
        $driver->drawWord( 0, 297 - 4, 'The quick brown fox jumps over the lazy dog' );
        $pdf = $driver->save();

        $this->assertPdfDocumentsSimilar( $pdf, __METHOD__ );
    }

    public function testRenderSwitchingFontStates()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );
        $driver->setTextFormatting( 'font-size', '8' );

        $driver->drawWord( 0, 0, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-weight', 'bold' );
        $driver->setTextFormatting( 'font-style', 'italic' );
        $driver->drawWord( 0, 10, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-style', 'normal' );
        $driver->drawWord( 0, 20, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-weight', 'normal' );
        $driver->drawWord( 0, 30, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-weight', 'bold' );
        $driver->drawWord( 0, 40, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-family', 'serif' );
        $driver->drawWord( 0, 50, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-weight', 'normal' );
        $driver->drawWord( 0, 60, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-family', 'Symbol' );
        $driver->drawWord( 0, 70, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-weight', 'bold' );
        $driver->drawWord( 0, 80, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-style', 'italic' );
        $driver->drawWord( 0, 90, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-family', 'monospace' );
        $driver->drawWord( 0, 100, 'The quick brown fox jumps over the lazy dog' );
        $driver->setTextFormatting( 'font-weight', 'bold' );
        $driver->setTextFormatting( 'font-style', 'italic' );
        $driver->drawWord( 0, 110, 'The quick brown fox jumps over the lazy dog' );

        $this->assertPdfDocumentsSimilar( $pdf, __METHOD__ );
    }

    public function testRenderUtf8Text()
    {
        $driver = new ezcDocumentPdfTcpdfDriver();
        $driver->createPage( 210, 297 );

        $driver->drawWord( 10, 10, 'ℋℇℒℒΩ' );
        $pdf = $driver->save();

        $this->assertPdfDocumentsSimilar( $pdf, __METHOD__ );
    }
}

?>

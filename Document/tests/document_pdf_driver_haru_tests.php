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

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfDriverHaruTests extends ezcTestCase
{
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
    }

    public function testEstimateDefaultWordWidth()
    {
        $driver = new ezcDocumentPdfHaruDriver();
        $driver->createPage( 210, 284 );

        $this->assertEquals(
            27.3,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateWordWidthDifferentSize()
    {
        $driver = new ezcDocumentPdfHaruDriver();
        $driver->createPage( 210, 284 );
        $driver->setTextFormatting( 'font-size', '14' );

        $this->assertEquals(
            31.9,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateBoldWordWidth()
    {
        $driver = new ezcDocumentPdfHaruDriver();
        $driver->createPage( 210, 284 );
        $driver->setTextFormatting( 'font-weight', 'bold' );

        $this->assertEquals(
            27.3,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }

    public function testEstimateMonospaceWordWidth()
    {
        $driver = new ezcDocumentPdfHaruDriver();
        $driver->createPage( 210, 284 );
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
        $driver = new ezcDocumentPdfHaruDriver();
        $driver->createPage( 210, 284 );
        $driver->setTextFormatting( 'font-family', 'ZapfDingbats' );
        $driver->setTextFormatting( 'font-weight', 'bold' );
        $driver->setTextFormatting( 'font-style', 'italic' );

        $this->assertEquals(
            46.3,
            $driver->calculateWordWidth( 'Hello' ),
            'Wrong word width estimation', .1
        );
    }
}

?>

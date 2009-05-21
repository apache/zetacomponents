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
class ezcDocumentPdfImageHandlerTests extends ezcDocumentPdfTestCase
{
    protected $document;
    protected $xpath;
    protected $styles;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testImageHandler()
    {
        $image = ezcDocumentPdfImage::createFromFile( dirname(  __FILE__ ) . '/files/pdf/images/logo-white.png' );

        $this->assertSame(
            'image/png',
            $image->getMimeType()
        );
        $this->assertSame(
            array( 113, 57 ),
            $image->getDimensions()
        );
    }

    public static function provideCanHandleData()
    {
        return array(
            array( 'files/pdf/images/logo-white.eps', false ),
            array( 'files/pdf/images/logo-white.pdf', false ),
            array( 'files/pdf/images/logo-white.png', true ),
            array( 'files/pdf/images/logo-white.svg', false ),
            array( 'files/pdf/images/logo-white.jpeg', true ),
        );
    }

    /**
     * @dataProvider provideCanHandleData
     */
    public function testCanHandleImageType( $image, $return )
    {
        $handler = new ezcDocumentPdfPhpImageHandler();
        $this->assertSame( $return, $handler->canHandle( dirname( __FILE__ ) . '/' . $image ) );
    }

    public static function provideDimensionData()
    {
        return array(
            array( 'files/pdf/images/logo-white.eps', false ),
            array( 'files/pdf/images/logo-white.pdf', false ),
            array( 'files/pdf/images/logo-white.png', array( 113, 57 ) ),
            array( 'files/pdf/images/logo-white.svg', false ),
            array( 'files/pdf/images/logo-white.jpeg', array( 113, 57 ) ),
        );
    }

    /**
     * @dataProvider provideDimensionData
     */
    public function testImageDimensions( $image, $return )
    {
        $handler = new ezcDocumentPdfPhpImageHandler();
        $this->assertSame( $return, $handler->getDimensions( dirname( __FILE__ ) . '/' . $image ) );
    }

    public static function provideMimeTypeData()
    {
        return array(
            array( 'files/pdf/images/logo-white.eps', false ),
            array( 'files/pdf/images/logo-white.pdf', false ),
            array( 'files/pdf/images/logo-white.png', 'image/png' ),
            array( 'files/pdf/images/logo-white.svg', false ),
            array( 'files/pdf/images/logo-white.jpeg', 'image/jpeg' ),
        );
    }

    /**
     * @dataProvider provideMimeTypeData
     */
    public function testImageMimeType( $image, $return )
    {
        $handler = new ezcDocumentPdfPhpImageHandler();
        $this->assertSame( $return, $handler->getMimeType( dirname( __FILE__ ) . '/' . $image ) );
    }
}

?>

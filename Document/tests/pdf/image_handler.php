<?php
/**
 * ezcDocumentPdfDriverTcpdfTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'base.php';

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
        $image = ezcDocumentPdfImage::createFromFile( dirname(  __FILE__ ) . '/../files/pdf/images/logo-white.png' );

        $this->assertSame(
            'image/png',
            $image->getMimeType()
        );
        $this->assertEquals(
            array( new ezcDocumentPcssMeasure( '113px' ), new ezcDocumentPcssMeasure( '57px' ) ),
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
        $this->assertSame( $return, $handler->canHandle( dirname( __FILE__ ) . '/../' . $image ) );
    }

    public static function provideDimensionData()
    {
        return array(
            array( 'files/pdf/images/logo-white.eps', false ),
            array( 'files/pdf/images/logo-white.pdf', false ),
            array( 'files/pdf/images/logo-white.png', array( new ezcDocumentPcssMeasure( '113px' ), new ezcDocumentPcssMeasure( '57px' ) ) ),
            array( 'files/pdf/images/logo-white.svg', false ),
            array( 'files/pdf/images/logo-white.png', array( new ezcDocumentPcssMeasure( '113px' ), new ezcDocumentPcssMeasure( '57px' ) ) ),
        );
    }

    /**
     * @dataProvider provideDimensionData
     */
    public function testImageDimensions( $image, $return )
    {
        $handler = new ezcDocumentPdfPhpImageHandler();
        $this->assertEquals( $return, $handler->getDimensions( dirname( __FILE__ ) . '/../' . $image ) );
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
        $this->assertSame( $return, $handler->getMimeType( dirname( __FILE__ ) . '/../' . $image ) );
    }
}

?>

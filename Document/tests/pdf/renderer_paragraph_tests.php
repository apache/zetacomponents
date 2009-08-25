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

require_once 'renderer_text_box_base_tests.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfParagraphRendererTests extends ezcDocumentPdfTextBoxRendererBaseTests
{
    /**
     * Renderer used for the tests
     * 
     * @var string
     */
    protected $renderer = 'ezcDocumentPdfWrappingTextBoxRenderer';

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRenderParagraphSplitting()
    {
        // Additional formatting

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'This' )
        );
        $mock->expects( $this->at( 24 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 25 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'short' )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/wrapping.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    public function testRenderParagraphWidow()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'orphans' => '0',
                    'widows'  => '0',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'This' )
        );
        $mock->expects( $this->at( 24 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 25 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'the' )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/widow.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    public function testRenderParagraphWidowWrap()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'orphans' => '0',
                    'widows'  => '2',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'This' )
        );
        $mock->expects( $this->at( 21 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 22 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'widow,' )
        );
        $mock->expects( $this->at( 25 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 29.2, 1. ), $this->equalTo( 'the' )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/widow.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    public function testRenderParagraphOrphan()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'orphans' => '0',
                    'widows'  => '0',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'This' )
        );
        $mock->expects( $this->at( 22 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 85.2, 1. ), $this->equalTo( 'Second' )
        );
        $mock->expects( $this->at( 24 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 25 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'which' )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/orphan.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    public function testRenderParagraphOrphanWrapped()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'orphans' => '2',
                    'widows'  => '0',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'This' )
        );
        $mock->expects( $this->at( 22 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 23 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'Second' )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/orphan.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    public function testRenderParagraphOrphansAndWidows()
    {
        // Additional formatting
        $this->styles->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'orphans' => '3',
                    'widows'  => '3',
                )
            )
        ) );

        $mock = $this->getMock( 'ezcTestDocumentPdfMockDriver', array(
            'createPage',
            'drawWord',
        ) );

        // Expectations
        $mock->expects( $this->at( 0 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 1 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'This' )
        );
        $mock->expects( $this->at( 22 ) )->method( 'createPage' )->with(
            $this->equalTo( 100, 1. ), $this->equalTo( 100, 1. )
        );
        $mock->expects( $this->at( 23 ) )->method( 'drawWord' )->with(
            $this->equalTo( 10, 1. ), $this->equalTo( 18, 1. ), $this->equalTo( 'Second' )
        );

        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname( __FILE__ ) . '/../files/pdf/short_orphan.xml' );

        $renderer  = new ezcDocumentPdfMainRenderer( $mock, $this->styles );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );
    }

    // @TODO: Implement additional tests for wrapped bordered text
}

?>

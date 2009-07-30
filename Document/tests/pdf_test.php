<?php
/**
 * ezcDocumentPdfTestCase
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base test suite for PDF tests, implementing an assertion on PDF
 * equality.
 * 
 * @package Document
 * @subpackage Tests
 */
abstract class ezcDocumentPdfTestCase extends ezcTestCase
{
    protected $tempDir;

    protected $basePath;

    /**
     * Extension of generated files
     * 
     * @var string
     */
    protected $extension = 'pdf';

    public function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/files/pdf/';
    }

    public function tearDown()
    {
        if ( !$this->hasFailed() )
        {
            $this->removeTempDir();
        }
    }

    /**
     * Assert that the given PDF document content is simlar to the
     * PDF document referenced by its test case name.
     * 
     * @param string $content 
     * @param string $name 
     * @return void
     */
    protected function assertPdfDocumentsSimilar( $content, $name )
    {
        $baseName = str_replace( '::', '_', $name ) . '.' . $this->extension;

        // Normalize dates in generated PDF
        $content = preg_replace( '(\\(D:\\d+\\))', '(D:20000101010000)', $content );

        // Store file for manual inspection if the test case fails
        file_put_contents( $this->tempDir . $baseName, $content );

        $this->assertFileExists( $compare = $this->basePath . 'driver/' . $baseName );
        $this->assertEquals(
            file_get_contents( $compare ),
            $content,
            'Generated PDF document does not match expected document.'
        );
    }

    /**
     * Test rendering of a full document
     *
     * Test the rendering of a given full document with an
     * additional set of user configured styles.
     *
     * @param string $file 
     * @param string $fileName 
     * @param array $styles 
     * @return void
     */
    protected function renderFullDocument( $file, $fileName, array $styles = array() )
    {
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( $file );

        $style = new ezcDocumentPdfStyleInferencer();
        $style->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'font-family'  => 'serif',
                    'line-height'  => '1',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'title' ),
                array(
                    'font-family'  => 'sans-serif',
                )
            ),
        ) );
        $style->appendStyleDirectives( $styles );

        $renderer  = new ezcDocumentPdfMainRenderer(
            new ezcDocumentPdfSvgDriver(),
            $style
        );
        $pdf = $renderer->render(
            $docbook,
            new ezcDocumentPdfDefaultHyphenator()
        );

        file_put_contents(
            $this->tempDir . $fileName,
            $pdf
        );
    
        $this->assertXmlFileEqualsXmlFile(
            $this->basePath . 'renderer/' . $fileName,
            $this->tempDir . $fileName
        );
    }

}
?>

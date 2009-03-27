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

    public function setUp()
    {
        static $i = 0;
        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        $this->basePath = dirname( __FILE__ ) . '/files/pdf/driver/';
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
        $baseName = str_replace( '::', '_', $name ) . '.pdf';

        // Store file for manual inspection if the test case fails
        file_put_contents( $this->tempDir . $baseName, $content );

        $this->assertFileExists( $compare = $this->basePath . $baseName );
        $this->assertEquals(
            file_get_contents( $compare ),
            $content,
            'Generated PDF document does not match expected document.'
        );
    }
}


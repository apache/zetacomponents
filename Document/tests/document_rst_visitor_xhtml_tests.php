<?php
/**
 * ezcDocumentRstParserTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'rst_dummy_directives.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentRstXhtmlVisitorTests extends ezcTestCase
{
    protected static $testDocuments = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTestDocuments()
    {
        if ( self::$testDocuments === null )
        {
            // Get a list of all test files from the respektive folder
            $testFiles = glob( dirname( __FILE__ ) . '/files/rst/xhtml/s_*.txt' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -3 ) . 'html'
                );
            }
        }

        return self::$testDocuments;
        return array_slice( self::$testDocuments, -1, 1 );
    }

    /**
     * Check docbook for validity
     *
     * Check the provided docbook document, that it is valid docbook XML.
     * 
     * @param DOMDocument $document
     * @return void
     */
    protected function checkXhtml( DOMDocument $document )
    {
        // Reload document to reassign elements to namespaces.
        $xml = $document->saveXml();
        $document = new DOMDocument();
        $document->loadXml( $xml );

        $oldSetting = libxml_use_internal_errors( true );
        $document->schemaValidate( dirname( __FILE__ ) . '/files/schemas/xhtml1-strict.xsd' );

        // Severity types of XML errors
        $errorTypes = array(
            LIBXML_ERR_WARNING => 'Warning',
            LIBXML_ERR_ERROR   => 'Error',
            LIBXML_ERR_FATAL   => 'Fatal error',
        );

        // Get all errors
        $xmlErrors = libxml_get_errors();
        $errors = array();
        foreach ( $xmlErrors as $error )
        {
            $errors[] = sprintf( "%s in %d:%d: %s.",
                $errorTypes[$error->level],
                $error->line,
                $error->column,
                str_replace( '{http://www.w3.org/1999/xhtml}', 'xhtml:', trim( $error->message ) )
            );
        }
        libxml_clear_errors();
        libxml_use_internal_errors( $oldSetting );

        $this->assertEquals(
            array(),
            $errors,
            'Xhtml document is not valid.'
        );
    }

    public function testHtmlOutput()
    {
        $from = dirname( __FILE__ ) . '/files/rst/xhtml/s_003_simple_text.txt';
        $to   = dirname( __FILE__ ) . '/files/rst/xhtml/s_003_simple_text_no_xml.html';

        $document = new ezcDocumentRst();
        $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

        $document->registerDirective( 'my_custom_directive', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'user', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'book', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'function', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'replace', 'ezcDocumentTestDummyXhtmlDirective' );

        $document->loadFile( $from );

        $docbook = $document->getAsXhtml();
        $xml = $docbook->save();

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'html_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), $xml );

        // ext/DOM seem inable to handle the  official docbook XSD file.
        $this->checkXhtml( $docbook->getDomDocument() );

        $this->assertEquals(
            file_get_contents( $to ),
            $xml,
            'Document not visited as expected.'
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testParseRstFile( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $document = new ezcDocumentRst();
        $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

        $document->registerDirective( 'my_custom_directive', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'user', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'book', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'function', 'ezcDocumentTestDummyXhtmlDirective' );
        $document->registerDirective( 'replace', 'ezcDocumentTestDummyXhtmlDirective' );

        $document->loadFile( $from );

        $docbook = $document->getAsXhtml();
        $xml = $docbook->getDomDocument()->saveXml();

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'html_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), $xml );

        // ext/DOM seem inable to handle the  official docbook XSD file.
        $this->checkXhtml( $docbook->getDomDocument() );

        $this->assertEquals(
            file_get_contents( $to ),
            $xml,
            'Document not visited as expected.'
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }
}

?>

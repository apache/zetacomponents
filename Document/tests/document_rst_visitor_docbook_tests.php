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

class ezcDocumentTestDummyDirective extends ezcDocumentRstDirective
{
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        // Just do nothing
    }
}

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentRstDocbookVisitorTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/files/rst/docbook/s_*.txt' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -3 ) . 'xml'
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
    protected function checkDocbook( DOMDocument $document )
    {
        $oldSetting = libxml_use_internal_errors( true );
        $document->schemaValidate( __DIR__ . '/files/schema/docbook.xsd' );

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
                str_replace( '{http://www.w3.org/2001/XMLSchema}', 'docbook:', trim( $error->message ) )
            );
        }
        libxml_clear_errors();
        libxml_use_internal_errors( $oldSetting );

        $this->assertEquals(
            array(),
            $errors,
            'Docbook document is not valid.'
        );
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
        $document->registerDirective( 'my_custom_directive', 'ezcDocumentTestDummyDirective' );
        $document->registerDirective( 'user', 'ezcDocumentTestDummyDirective' );
        $document->registerDirective( 'book', 'ezcDocumentTestDummyDirective' );
        $document->registerDirective( 'function', 'ezcDocumentTestDummyDirective' );
        $document->registerDirective( 'replace', 'ezcDocumentTestDummyDirective' );

        $document->loadFile( $from );

        $docbook = $document->getAsDocbook();
        $xml = $docbook->save();

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'docbook_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), $xml );

        // ext/DOM seem inable to handle the  official docbook XSD file.
        // $this->checkDocbook( $docbook->getDomDocument() );

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

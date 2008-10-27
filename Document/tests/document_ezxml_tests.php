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
class ezcDocumentEzXmlTests extends ezcTestCase
{
    protected static $testDocuments = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testValidateValidDocument()
    {
        $doc = new ezcDocumentEzXml();

        $this->assertSame(
            $doc->validateFile( dirname( __FILE__ ) . '/files/ezxml/s_001_header.ezp' ),
            true
        );
    }

    public function testValidateInvalidDocument()
    {
        $invalid = dirname( __FILE__ ) . '/files/ezxml/e_000_invalid.ezp';
        $doc = new ezcDocumentEzXml();

        $this->assertEquals(
            count( $errors = $doc->validateFile( $invalid ) ),
            count( $doc->validateString( file_get_contents( $invalid ) ) )
        );

        $this->assertEquals(
            (string) $errors[0],
            'Error in 6:0: Did not expect element unknown there.'
        );
    }

    public static function getEzXmlTestDocuments()
    {
        if ( self::$testDocuments === null )
        {
            // Get a list of all test files from the respektive folder
            $testFiles = glob( dirname( __FILE__ ) . '/files/ezxml/s_*.ezp' );

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
        return array_slice( self::$testDocuments, 6, 1 );
    }

    /**
     * @dataProvider getEzXmlTestDocuments
     */
    public function testConvertToDocbook( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $document = new ezcDocumentEzXml();
        $document->loadFile( $from );

        $docbook = $document->getAsDocbook();
        $xml = $docbook->save();

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'ezxml_docbook_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), $xml );

        // We need a proper XSD first, the current one does not accept legal
        // XML.
//        $this->checkDocbook( $docbook->getDomDocument() );

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

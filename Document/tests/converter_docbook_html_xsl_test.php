<?php
/**
 * ezcDocumentConverterEzp3TpEzp4Tests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentConverterDocbookToHtmlXsltTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/files/docbook/xhtml_xslt/s_*.xml' );

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

    public function testExtensionMissingException()
    {
        if ( ezcBaseFeatures::hasExtensionSupport( 'xsl' ) )
        {
            $this->markTestSkipped( 'You need XSLT support disabled for this test.' );
        }

        try
        {
            $converter = new ezcDocumentDocbookToHtmlXsltConverter();
            $this->fail( 'Expected ezcBaseExtensionNotFoundException.' );
        }
        catch ( ezcBaseExtensionNotFoundException $e )
        { /* Expected */ }
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testLoadXmlDocumentFromFile( $from, $to )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'xsl' ) )
        {
            $this->markTestSkipped( 'You need XSLT support for this test.' );
        }

        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $doc = new ezcDocumentDocbook();
        $doc->loadFile( $from );

        $converter = new ezcDocumentDocbookToHtmlXsltConverter();
        $created = $converter->convert( $doc );

        $this->assertTrue(
            $created instanceof ezcDocumentXhtml
        );

        // Replace creator string in generated document, as this may change too
        // often for proper testing.
        $dom = $created->getDomDocument();
        $xpath = new DOMXPath( $dom );
        $generator = $xpath->query( '//meta[@name = "generator"]' )->item( 0 );
        $generator->setAttribute( 'content', 'DocBook XSL Stylesheets' );

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'docbook_html_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), $created->getDomDocument()->saveXml() );

        $dest = new DOMDocument();
        $dest->loadHtml( file_get_contents( $to ) );
        $this->assertEquals( $dest, $created->getDomDocument() );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }
}

?>

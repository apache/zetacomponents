<?php
/**
 * ezcDocumentConverterEzp3TpEzp4Tests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'odt/test_classes/styler.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentConverterDocbookToOdtTests extends ezcTestCase
{
    const WRITE_RESULTS = true;

    protected static $testDocuments = null;

    protected static $css;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTestDocuments()
    {
        if ( self::$testDocuments === null )
        {
            // Get a list of all test files from the respektive folder
            $testFiles = glob( dirname( __FILE__ ) . '/files/docbook/odt/s_*.xml' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -3 ) . 'fodt'
                );
            }
        }

        return self::$testDocuments;
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testConvertDocBookOdt( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $doc = new ezcDocumentDocbook();
        $doc->loadFile( $from );

        $converter = new ezcDocumentDocbookToOdtConverter();
        $converter->options->styler->addStylesheetFile( dirname( __FILE__ ) . '/odt/test_data/test_styles.pcss' );

        $created = $converter->convert( $doc );

        $this->assertTrue(
            $created instanceof ezcDocumentOdt
        );

        $this->adjustMetaDate( $created );

        // Store test file, to have something to compare on failure
        $tempDir  = $this->createTempDir( 'docbook_odt_custom_' ) . '/';
        $tempFile = $tempDir . basename( $to );
        file_put_contents( $tempFile, ( $xml = $created->save() ) );

        if ( self::WRITE_RESULTS )
        {
            copy( $tempFile, $to );
        }

        $this->assertTrue(
            ( $errors = $created->validateString( $xml ) ),
            ( is_array( $errors ) ? implode( PHP_EOL, $errors ) : 'Expected true' )
        );

        $this->assertEquals(
            file_get_contents( $to ),
            $xml
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }

    private function adjustMetaDate( ezcDocumentOdt $odt )
    {
        $fakeDate = '2009-12-04T10:14:00+01:00';

        $creationDate = $odt->getDomDocument()->getElementsByTagnameNS(
            ezcDocumentOdt::NS_ODT_META,
            'creation-date'
        )->item( 0 );
        $creationDate->nodeValue = $fakeDate;

        $date = $odt->getDomDocument()->getElementsByTagnameNS(
            ezcDocumentOdt::NS_DC,
            'date'
        )->item( 0 );
        $date->nodeValue = $fakeDate;
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testStylerCalls()
    {
        $testDocs = self::getTestDocuments();

        if ( count( $testDocs ) < 1 )
        {
            throw new RuntimeException( 'Missing test documents.' );
        }

        $doc = new ezcDocumentDocbook();
        $doc->loadFile( $testDocs[0][0] );

        $stylerMock = new ezcDocumentOdtTestStyler();
        $converter = new ezcDocumentDocbookToOdtConverter(
            new ezcDocumentDocbookToOdtConverterOptions(
                array( 'styler' => $stylerMock )
            )
        );
        $created = $converter->convert( $doc );

        $this->assertTrue(
            $stylerMock->odtDocument instanceof DOMDocument
        );

        $this->assertEquals(
            38,
            count( $stylerMock->seenElements )
        );
    }
}

?>

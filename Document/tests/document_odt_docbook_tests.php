<?php
/**
 * ezcDocumentRstParserTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'helper/rst_dummy_directives.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentOdtDocbookTests extends ezcTestCase
{
    public static $testDocuments;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTestDocuments()
    {
        if ( self::$testDocuments === null )
        {
            // Get a list of all test files from the respektive folder
            $testFiles = glob( dirname( __FILE__ ) . '/files/odt/tests/s_*.fodt' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -4 ) . 'xml'
                );
            }
        }

        return self::$testDocuments;
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testCommonConversions( $from, $to )
    {

        $tempDir = $this->createTempDir( 'odt_tests_' ) . '/';
        $imgDir = $tempDir . 'img';

        mkdir( $imgDir );

        $options = new ezcDocumentOdtOptions();
        $options->imageDir = $imgDir;

        $document = new ezcDocumentOdt();
        $document->setFilters(
            array(
                new ezcDocumentOdtImageFilter( $options ),
                new ezcDocumentOdtElementFilter(),
                new ezcDocumentOdtStyleFilter(),
            )
        );
        $document->loadFile( $from );

        $docbook = $document->getAsDocbook();
        $xml = $docbook->save();

        $xml = $this->verifyAndReplaceImages( basename( $to, '.xml' ), $xml );

        // Store test file, to have something to compare on failure
        file_put_contents( $tempDir . basename( $to ), $xml );

        $this->assertTrue( $docbook->validateString( $xml ) );

        if ( !is_file( $to ) )
        {
            $this->fail( "Missing comparison file '$to'." );
        }

        $this->assertEquals(
            file_get_contents( $to ),
            $xml,
            'Document not visited as expected.'
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }

    /**
     * Verify extracted images from an FODT and replace their links for 
     * comparison.
     * 
     * @param string $testDir Name of the current test sub-dir
     * @param string $xml 
     * @return string XML with image refs replaced
     */
    protected function verifyAndReplaceImages( $testDir, $xml )
    {
        $dom = new DOMDocument();
        $dom->loadXml( $xml );

        $xpath = new DOMXPath( $dom );
        $xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );

        $images = $xpath->query( '//doc:imagedata' );

        $i = 1;
        foreach ( $images as $image )
        {
            $refFile = "Document/tests/files/odt/tests/$testDir/$i.png";
            if ( !file_exists( $refFile ) )
            {
                $this->fail( "Image reference with '$refFile' does not exist." );
            }

            $imageFile = $image->getAttribute( 'fileref' );

            $this->assertFileEquals(
                $refFile,
                $imageFile,
                "Extracted image $i did not match ref file '$refFile'."
            );
            
            $image->setAttribute( 'fileref', $refFile );

            ++$i;
        }

        return $dom->saveXml();
    }
}

?>

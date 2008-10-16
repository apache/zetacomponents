<?php
/**
 * ezcDocumentWikiParserTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'wiki_dummy_directives.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentWikiDocbookVisitorTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/files/wiki/*/s_*.txt' );

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
        return array_slice( self::$testDocuments, 72, 1 );
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testParseWikiFile( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $type           = ucfirst( basename( dirname( $from ) ) );
        $tokenizerClass = 'ezcDocumentWiki' . $type . 'Tokenizer';

        $document = new ezcDocumentWiki();
        $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
        $document->options->tokenizer      = new $tokenizerClass();

        $document->registerPlugin( 'currenttimeplugin', 'ezcDocumentTestDummyPlugin' );
        $document->registerPlugin( 'html', 'ezcDocumentTestDummyPlugin' );
        $document->registerPlugin( 'php', 'ezcDocumentTestDummyPlugin' );

        $document->loadFile( $from );

        $docbook = $document->getAsDocbook();
        $xml = $docbook->save();

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'wiki_visitor_' . $type . '_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), $xml );

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

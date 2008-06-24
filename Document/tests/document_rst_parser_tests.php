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

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentRstParserTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/files/rst/parser/s_*.txt' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -3 ) . 'rst'
                );
            }
        }

        return self::$testDocuments;
        return array_slice( self::$testDocuments, -1, 1 );
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

        $tokenizer  = new ezcDocumentRstTokenizer();
        $parser     = new ezcDocumentRstParser();

        $document = $parser->parse( $tokenizer->tokenizeFile( $from ) );

        $this->assertTrue(
            $document instanceof ezcDocumentRstDocumentNode
        );

        $expected = include $to;

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'rst_parser_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), "<?php\n\nreturn " . var_export( $document, true ) . ";\n\n" );

        $this->assertEquals(
            $expected,
            $document,
            'Parsed document does not match expected document.',
            0, 20
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }

    public static function getErrnousTestDocuments()
    {
//        return array();
        return array(
            array(
                dirname( __FILE__ ) . '/files/rst/parser/e_001_non_aligned_text.txt',
                'Parse error: Fatal error: \'Unexpected indentation change from level 4 to 0.\' in line 4 at position 38.',
            ),
            array(
                dirname( __FILE__ ) . '/files/rst/parser/e_002_titles_mismatch.txt',
                'Parse error: Notice: \'Title underline length (12) is shorter then text length (13).\' in line 3 at position 1.',
            ),
            array(
                dirname( __FILE__ ) . '/files/rst/parser/e_003_titles_depth.txt',
                'Parse error: Fatal error: \'Title depth inconsitency.\' in line 13 at position 1.',
            ),
            array(
                dirname( __FILE__ ) . '/files/rst/parser/e_004_blockquotes_depth.txt',
                'Parse error: Error: \'Indentation level changed between block quotes from 4 to 9.\' in line 9 at position 34.',
            ),
        );
    }

    /**
     * @dataProvider getErrnousTestDocuments
     */
    public function testParseErrnousRstFile( $file, $message )
    {
        $tokenizer  = new ezcDocumentRstTokenizer();
        $parser     = new ezcDocumentRstParser();

        try
        {
            $document = $parser->parse( $tokenizer->tokenizeFile( $file ) );
            $this->fail( 'Expected ezcDocumentRstParserException.' );
        }
        catch ( ezcDocumentParserException $e )
        {
            $this->assertSame(
                $message,
                $e->getMessage(),
                'Different parse error expected.'
            );
        }
    }
}

?>

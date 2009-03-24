<?php
/**
 * ezcDocumentPdfCssParserTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfCssParserTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/files/pdf/pcss/s_*.pcss' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -4 ) . 'ast'
                );
            }
        }

        return self::$testDocuments;
        return array_slice( self::$testDocuments, -1, 1 );
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testParsePdfCssFile( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $parser     = new ezcDocumentPdfCssParser();
        $directives = $parser->parseFile( $from );

        $expected = include $to;

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'rst_parser_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), "<?php\n\nreturn " . var_export( $directives, true ) . ";\n\n" );

        $this->assertEquals(
            $expected,
            $directives,
            'Parsed document does not match expected document.',
            0, 20
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }

    public static function getErroneousTestDocuments()
    {
//        return array();
        return array(
            array(
                dirname( __FILE__ ) . '/files/pdf/pcss/e_001_missing_address.pcss',
                'Parse error: Fatal error: \'Expected one of: T_ADDRESS (CSS element addressing queries), T_DESC_ADDRESS (CSS element addressing queries), T_ADDRESS_ID (CSS element addressing queries), T_ADDRESS_CLASS (CSS element addressing queries), found T_START ("{").\' in line 1 at position 2.',
            ),
            array(
                dirname( __FILE__ ) . '/files/pdf/pcss/e_002_invalid_address.pcss',
                "Parse error: Fatal error: 'Could not parse string: 0123\n' in line 1 at position 1.",
            ),
            array(
                dirname( __FILE__ ) . '/files/pdf/pcss/e_003_missing_start.pcss',
                'Parse error: Fatal error: \'Expected one of: T_ADDRESS (CSS element addressing queries), T_DESC_ADDRESS (CSS element addressing queries), T_ADDRESS_ID (CSS element addressing queries), T_ADDRESS_CLASS (CSS element addressing queries), found T_FORMATTING (formatting specification).\' in line 2 at position 18.',
            ),
            array(
                dirname( __FILE__ ) . '/files/pdf/pcss/e_004_missing_end.pcss',
                'Parse error: Fatal error: \'Expected one of: T_FORMATTING (formatting specification), found T_EOF (end of file).\' in line 3 at position 1.',
            ),
            array(
                dirname( __FILE__ ) . '/files/pdf/pcss/e_005_missing_end_2.pcss',
                'Parse error: Fatal error: \'Expected one of: T_FORMATTING (formatting specification), found T_ADDRESS (CSS element addressing queries).\' in line 4 at position 5.',
            ),
            array(
                dirname( __FILE__ ) . '/files/pdf/pcss/e_006_invalid_rule.pcss',
                "Parse error: Fatal error: 'Could not parse string: ;\n}\n' in line 2 at position 8.",
            ),
        );
    }

    /**
     * @dataProvider getErroneousTestDocuments
     */
    public function testParseErroneousPdfCssFile( $file, $message )
    {
        $parser = new ezcDocumentPdfCssParser();

        try
        {
            $directives = $parser->parseFile( $file );
            $this->fail( 'Expected ezcDocumentPdfCssParserException.' );
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

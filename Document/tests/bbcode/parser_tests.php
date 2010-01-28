<?php
/**
 * ezcDocumentConverterEzp3TpEzp4Tests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentBBCodeParserTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/../files/bbcode/parser/*.txt' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -3 ) . 'ast'
                );
            }
        }

        return self::$testDocuments;
        return array_slice( self::$testDocuments, 10, 1 );
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testParseFile( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $tokenizer = new ezcDocumentBBCodeTokenizer();
        $parser    = new ezcDocumentBBCodeParser();
        $parser->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;
        $ast       = $parser->parse( $tokenizer->tokenizeFile( $from ) );

        $expected = include $to;

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'bbcode_parser_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), "<?php\n\nreturn " . var_export( $ast, true ) . ";\n\n" );

        $this->assertEquals(
            $expected,
            $ast,
            'Extracted ast do not match expected ast.'
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }
}

?>

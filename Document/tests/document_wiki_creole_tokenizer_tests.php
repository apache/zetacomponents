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
class ezcDocumentWikiCreoleTokenizerTests extends ezcTestCase
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
            $testFiles = glob( dirname( __FILE__ ) . '/files/wiki/creole/*.txt' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file,
                    substr( $file, 0, -3 ) . 'tokens'
                );
            }
        }

        return self::$testDocuments;
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testTokenizeWikiCreoleFile( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $tokenizer = new ezcDocumentWikiCreoleTokenizer();
        $tokens = $tokenizer->tokenizeFile( $from );

        $expected = include $to;

        // Store test file, to have something to compare on failure
        $tempDir = $this->createTempDir( 'wiki_creole_' ) . '/';
        file_put_contents( $tempDir . basename( $to ), "<?php\n\nreturn " . var_export( $tokens, true ) . ";\n\n" );

        $this->assertEquals(
            $expected,
            $tokens,
            'Extracted tokens do not match expected tokens.'
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }

    public function testNotExistantFile()
    {
        try
        {
            $tokenizer = new ezcDocumentWikiCreoleTokenizer();
            $tokens = $tokenizer->tokenizeFile(
                dirname( __FILE__ ) . '/files/wiki/creole/not_existant_file.txt'
            );
            $this->fail( 'Expected ezcBaseFileNotFoundException.' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        { /* Expected */ }
    }
}

?>

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

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentConverterDocbookToOdtTests extends ezcTestCase
{
    const WRITE_RESULTS = false;

    protected static $testDocuments = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /*

    public function testOdtConverterOptionsFormatOutput()
    {
        $options = new ezcDocumentOdtConverterOptions();
        $options->formatOutput = false;

        try
        {
            $options->formatOutput = 0;
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testOdtConverterOptionsDublinCoreMetadata()
    {
        $options = new ezcDocumentOdtConverterOptions();
        $options->dublinCoreMetadata = false;

        try
        {
            $options->dublinCoreMetadata = 0;
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testOdtConverterOptionsStyleSheets()
    {
        $options = new ezcDocumentOdtConverterOptions();
        $options->styleSheets = array( 'url' );
        $options->styleSheets = null;

        try
        {
            $options->styleSheets = 0;
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        {}
    }

    public function testOdtConverterOptionsUnknownOption()
    {
        $options = new ezcDocumentOdtConverterOptions();

        try
        {
            $options->notExistingOption = 0;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {}
    }

    */

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
    public function testLoadXmlDocumentFromFile( $from, $to )
    {
        if ( !is_file( $to ) )
        {
            $this->markTestSkipped( "Comparision file '$to' not yet defined." );
        }

        $doc = new ezcDocumentDocbook();
        $doc->loadFile( $from );

        $converter = new ezcDocumentDocbookToOdtConverter();
        $created = $converter->convert( $doc );

        $this->assertTrue(
            $created instanceof ezcDocumentOdt
        );

        // Store test file, to have something to compare on failure
        $tempDir  = $this->createTempDir( 'docbook_odt_custom_' ) . '/';
        $tempFile = $tempDir . basename( $to );
        file_put_contents( $tempFile, $xml = $created->save() );

        if ( self::WRITE_RESULTS )
        {
            copy( $tempFile, $to );
        }

        /*
        $this->assertTrue(
            ( $errors = $created->validateString( $xml ) ) === true,
            ( is_array( $errors ) ? implode( PHP_EOL, $errors ) : 'Expected true' )
        );
        */

        $this->assertEquals(
            file_get_contents( $to ),
            $xml
        );

        // Remove tempdir, when nothing failed.
        $this->removeTempDir();
    }
}

?>

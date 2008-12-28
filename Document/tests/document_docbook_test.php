<?php
/**
 * ezcDocumentDocbookTests
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
class ezcDocumentDocbookTests extends ezcTestCase
{
    protected static $testDocuments = null;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getDocbookDocuments()
    {
        if ( self::$testDocuments === null )
        {
            // Get a list of all test files from the respektive folder
            $testFiles = glob( dirname( __FILE__ ) . '/files/docbook/rst/s_*.xml' );

            // Create array with the test file and the expected result file
            foreach ( $testFiles as $file )
            {
                self::$testDocuments[] = array(
                    $file
                );
            }
        }

        return self::$testDocuments;
        return array_slice( self::$testDocuments, 18, 40 );
    }

    /**
     * @dataProvider getDocbookDocuments
     */
    public function testValidateDocbook( $file )
    {
        $doc = new ezcDocumentDocbook();
        $this->assertTrue(
            $doc->validateFile( $file )
        );
    }

    public function testValidateErrorneousDocbook()
    {
        $doc = new ezcDocumentDocbook();
        $this->assertTrue(
            is_array( $errors = $doc->validateFile( dirname( __FILE__ ) . '/files/docbook/errorneous.xml' ) )
        );

        $this->assertSame(
            'Fatal error in 7:13: Opening and ending tag mismatch: section line 4 and Section.',
            (string) $errors[0]
        );
    }

    public function testValidateInvalidDocbook()
    {
        $doc = new ezcDocumentDocbook();
        $this->assertTrue(
            is_array( $errors = $doc->validateFile( dirname( __FILE__ ) . '/files/docbook/invalid.xml' ) )
        );

        $this->assertSame(
            'Error in 4:0: Element \'{http://docbook.org/ns/docbook}section\', attribute \'id\': The attribute \'id\' is not allowed..',
            (string) $errors[0]
        );
    }
}

?>

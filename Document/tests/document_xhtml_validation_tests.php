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
class ezcDocumentXhtmlValidationTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testSuccessfulDocumentStringValidation()
    {
        $xhtml = new ezcDocumentXhtml();

        $this->assertSame(
            true,
            $xhtml->validateString( file_get_contents( dirname( __FILE__ ) . '/files/xhtml/validation/valid_markup.html' ) ),
            'Expected true as result of document validation'
        );
    }

    public function testSuccessfulDocumentFileValidation()
    {
        $xhtml = new ezcDocumentXhtml();

        $this->assertSame(
            true,
            $xhtml->validateFile( dirname( __FILE__ ) . '/files/xhtml/validation/valid_markup.html' ),
            'Expected true as result of document validation'
        );
    }

    public function testDocumentStringValidationErrors()
    {
        $xhtml = new ezcDocumentXhtml();

        $errors = $xhtml->validateString( file_get_contents( dirname( __FILE__ ) . '/files/xhtml/validation/invalid_markup.html' ) );

        $this->assertTrue( 
            is_array( $errors ),
            'Expected an array of errors to be returned'
        );

        $this->assertTrue( 
            $errors[0] instanceof ezcDocumentValidationError,
            'Expected an array of ezcDocumentValidationError objects to be returned'
        );

        $this->assertSame(
            10,
            count( $errors ),
            'Expected three errors to be found in validated document.'
        );

        $this->assertTrue( 
            $errors[0]->getLibXmlError() instanceof LibXMLError,
            'Expected an array of LibXMLError objects to be returned'
        );

        $this->assertSame(
            'Fatal error in 38:7: Opening and ending tag mismatch: a line 36 and h1.',
            (string) $errors[0]
        );
    }
}

?>

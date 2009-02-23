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

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentRstValidationTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testSuccessfulDocumentStringValidation()
    {
        $xhtml = new ezcDocumentRst();

        $this->assertSame(
            true,
            $xhtml->validateString( file_get_contents( dirname( __FILE__ ) . '/files/rst/validation/valid.txt' ) ),
            'Expected true as result of document validation'
        );
    }

    public function testSuccessfulDocumentFileValidation()
    {
        $xhtml = new ezcDocumentRst();

        $this->assertSame(
            true,
            $xhtml->validateFile( dirname( __FILE__ ) . '/files/rst/validation/valid.txt' ),
            'Expected true as result of document validation'
        );
    }

    public function testDocumentFatalParseError()
    {
        $xhtml = new ezcDocumentRst();

        $errors = $xhtml->validateFile( dirname( __FILE__ ) . '/files/rst/validation/parser_fatal.txt' );

        $this->assertTrue( 
            is_array( $errors ),
            'Expected an array of errors to be returned'
        );

        $this->assertTrue( 
            $errors[0] instanceof ezcDocumentValidationError,
            'Expected an array of ezcDocumentValidationError objects to be returned'
        );

        $this->assertSame(
            1,
            count( $errors ),
            'Expected three errors to be found in validated document.'
        );

        $this->assertTrue( 
            $errors[0]->getOriginalError() instanceof ezcDocumentParserException,
            'Expected an array of ezcDocumentParserException objects to be returned'
        );

        $this->assertSame(
            'Parse error: Fatal error: \'Unexpected indentation change from level 4 to 0.\' in line 4 at position 38.',
            (string) $errors[0]
        );
    }

    public function testDocumentParseNotices()
    {
        $xhtml = new ezcDocumentRst();

        $errors = $xhtml->validateFile( dirname( __FILE__ ) . '/files/rst/validation/parser_notice.txt' );

        $this->assertTrue( 
            is_array( $errors ),
            'Expected an array of errors to be returned'
        );

        $this->assertSame(
            2,
            count( $errors ),
            'Expected three errors to be found in validated document.'
        );
    }

    public function testDocumentVisitorNotices()
    {
        $xhtml = new ezcDocumentRst();

        $errors = $xhtml->validateFile( dirname( __FILE__ ) . '/files/rst/validation/visitor_warning.txt' );

        $this->assertTrue( 
            $errors[0] instanceof ezcDocumentValidationError,
            'Expected an array of ezcDocumentValidationError objects to be returned'
        );

        $this->assertSame(
            1,
            count( $errors ),
            'Expected three errors to be found in validated document.'
        );

        $this->assertTrue( 
            $errors[0]->getOriginalError() instanceof ezcDocumentVisitException,
            'Expected an array of ezcDocumentVisitException objects to be returned'
        );

        $this->assertSame(
            'Visitor error: Warning: \'Too few anonymous reference targets.\' in line 0 at position 0.',
            (string) $errors[0]
        );
    }
}

?>

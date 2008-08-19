<?php
/**
 * ezcDocumentConverterEzp3TpEzp4Tests
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
class ezcDocumentDocumentTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructWithOptions()
    {
        $options = new ezcDocumentDocbookOptions();
        $options->errorReporting = E_PARSE;

        $document = new ezcDocumentDocbook( $options );

        $this->assertSame(
            E_PARSE,
            $document->options->errorReporting
        );
    }

    public function testNoSuchPropertyException()
    {
        $document = new ezcDocumentDocbook();

        try
        {
            $document->notExistingOption;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        { /* Expected */ }
    }

    public function testSetOptionsProperty()
    {
        $document = new ezcDocumentDocbook();
        $options = new ezcDocumentDocbookOptions();
        $options->errorReporting = E_PARSE;
        $document->options = $options;

        $this->assertSame(
            E_PARSE,
            $document->options->errorReporting
        );

        try
        {
            $document->options = false;
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        { /* Expected */ }
    }

    public function testSetNotExistingProperty()
    {
        $document = new ezcDocumentDocbook();

        try
        {
            $document->notExistingOption = false;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        { /* Expected */ }
    }

    public function testPropertyIsset()
    {
        $document = new ezcDocumentDocbook();

        $this->assertTrue( isset( $document->options ) );
        $this->assertFalse( isset( $document->notExistingOption ) );
    }
}

?>

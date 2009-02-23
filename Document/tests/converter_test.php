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
class ezcDocumentConverterTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructWithOptions()
    {
        $options = new ezcDocumentDocbookToHtmlConverterOptions();
        $options->formatOutput = true;

        $converter = new ezcDocumentDocbookToHtmlConverter( $options );

        $this->assertSame(
            true,
            $converter->options->formatOutput
        );
    }

    public function testNoSuchPropertyException()
    {
        $converter = new ezcDocumentDocbookToHtmlConverter();

        try
        {
            $converter->notExistingOption;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        { /* Expected */ }
    }

    public function testSetOptionsProperty()
    {
        $converter = new ezcDocumentDocbookToHtmlConverter();
        $options = new ezcDocumentDocbookToHtmlConverterOptions();
        $options->formatOutput = true;
        $converter->options = $options;

        $this->assertSame(
            true,
            $converter->options->formatOutput
        );

        try
        {
            $converter->options = 42;
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e )
        { /* Expected */ }
    }

    public function testSetNotExistingProperty()
    {
        $converter = new ezcDocumentDocbookToHtmlConverter();

        try
        {
            $converter->notExistingOption = 42;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        { /* Expected */ }
    }

    public function testPropertyIsset()
    {
        $converter = new ezcDocumentDocbookToHtmlConverter();

        $this->assertTrue( isset( $converter->options ) );
        $this->assertFalse( isset( $converter->notExistingOption ) );
    }
}

?>

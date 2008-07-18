<?php
/**
 * ezcDocTestConvertDocbookDocbook
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
class ezcDocumentXmlBaseTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testLoadXmlDocumentFromFile()
    {
        $doc = new ezcDocumentDocbook();
        $doc->loadFile( 
            dirname( __FILE__ ) . '/files/xhtml_sample_basic.xml'
        );

        $this->assertTrue(
            $doc->getDomDocument() instanceof DOMDocument,
            'DOMDocument not created properly'
        );
    }

    public function testLoadXmlDocumentFromString()
    {
        $string = file_get_contents(
            dirname( __FILE__ ) . '/files/xhtml_sample_basic.xml'
        );

        $doc = new ezcDocumentDocbook();
        $doc->loadString( $string );

        $this->assertTrue(
            $doc->getDomDocument() instanceof DOMDocument,
            'DOMDocument not created properly'
        );
    }

    public function testLoadErrnousXmlDocument()
    {
        $doc = new ezcDocumentDocbook();

        try
        {
            $doc->loadFile( 
                dirname( __FILE__ ) . '/files/xhtml_sample_errnous.xml'
            );
        }
        catch ( ezcDocumentErrnousXmlException $e )
        {
            $errors = $e->getXmlErrors();

            $this->assertSame(
                2,
                count( $errors ),
                'Expected 2 XML errors.'
            );
        }

        $this->assertTrue(
            $doc->getDomDocument() instanceof DOMDocument,
            'DOMDocument not created properly'
        );
    }

    public function testLoadErrnousXmlDocumentSilent()
    {
        $doc = new ezcDocumentDocbook();
        $doc->options->failOnError = false;
        $doc->loadFile( 
            dirname( __FILE__ ) . '/files/xhtml_sample_errnous.xml'
        );

        $this->assertTrue(
            $doc->getDomDocument() instanceof DOMDocument,
            'DOMDocument not created properly'
        );
    }

    public function testSerializeXml()
    {
        $doc = new ezcDocumentDocbook();
        $doc->loadFile( 
            dirname( __FILE__ ) . '/files/xhtml_sample_basic.xml'
        );

        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/files/xhtml_sample_basic.xml' ),
            $doc->save()
        );
    }

    public function testSerializeXmlFormat()
    {
        $doc = new ezcDocumentDocbook();
        $doc->options->indentXml = true;
        $doc->loadFile( 
            dirname( __FILE__ ) . '/files/xhtml_sample_basic.xml'
        );

        $this->assertEquals(
            file_get_contents( dirname( __FILE__ ) . '/files/xhtml_sample_basic_indented.xml' ),
            $doc->save()
        );
    }
}

?>

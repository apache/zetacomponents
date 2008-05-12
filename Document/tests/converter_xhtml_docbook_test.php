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
class ezcDocumentConverterXhtmlToDocbookTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTestDocuments()
    {
        return array(
            array(
                dirname( __FILE__ ) . '/files/xhtml_sample_basic.xml',
                dirname( __FILE__ ) . '/files/docbook_sample_basic.xml',
            ),
            array(
                dirname( __FILE__ ) . '/files/xhtml_sample_lists.xml',
                dirname( __FILE__ ) . '/files/docbook_sample_lists.xml',
            ),
            array(
                dirname( __FILE__ ) . '/files/xhtml_sample_tables.xml',
                dirname( __FILE__ ) . '/files/docbook_sample_tables.xml',
            ),
        );
    }

    /**
     * @dataProvider getTestDocuments
     */
    public function testLoadXmlDocumentFromFile( $from, $to )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'xsl' ) )
        {
            $this->markTestSkipped( 'You need XSLT support for this test.' );
        }

        $doc = new ezcDocumentXhtml();
        $doc->loadFile( $from );

        $converter = new ezcDocumentXhtmlToDocbookConverter();
        $created = $converter->convert( $doc );

        $this->assertTrue(
            $created instanceof ezcDocumentDocbook
        );

        $dest = new DOMDocument();
        $dest->load( $to );

        $this->assertEquals(
            $dest,
            $created->getDomDocument()
        );
    }
}

?>

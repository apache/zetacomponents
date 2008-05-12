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
class ezcDocumentConverterEzp3ToEzp4Tests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getTestDocuments()
    {
        return array(
            array(
                dirname( __FILE__ ) . '/files/ezp3_sample.xml',
                dirname( __FILE__ ) . '/files/ezp4_sample.xml',
            ),
        );
    }

    public function testExtensionMissingException()
    {
        if ( ezcBaseFeatures::hasExtensionSupport( 'xsl' ) )
        {
            $this->markTestSkipped( 'You need XSLT support disabled for this test.' );
        }

        try
        {
            $converter = new ezcDocumentEzp3ToEzp4Converter();
            $this->fail( 'Expected ezcBaseExtensionNotFoundException.' );
        }
        catch ( ezcBaseExtensionNotFoundException $e )
        { /* Expected */ }
    }

    /**
     * @TODO: We should test this in more fine steps, then just testing one
     * single big document.
     *
     * @dataProvider getTestDocuments
     */
    public function testLoadXmlDocumentFromFile( $from, $to )
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'xsl' ) )
        {
            $this->markTestSkipped( 'You need XSLT support for this test.' );
        }

        $doc = new ezcDocumentEzp3Xml();
        $doc->loadFile( $from );

        $converter = new ezcDocumentEzp3ToEzp4Converter();
        $converter->options->customInlineTags = array( 'sub' );
        $created = $converter->convert( $doc );

        $this->assertTrue(
            $created instanceof ezcDocumentEzp4Xml
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

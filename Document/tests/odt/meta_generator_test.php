<?php
/**
 * ezcDocumentOdtMetaGeneratorTest.
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
class ezcDocumentOdtMetaGeneratorTest extends ezcTestCase
{
    protected $domElement;

    protected $generator;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setup()
    {
        $dom = new DOMDocument();
        $this->domElement = $dom->appendChild(
            $dom->createElementNS(
                ezcDocumentOdt::NS_ODT_OFFICE,
                'office:meta'
            )
        );

        $this->generator = new ezcDocumentOdtMetaGenerator();
    }

    public function testGenerateGenerator()
    {
        $this->generator->generateMetaData( $this->domElement );

        $generatorTags = $this->domElement->getElementsByTagnameNS(
            ezcDocumentOdt::NS_ODT_META,
            'generator'
        );

        $this->assertEquals(
            1,
            $generatorTags->length
        );

        $this->assertEquals(
            'eZComponents/Document-dev',
            $generatorTags->item( 0 )->nodeValue
        );
    }

    public function testGenerateMetaDate()
    {
        $this->generator->generateMetaData( $this->domElement );

        $dateTags = $this->domElement->getElementsByTagnameNS(
            ezcDocumentOdt::NS_ODT_META,
            'creation-date'
        );

        $this->assertEquals(
            1,
            $dateTags->length
        );

        $actDate = new DateTime( $dateTags->item( 0 )->nodeValue );
        $curDate = new DateTime();

        $this->assertEquals(
            $curDate->format( 'Ymd' ),
            $actDate->format( 'Ymd' )
        );
    }

    public function testGenerateDcDate()
    {
        $this->generator->generateMetaData( $this->domElement );

        $dateTags = $this->domElement->getElementsByTagnameNS(
            ezcDocumentOdt::NS_DC,
            'date'
        );

        $this->assertEquals(
            1,
            $dateTags->length
        );

        $actDate = new DateTime( $dateTags->item( 0 )->nodeValue );
        $curDate = new DateTime();

        $this->assertEquals(
            $curDate->format( 'Ymd' ),
            $actDate->format( 'Ymd' )
        );
    }
}

?>

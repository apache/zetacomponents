<?php
/**
 * ezcDocumentPdfHyphenatorTests
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentPdfTokenizerTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testDefaultTokenizerNoSplit()
    {
        $hyphenator = new ezcDocumentPdfDefaultTokenizer();
        $this->assertSame(
            array( 'foo' ),
            $hyphenator->tokenize( 'foo' )
        );
    }

    public function testDefaultTokenizerSingleMiddleSplit()
    {
        $hyphenator = new ezcDocumentPdfDefaultTokenizer();
        $this->assertSame(
            array( 'foo', ezcDocumentPdfTokenizer::SPACE, 'bar' ),
            $hyphenator->tokenize( 'foo bar' )
        );
    }

    public function testDefaultTokenizerSplitAll()
    {
        $hyphenator = new ezcDocumentPdfDefaultTokenizer();
        $this->assertSame(
            array( ezcDocumentPdfTokenizer::SPACE, 'Hello', ezcDocumentPdfTokenizer::SPACE, 'world!', ezcDocumentPdfTokenizer::SPACE ),
            $hyphenator->tokenize( ' Hello world! ' )
        );
    }

    public function testDefaultTokenizerSplitTab()
    {
        $hyphenator = new ezcDocumentPdfDefaultTokenizer();
        $this->assertSame(
            array( 'foo', ezcDocumentPdfTokenizer::SPACE, 'bar' ),
            $hyphenator->tokenize( "foo\tbar" )
        );
    }

    public function testDefaultTokenizerSplitNewLine()
    {
        $hyphenator = new ezcDocumentPdfDefaultTokenizer();
        $this->assertSame(
            array( 'foo', ezcDocumentPdfTokenizer::SPACE, 'bar' ),
            $hyphenator->tokenize( "foo\tbar" )
        );
    }

    public function testDefaultTokenizerSplitMultipleDifferentSpaces()
    {
        $hyphenator = new ezcDocumentPdfDefaultTokenizer();
        $this->assertSame(
            array( 'foo', ezcDocumentPdfTokenizer::SPACE, 'bar' ),
            $hyphenator->tokenize( "foo \t \r \n  bar" )
        );
    }
}
?>

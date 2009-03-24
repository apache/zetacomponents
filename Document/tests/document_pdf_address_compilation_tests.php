<?php
/**
 * ezcDocumentPdfStyleInferenceTests
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
class ezcDocumentPdfAddressCompilationTests extends ezcTestCase
{
    protected $document;
    protected $xpath;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public static function getStyleDirectiveAddresses()
    {
        return array(
            array(
                array( 'foo', '> bar' ),
                '(.*/foo[^/]*/bar[^/]*)S',
            ),
            array(
                array( 'foo', '.bar' ),
                '(.*/foo\.bar[^/]*)S',
            ),
            array(
                array( 'foo', '#bar' ),
                '(.*/foo[^/]*#bar[^/]*)S',
            ),
            array(
                array( 'foo', '#bar', '.blubb', '> baz', '#blah', 'foobar' ),
                '(.*/foo\.blubb[^/]*#bar[^/]*/baz[^/]*#blah[^/]*.*/foobar[^/]*)S',
            ),
        );
    }

    /**
     * @dataProvider getStyleDirectiveAddresses
     */
    public function testCompileAddressToRegExp( $address, $regexp )
    {
        $directive = new ezcDocumentPdfCssDirective( $address, array() );

        $this->assertSame(
            $regexp,
            $directive->getRegularExpression()
        );
    }
}

?>

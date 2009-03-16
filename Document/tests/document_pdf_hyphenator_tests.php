<?php
/**
 * ezcDocumentPdfHyphenatorTests
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
class ezcDocumentPdfHyphenatorTests extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testDefaultHyphenator()
    {
        $hyphenator = new ezcDocumentPdfDefaultHyphenator();
        $this->assertSame(
            array( array( 'foo' ) ),
            $hyphenator->splitWord( 'foo' )
        );
    }
}
?>

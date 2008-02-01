<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

require_once 'Debug/tests/test_classes.php';

/**
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugHtmlFormatterTest extends ezcTestCase
{
    public function testHtml()
    {
        $html = new ezcDebugHtmlFormatter();

        $struct = new HtmlReporterDataStructures();

        $out = $html->generateOutput($struct->getLogStructure(), $struct->getTimeStructure());
        $expected = file_get_contents( dirname( __FILE__ ) . '/output/output.html' );
        self::assertEquals( $expected, $out );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

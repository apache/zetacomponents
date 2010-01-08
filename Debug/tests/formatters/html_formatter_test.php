<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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

    public function testHtmlWithPhpStacktrace()
    {
        $html = new ezcDebugHtmlFormatter();

        $struct = new HtmlReporterDataStructures();

        $out = $html->generateOutput(
            $struct->getLogStructureWithPhpStacktrace(),
            $struct->getTimeStructure()
        );
        // file_put_contents( dirname( __FILE__ ) . '/output/output_with_php_stacktrace.html', $out );
        $expected = file_get_contents(
            dirname( __FILE__ ) . '/output/output_with_php_stacktrace.html'
        );
        $this->assertEquals( $expected, $out );
    }

    public function testHtmlWithXdebugStacktrace()
    {
        $html = new ezcDebugHtmlFormatter();

        $struct = new HtmlReporterDataStructures();

        $out = $html->generateOutput(
            $struct->getLogStructureWithXdebugStacktrace(),
            $struct->getTimeStructure()
        );
        file_put_contents( dirname( __FILE__ ) . '/output/output_with_xdebug_stacktrace.html', $out );
        $expected = file_get_contents(
            dirname( __FILE__ ) . '/output/output_with_xdebug_stacktrace.html'
        );
        $this->assertEquals( $expected, $out );
    }

    public function testSetVerbosityColor()
    {
        $html = new ezcDebugHtmlFormatter();

        $this->assertAttributeEquals(
            array(),
            'verbosityColors',
            $html
        );

        $html->setVerbosityColor( 0, 'red' );
        
        $this->assertAttributeEquals(
            array(
                0 => 'red',
            ),
            'verbosityColors',
            $html
        );

        $html->setVerbosityColor( 23, 'blue' );
        
        $this->assertAttributeEquals(
            array(
                0  => 'red',
                23 => 'blue',
            ),
            'verbosityColors',
            $html
        );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

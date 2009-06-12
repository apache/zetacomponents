<?php
/**
 * Tests for the ezcConsoleStringTools class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Test suite for ezcConsoleStringTools class.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleStringToolsTest extends ezcTestCase
{
    private static $provideTestWordWrap;

    /**
     * testWordWrap 
     * 
     * @param mixed $input 
     * @param mixed $expected 
     * @return void
     *
     * @dataProvider provideTestWordWrap
     */
    public function testWordWrap( $input, $expected )
    {
        $tools = new ezcConsoleToolsStringTools();
        $actual = call_user_func_array(
            array(
                $tools,
                'wordWrap'
            ),
            $input
        );
        $this->assertEquals(
            $expected,
            $actual
        );
    }

    public function provideTestWordWrap()
    {
        if ( !isset( self::$provideTestWordWrap ) )
        {
            self::$provideTestWordWrap = require dirname( __FILE__ ) . '/data/string_tools_wordwrap_data.php';
        }
        return self::$provideTestWordWrap;
    }

    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

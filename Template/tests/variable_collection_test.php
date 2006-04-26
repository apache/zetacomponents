<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateVariableCollectionTest extends ezcTestCase
{
    public static function suite()
    {
         return new ezcTestSuite( "ezcTemplateVariableCollectionTest" );
    }

    /**
     * Creates a set of variables and a collection for testing.
     */
    public function setUp()
    {
    }

    /**
     * Unsets all variables
     */
    public function tearDown()
    {
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $col = new ezcTemplateVariableCollection();

        $col->number = 6;
        self::assertEquals( $col->number, 6 );
    }

    public function testForeachIteration()
    {
        $send = new ezcTemplateVariableCollection();

        $send->red = "FF0000";
        $send->green = "00FF00";
        $send->blue = "0000FF";

        $a = array();

        foreach( $send as $name => $value )
        {
            $a[$name] = $value;
        }

        self::assertEquals( "FF0000", $a["red"] );
        self::assertEquals( "00FF00", $a["green"] );
        self::assertEquals( "0000FF", $a["blue"] );
    }

}

?>

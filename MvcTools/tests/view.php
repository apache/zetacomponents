<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/testclasses.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsViewTest extends ezcTestCase
{
    public function testNoZones()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;

        $view    = new testNoZonesView( $request, $result );
        try
        {
            $response = $view->createResponse();
        }
        catch ( ezcMvcNoZonesException $e )
        {
            self::assertEquals( "No zones are defined in the view.", $e->getMessage() );
        }
    }

    public function testFaultyView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;

        $view    = new testFaultyView( $request, $result );
        try
        {
            $response = $view->createResponse();
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'O:8:\"stdClass\":0:{}' that you were trying to assign to setting 'zone' is invalid. Allowed values are: instance of ezcMvcViewHandler.", $e->getMessage() );
        }
    }

    public function testTwoViews()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'var1' => 42 );

        $view    = new testTwoViews( $request, $result );
        $response = $view->createResponse();

        $obj1 = new StdClass;
        $obj1->vars = array( 'var1' => 42 );
        $obj2 = clone $obj1;
        $obj2->vars['name1'] = $obj1;
        $obj1->name = 'name1';
        $obj2->name = 'name2';

        self::assertEquals( $obj2, $response->body );
    }

    public function testOneView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'var1' => 42 );

        $view    = new testOneView( $request, $result );
        $response = $view->createResponse();

        $expected = new StdClass;
        $expected->name = "name";
        $expected->vars = array( 'var1' => 42 );
        self::assertEquals( $expected, $response->body );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsViewTest" );
    }
}
?>

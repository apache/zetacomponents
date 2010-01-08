<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcMvcToolsJsonViewTest extends ezcTestCase
{
    function setUp()
    {
        $this->baseDir = dirname( __FILE__ ) . '/../testfiles/views/json/';
    }

    function testSimpleView()
    {
        $view = new ezcMvcJsonViewHandler( 'test1' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( true );

        self::assertEquals( file_get_contents( $this->baseDir . 'simple.json' ), $view->getResult() );
    }

    function testNonLastSimpleView()
    {
        $view = new ezcMvcJsonViewHandler( 'test1' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( false );

        self::assertEquals( array( 'name' => 'Churchill', 'quote' => '“Genius is independent of situation.”' ), $view->getResult() );
    }

    public function testOneView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'name' => 'Churchill', 'quote' => '“If you are going through hell, keep going.”' );

        $view    = new testOneJsonView( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'oneview.json' ), $response->body );
    }

    public function testTwoViews()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array(
            'name' => 'Churchill',
            'quote' => '“If you are going through hell, keep going.”',
            'navMaxPages' => 5,
            'navCurrentPage' => 2
        );

        $view    = new testTwoJsonViews( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'twoviews.json' ), $response->body );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

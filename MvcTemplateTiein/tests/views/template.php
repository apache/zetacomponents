<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTemplateTiein
 * @subpackage Tests
 */
require_once 'MvcTemplateTiein/tests/testfiles/testclasses.php';

/**
 * Test the handler classes.
 *
 * @package MvcTemplateTiein
 * @subpackage Tests
 */
class ezcMvcTemplateViewTest extends ezcTestCase
{
    function setUp()
    {
        $this->baseDir = dirname( __FILE__ ) . '/../testfiles/views/template/';
    }

    function testSimpleView()
    {
        $view = new ezcMvcTemplateViewHandler( 'test1', $this->baseDir . 'simple.ezt' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( true );

        self::assertEquals( file_get_contents( $this->baseDir . 'simple.ezt.txt' ), $view->getResult() );
    }

    public function testOneView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'name' => 'Churchill', 'quote' => '“If you are going through hell, keep going.”' );

        $view    = new testOneTemplateView( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'oneview.ezt.txt' ), $response->body );
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

        $view    = new testTwoTemplateViews( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'twoviews.ezt.txt' ), $response->body );
    }

    public function testNonExistingFile()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array(
            'name' => 'Churchill',
            'quote' => '“If you are going through hell, keep going.”',
            'navMaxPages' => 5,
            'navCurrentPage' => 2
        );

        $view    = new testNonExistingTemplateView( $request, $result );

        $dir = dirname( __FILE__ );
        $dir = realpath( "$dir/.." );

        try
        {
            $response = $view->createResponse();
        }
        catch ( ezcTemplateFileNotFoundException $e )
        {
            self::assertEquals( "The requested template file '{$dir}/testfiles/views/template/not_here.ezt' does not exist.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcTemplateViewTest" );
    }
}
?>

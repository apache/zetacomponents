<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
class ezcMvcToolsPhpViewTest extends ezcTestCase
{
    function setUp()
    {
        $this->baseDir = dirname( __FILE__ ) . '/../testfiles/views/php/';
    }

    function testSimpleView()
    {
        $view = new ezcMvcPhpViewHandler( 'test1', $this->baseDir . 'simple.php' );
        $view->send( 'name', 'Churchill' );
        $view->send( 'quote', '“Genius is independent of situation.”' );
        $view->process( false );

        self::assertEquals( file_get_contents( $this->baseDir . 'simple.php.txt' ), $view->getResult() );
    }

    public function testOneView()
    {
        $request = new ezcMvcRequest;
        $result  = new ezcMvcResult;
        $result->variables = array( 'name' => 'Churchill', 'quote' => '“If you are going through hell, keep going.”' );

        $view    = new testOnePhpView( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'oneview.php.txt' ), $response->body );
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

        $view    = new testTwoPhpViews( $request, $result );
        $response = $view->createResponse();

        self::assertEquals( file_get_contents( $this->baseDir . 'twoviews.php.txt' ), $response->body );
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

        $view    = new testNonExistingPhpView( $request, $result );
        $dir = dirname( __FILE__ );
        $dir = realpath( "$dir/.." );

        try
        {
            $response = $view->createResponse();
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            self::assertEquals( "The php template file '{$dir}/testfiles/views/php/not_here.php' could not be found.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsPhpViewTest" );
    }
}
?>

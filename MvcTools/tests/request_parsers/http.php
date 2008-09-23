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
require_once 'UnitTest/src/regression_test.php';
require_once 'UnitTest/src/regression_suite.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsHttpRequestParserTest extends ezcTestRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . '/../testfiles/http_request_parser';

        $this->readDirRecursively( $basePath, $this->files, 'data' );

        parent::__construct();
    }

    public function setUp()
    {
        $this->serverArray = $_SERVER;
        $this->filesArray  = $_FILES;
        $this->requestArray  = $_REQUEST;
    }

    public function tearDown()
    {
        $_SERVER = $this->serverArray;
        $_FILES  = $this->filesArray;
        $_REQUEST = $this->requestArray;
    }

    public function testRunRegression( $name )
    {
        include $name;
        $_SERVER = $server;
        $_FILES  = $files;
        $_REQUEST = $request;
        $requestParser = new ezcMvcHttpRequestParser();
        $req = $requestParser->createRequest();

        $expectedFileName = $name . '.exp';
        if ( !file_exists( $expectedFileName ) )
        {
            self::fail( 'Missing expected data file.' );
            file_put_contents( $expectedFileName, var_export( $req, true ) );
        }
        else
        {
            $expected = file_get_contents( $expectedFileName );
            self::assertEquals( $expected, var_export( $req, true ) );
        }
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }
}
?>

<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcMailTiein
 * @subpackage Tests
 */
#require_once 'MvcMailTiein/tests/testfiles/testclasses.php';
require_once 'UnitTest/src/regression_test.php';
require_once 'UnitTest/src/regression_suite.php';

/**
 * Test the handler classes.
 *
 * @package MvcMailTiein
 * @subpackage Tests
 */
class ezcMvcMailTieinMailRequestParserTest extends ezcTestRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . '/../testfiles/mail_request_parser';

        $this->readDirRecursively( $basePath, $this->files, 'data' );

        parent::__construct();
    }

    public function testRunRegression( $name )
    {
        $expectedFileName = $name . '.exp';
        if ( !file_exists( $expectedFileName ) )
        {
            self::fail( 'Missing expected data file.' );
        }
        $expected = file_get_contents( $expectedFileName );
        $expected = str_replace( 'PID', getmypid(), $expected );

        $data = file_get_contents( $name );
        $requestParser = new ezcMvcMailRequestParser();

        if ( preg_match( '@\.fail\.@', $name ) )
        {
            try
            {
                $req = $requestParser->createRequest( $data );
            }
            catch ( ezcMvcMailTieinException $e )
            {
                $req = $e->getMessage();
            }
        }
        else
        {
            $req = $requestParser->createRequest( $data );
        }
        self::assertEquals( $expected, var_export( $req, true ) );
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }
}
?>

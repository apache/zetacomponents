<?php
/**
 * File containing the ezcWebdavPropPatchRequestTest class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'request_test.php';

/**
 * Test case for the ezcWebdavPropPatchRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 */
class ezcWebdavPropPatchRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavPropPatchRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
            'updates' => new ezcWebdavFlaggedPropertyStorage(),
        );
        $this->workingValues = array(
            'updates' => array(
                new ezcWebdavFlaggedPropertyStorage(),
            ),
        );
        $this->failingValues = array(
            'updates' => array(
                23,
                23.34,
                'foo bar',
                array( 23, 42 ),
                new stdClass(),
            ),
        );
    }

    public function testPathsToAuthorize()
    {
        $req = $this->getObject();

        if ( !( $req instanceof ezcWebdavRequest ) )
        {
            $this->markTestSkipped( 'Not a request object.' );
        }

        $this->assertType(
            'array',
            ( $paths = $req->getPathsToAuthorize() )
        );

        $this->assertEquals(
            1,
            count( $paths )
        );

        $this->assertEquals(
            ezcWebdavAuth::ACCESS_WRITE,
            $paths[$req->requestUri]
        );
    }
}

?>

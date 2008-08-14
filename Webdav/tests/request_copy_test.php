<?php
/**
 * File containing the ezcWebdavCopyRequestTest class.
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
 * Test case for the ezcWebdavCopyRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavCopyRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavCopyRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
            'propertyBehaviour' => null,
        );
        $this->workingValues = array(
            'propertyBehaviour' => new ezcWebdavRequestPropertyBehaviourContent(),
        );
        $this->failingValues = array(
            'propertyBehaviour' => array(
                23,
                23.34,
                true,
                false,
                array( 23, 42 ),
                new stdClass(),
            ),
        );
    }

    public function testValidateHeadersSuccess()
    {
        $req = new ezcWebdavCopyRequest( '/foo', '/bar' );

        $req->setHeader( 'Destination', '/foo/bar' );
        $req->validateHeaders();

        $req->setHeader( 'Overwrite', 'F' );
        $req->validateHeaders();
        
        $req->setHeader( 'Overwrite', 'T' );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavCopyRequest::DEPTH_ONE );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavCopyRequest::DEPTH_INFINITY );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavCopyRequest::DEPTH_ZERO );
        $req->validateHeaders();
    }

    public function testValidateHeadersFailure()
    {
        $req = new ezcWebdavCopyRequest( '/foo', '/bar' );

        $req->setHeader( 'Overwrite', null );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on missing Overwrite header.' );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}
        
        $req->setHeader( 'Overwrite', 'A' );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on invalid Overwrite header.' );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
        // Fix this problem to test others
        $req->setHeader( 'Overwrite', 'T' );
        
        $req->setHeader( 'Depth', null );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on missing Depth header.' );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}

        $req->setHeader( 'Depth', 'A' );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on invalid Depth header.' );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
    }

    public function testPathsToAuthorize()
    {
        $req = $this->getObject();

        if ( !( $req instanceof ezcWebdavRequest ) )
        {
            $this->markTestSkipped( 'Not a request object.' );
            return;
        }

        $req->validateHeaders();

        $this->assertType(
            'array',
            ( $paths = $req->getPathsToAuthorize() )
        );

        $this->assertEquals(
            2,
            count( $paths )
        );

        $this->assertEquals(
            ezcWebdavAuth::ACCESS_READ,
            $paths[$req->requestUri]
        );

        $this->assertEquals(
            ezcWebdavAuth::ACCESS_WRITE,
            $paths[$req->getHeader( 'Destination' )]
        );
    }
}

?>

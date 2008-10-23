<?php
/**
 * File containing the ezcWebdavLockRequestTest class.
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
 * Test case for the ezcWebdavLockRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 */
class ezcWebdavLockRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavLockRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
            'lockInfo'     => null,
        );
        $this->workingValues = array(
            'lockInfo' => array(
                new ezcWebdavRequestLockInfoContent(
                    ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                    ezcWebdavLockRequest::TYPE_WRITE
                ),
                new ezcWebdavRequestLockInfoContent(
                    ezcWebdavLockRequest::SCOPE_SHARED,
                    ezcWebdavLockRequest::TYPE_WRITE,
                    new ezcWebdavPotentialUriContent( 'Foo Bar' )
                ),
                new ezcWebdavRequestLockInfoContent(
                    ezcWebdavLockRequest::SCOPE_SHARED,
                    ezcWebdavLockRequest::TYPE_WRITE,
                    new ezcWebdavPotentialUriContent( 'http://example.com/foo/bar', true )
                ),
                null,
            ),
        );
        $this->failingValues = array(
            'lockInfo' => array(
                23,
                23.34,
                'foo bar',
                array( 23, 42 ),
                new stdClass(),
                true,
                false,
            ),
        );
    }

    public function testValidateHeadersSuccess()
    {
        $req = new ezcWebdavLockRequest( '/foo', '/bar' );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_INFINITY );
        $req->validateHeaders();
    }

    public function testValidateHeadersFailure()
    {
        $req = new ezcWebdavLockRequest( '/foo', '/bar' );
        
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

        $req->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ONE );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on invalid Depth header.' );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
    }
}

?>

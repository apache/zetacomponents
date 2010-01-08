<?php
/**
 * File containing the ezcWebdavMoveRequestTest class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'request_test.php';

/**
 * Test case for the ezcWebdavMoveRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 */
class ezcWebdavMoveRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavMoveRequest';
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
        $req = new ezcWebdavMoveRequest( '/foo', '/bar' );

        $req->setHeader( 'Destination', '/foo/bar' );
        $req->validateHeaders();

        $req->setHeader( 'Overwrite', 'F' );
        $req->validateHeaders();
        
        $req->setHeader( 'Overwrite', 'T' );
        $req->validateHeaders();
    }

    public function testValidateHeadersFailure()
    {
        $req = new ezcWebdavMoveRequest( '/foo', '/bar' );

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
    }
}

?>

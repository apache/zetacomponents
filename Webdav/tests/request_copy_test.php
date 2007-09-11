<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavCopyRequestTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavCopyRequest';
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
        $req = new ezcWebdavCopyRequest();

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
        $req = new ezcWebdavCopyRequest();

        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on missing Destination header.' );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}
        // Fix this problem to test others
        $req->setHeader( 'Destination', '/foo/bar' );

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
}

?>

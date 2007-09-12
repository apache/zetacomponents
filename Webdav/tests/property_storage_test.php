<?php

class ezcWebdavPropertyStorageTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testAttachSuccess()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $prop );

        $this->assertTrue( $storage->contains( $prop ) );
    }

    public function testAttachFailure()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop = new stdClass();

        try
        {
            $storage->attach( $prop );
            $this->fail( 'Exception not thrown on invalid object attach.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertEquals( 0, $storage->count() );
    }

    public function testDetachSuccess()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $prop );

        $this->assertTrue( $storage->contains( $prop ) );

        $storage->detach( $prop );

        $this->assertFalse( $storage->contains( $prop ) );
    }

    public function testDetachFailure()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop = new stdClass();

        try
        {
            $storage->detach( $prop );
            $this->fail( 'Exception not thrown on invalid object detach.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertEquals( 0, $storage->count() );
    }

    public function testContainsSuccess()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $prop );

        $this->assertTrue( $storage->contains( $prop ) );

        $storage->detach( $prop );

        $this->assertFalse( $storage->contains( $prop ) );
    }

    public function testContainsFailure()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop = new stdClass();

        try
        {
            $storage->contains( $prop );
            $this->fail( 'Exception not thrown on invalid object contains check.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }
}

?>

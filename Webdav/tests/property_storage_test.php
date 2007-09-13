<?php

class ezcWebdavPropertyStorageTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testAttachLiveProperty()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop    = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $prop );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $prop,
                ),
            ),
            'properties',
            $storage
        );
    }

    public function testAttachDeadProperty()
    {
        $storage         = new ezcWebdavPropertyStorage();
        $prop            = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $prop );

        $this->assertAttributeEquals(
            array(
                'http://example.com/foo/bar' => array(
                    'foobar' => $prop,
                ),
            ),
            'properties',
            $storage
        );
    }

    public function testAttachMultipleProperties()
    {
        $storage  = new ezcWebdavPropertyStorage();
        $liveProp = new ezcWebdavGetContentLengthProperty();
        $deadProp = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $liveProp );
        $storage->attach( $deadProp );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp,
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp,
                ),
            ),
            'properties',
            $storage
        );
    }

    public function testAttacheMultiplePropertiesOverwrite()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $liveProp  = new ezcWebdavGetContentLengthProperty();
        $liveProp2 = new ezcWebdavGetContentLengthProperty();
        $deadProp  = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );
        $deadProp2 = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... other content' );

        $storage->attach( $liveProp );
        $storage->attach( $deadProp );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp,
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp,
                ),
            ),
            'properties',
            $storage
        );

        $storage->attach( $liveProp2 );
        $storage->attach( $deadProp2 );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp2,
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp2,
                ),
            ),
            'properties',
            $storage
        );
    }

    public function testDetachLiveProperty()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $liveProp  = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $liveProp );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp,
                ),
            ),
            'properties',
            $storage
        );

        $storage->detach( 'getcontentlength' );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(),
            ),
            'properties',
            $storage
        );
    }

    public function testDetachDeadProperty()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $deadProp  = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $deadProp );

        $this->assertAttributeEquals(
            array(
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp,
                ),
            ),
            'properties',
            $storage
        );

        $storage->detach( 'foobar', 'http://example.com/foo/bar' );

        $this->assertAttributeEquals(
            array(
                'http://example.com/foo/bar' => array()
            ),
            'properties',
            $storage
        );
    }

    public function testDetachMultipleProperties()
    {
        $storage  = new ezcWebdavPropertyStorage();
        $liveProp = new ezcWebdavGetContentLengthProperty();
        $deadProp = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $liveProp );
        $storage->attach( $deadProp );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp,
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp,
                ),
            ),
            'properties',
            $storage
        );
        
        $storage->detach( 'getcontentlength' );
        $storage->detach( 'foobar', 'http://example.com/foo/bar' );
 
        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                ),
                'http://example.com/foo/bar' => array(
                ),
            ),
            'properties',
            $storage
        );
    }
    
    public function testContainsLiveProperty()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $liveProp  = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $liveProp );
        
        $this->assertTrue(
            $storage->contains( 'getcontentlength' )
        );
        $this->assertFalse(
            $storage->contains( 'foobar', 'http://example.com/foo/bar' )
        );
    }
    
    public function testContainsDeadProperty()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $deadProp  = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $deadProp );
        
        $this->assertFalse(
            $storage->contains( 'getcontentlength' )
        );
        $this->assertTrue(
            $storage->contains( 'foobar', 'http://example.com/foo/bar' )
        );
    }

    public function testContainsMultipleProperties()
    {
        $storage  = new ezcWebdavPropertyStorage();
        $liveProp = new ezcWebdavGetContentLengthProperty();
        $deadProp = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $liveProp );
        $storage->attach( $deadProp );
        
        $this->assertTrue(
            $storage->contains( 'getcontentlength' )
        );
        $this->assertTrue(
            $storage->contains( 'foobar', 'http://example.com/foo/bar' )
        );
    }

    public function testGetLivePropertySuccess()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $liveProp  = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $liveProp );
        
        $this->assertSame(
            $liveProp,
            $storage->get( 'getcontentlength' )
        );
    }

    public function testGetLivePropertyFailure()
    {
        $storage   = new ezcWebdavPropertyStorage();
        
        $this->assertNull(
            $storage->get( 'getcontentlength' )
        );
    }

    public function testGetDeadPropertySuccess()
    {
        $storage   = new ezcWebdavPropertyStorage();
        $deadProp  = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $deadProp );
        
        $this->assertSame(
            $deadProp,
            $storage->get( 'foobar', 'http://example.com/foo/bar' )
        );
    }

    public function testGetDeadPropertyFailure()
    {
        $storage   = new ezcWebdavPropertyStorage();
        
        $this->assertNull(
            $storage->get( 'foobar', 'http://example.com/foo/bar' )
        );
    }

    public function testGetLivePropertiesExistent()
    {
        $storage = new ezcWebdavPropertyStorage();
        $prop    = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $prop );

        $this->assertEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $prop,
                ),
            ),
            $storage->getProperties()
        );
    }

    public function testGetDeadPropertiesExistent()
    {
        $storage         = new ezcWebdavPropertyStorage();
        $prop            = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $prop );

        $this->assertEquals(
            array(
                'http://example.com/foo/bar' => array(
                    'foobar' => $prop,
                ),
            ),
            $storage->getProperties( 'http://example.com/foo/bar' )
        );
    }

    public function testAttachMultipleProperties()
    {
        $storage  = new ezcWebdavPropertyStorage();
        $liveProp = new ezcWebdavGetContentLengthProperty();
        $deadProp = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $liveProp );
        $storage->attach( $deadProp );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp,
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp,
                ),
            ),
            'properties',
            $storage
        );
    }

}

?>

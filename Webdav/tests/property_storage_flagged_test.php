<?php

class ezcWebdavFlaggedPropertyStorageTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testAttachLiveProperty()
    {
        $storage = new ezcWebdavFlaggedPropertyStorage();
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
        $storage         = new ezcWebdavFlaggedPropertyStorage();
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
        $storage  = new ezcWebdavFlaggedPropertyStorage();
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

    public function testAttachMultiplePropertiesOverwrite()
    {
        $storage   = new ezcWebdavFlaggedPropertyStorage();
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

    public function testAttachLivePropertyWithFlag()
    {
        $storage = new ezcWebdavFlaggedPropertyStorage();
        $prop    = new ezcWebdavGetContentLengthProperty();

        $storage->attach( $prop, 12 );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $prop,
                ),
            ),
            'properties',
            $storage
        );

        $this->assertEquals(
            12,
            $storage->getFlag( $prop->name, $prop->namespace ),
            'Could not receive proper flag value.'
        );
    }

    public function testAttachDeadPropertyWithFlag()
    {
        $storage         = new ezcWebdavFlaggedPropertyStorage();
        $prop            = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $prop, 'string flag' );

        $this->assertAttributeEquals(
            array(
                'http://example.com/foo/bar' => array(
                    'foobar' => $prop,
                ),
            ),
            'properties',
            $storage
        );

        $this->assertEquals(
            'string flag',
            $storage->getFlag( $prop->name, $prop->namespace ),
            'Could not receive proper flag value.'
        );
    }

    public function testAttachMultiplePropertiesWithFlag()
    {
        $storage  = new ezcWebdavFlaggedPropertyStorage();
        $liveProp = new ezcWebdavGetContentLengthProperty();
        $deadProp = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );

        $storage->attach( $liveProp, 23 );
        $storage->attach( $deadProp, 42 );

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

        $this->assertEquals(
            23,
            $storage->getFlag( $liveProp->name, $liveProp->namespace ),
            'Could not receive proper flag value.'
        );

        $this->assertEquals(
            42,
            $storage->getFlag( $deadProp->name, $deadProp->namespace ),
            'Could not receive proper flag value.'
        );
    }

    public function testAttacheMultiplePropertiesOverwriteWithFlag()
    {
        $storage   = new ezcWebdavFlaggedPropertyStorage();
        $liveProp  = new ezcWebdavGetContentLengthProperty();
        $liveProp2 = new ezcWebdavGetContentLengthProperty();
        $deadProp  = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... content' );
        $deadProp2 = new ezcWebdavDeadProperty( 'http://example.com/foo/bar', 'foobar', 'some... other content' );

        $storage->attach( $liveProp );
        $storage->attach( $deadProp, 5 );

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

        $this->assertEquals(
            0,
            $storage->getFlag( $liveProp->name, $liveProp->namespace ),
            'Could not receive proper default flag value.'
        );

        $this->assertEquals(
            5,
            $storage->getFlag( $deadProp->name, $deadProp->namespace ),
            'Could not receive proper flag value.'
        );

        $storage->attach( $liveProp2, 23 );
        $storage->attach( $deadProp2, 42 );

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

        $this->assertEquals(
            23,
            $storage->getFlag( $liveProp->name, $liveProp->namespace ),
            'Could not receive proper flag value.'
        );

        $this->assertEquals(
            42,
            $storage->getFlag( $deadProp->name, $deadProp->namespace ),
            'Could not receive proper flag value.'
        );
    }

    public function testDetachLiveProperty()
    {
        $storage = new ezcWebdavFlaggedPropertyStorage();
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

        $storage->detach( 'getcontentlength' );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                ),
            ),
            'properties',
            $storage
        );

    }

    public function testDetachDeadProperty()
    {
        $storage         = new ezcWebdavFlaggedPropertyStorage();
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

        $storage->detach( 'foobar', 'http://example.com/foo/bar' );

        $this->assertAttributeEquals(
            array(
                'http://example.com/foo/bar' => array(
                ),
            ),
            'properties',
            $storage
        );
    }

    public function testDetachMultipleProperties()
    {
        $storage  = new ezcWebdavFlaggedPropertyStorage();
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

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                ),
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
                'DAV:' => array(
                ),
                'http://example.com/foo/bar' => array(
                ),
            ),
            'properties',
            $storage
        );
    }

    public function testDetachMultiplePropertiesOverwrite()
    {
        $storage   = new ezcWebdavFlaggedPropertyStorage();
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

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                    'getcontentlength' => $liveProp2,
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp,
                ),
            ),
            'properties',
            $storage
        );
        
        $storage->detach( 'getcontentlength' );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                ),
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
                'DAV:' => array(
                ),
                'http://example.com/foo/bar' => array(
                ),
            ),
            'properties',
            $storage
        );
        
        $storage->attach( $deadProp2 );

        $this->assertAttributeEquals(
            array(
                'DAV:' => array(
                ),
                'http://example.com/foo/bar' => array(
                    'foobar' => $deadProp2,
                ),
            ),
            'properties',
            $storage
        );
        
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

}

?>

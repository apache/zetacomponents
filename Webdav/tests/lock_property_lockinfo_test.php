<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavLockInfoPropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavLockInfoProperty';
        $this->propertyName = 'lockinfo';
        $this->namespace = ezcWebdavLockInfoProperty::NAMESPACE;
        $this->defaultValues = array(
            'tokenInfo' => new ArrayObject(),
            'null' => false,
        );
        $this->workingValues = array(
            'tokenInfo' => array(
                new ArrayObject( array( 23, 42 ) ),
                new ArrayObject( array( 'foo', 'bar' ) ),
            ),
            'null' => array(
                true,
                false,
            ),
        );
        $this->failingValues = array(
            'tokenInfo' => array(
                null,
                new stdClass(),
                array(),
                true,
                false,
                23,
                42.23,
                'foo'
            ),
            'null' => array(
                null,
                new stdClass(),
                array(),
                23,
                42.23,
                'foo'
            ),
        );
    }
}

?>

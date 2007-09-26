<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavGetLastModifiedPropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavGetLastModifiedProperty';
        $this->propertyName = 'getlastmodified';
        $this->defaultValues = array(
            'date' => null,
        );
        $this->workingValues = array(
            'date' => array(
                null,
                new ezcWebdavDateTime( "+3 hours" ),
            ),
        );
        $this->failingValues = array(
            'date' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                array( 23, 42 ),
                new stdClass(),
            ),
        );
    }
}

?>

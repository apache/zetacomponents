<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavGetContentTypePropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavGetContentTypeProperty';
        $this->propertyName = 'getcontenttype';
        $this->defaultValues = array(
            'mime'    => null,
            'charset' => null,
        );
        $this->workingValues = array(
            'mime' => array(
                null,
                "foo bar",
                "",
            ),
            'charset' => array(
                null,
                "foo bar",
                "",
            ),
        );
        $this->failingValues = array(
            'mime' => array(
                23,
                23.34,
                true,
                false,
                new stdClass(),
                array(),
            ),
            'charset' => array(
                23,
                23.34,
                true,
                false,
                new stdClass(),
                array(),
            ),
        );
    }
}

?>

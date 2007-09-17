<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavGetContentLengthPropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavGetContentLengthProperty';
        $this->propertyName = 'getcontentlength';
        $this->defaultValues = array(
            'length' => null,
        );
        $this->workingValues = array(
            'length' => array(
                null,
                "1234",
                // 2 GB + 1b
                "2147483649"
            ),
        );
        $this->failingValues = array(
            'length' => array(
                'foo',
                23,
                23.34,
                true,
                false,
                new stdClass(),
            ),
        );
    }
}

?>

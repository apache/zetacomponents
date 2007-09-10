<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavGetEtagPropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavGetEtagProperty';
        $this->defaultValues = array(
            'etag'    => null,
        );
        $this->workingValues = array(
            'etag' => array(
                null,
                "foo bar",
                "",
            ),
        );
        $this->failingValues = array(
            'etag' => array(
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

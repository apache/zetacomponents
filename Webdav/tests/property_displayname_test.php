<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavDisplayNamePropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavDisplayNameProperty';
        $this->defaultValues = array(
            'name' => null,
        );
        $this->workingValues = array(
            'name' => array(
                null,
                '',
                'Foo Bar Baz',
            ),
        );
        $this->failingValues = array(
            'name' => array(
                23,
                23.34,
                true,
                false,
                array( 23, 42 ),
                new stdClass(),
            ),
        );
    }
}

?>

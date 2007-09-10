<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavCreationdatePropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavCreationDateProperty';
        $this->defaultValues = array(
            'date' => null,
        );
        $this->workingValues = array(
            'date' => array(
                null,
                new DateTime( "+3 hours" ),
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

<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavSourcePropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavSourceProperty';
        $this->defaultValues = array(
            'links' => array(),
        );
        $this->workingValues = array(
            'links' => array(
                array(),
                array(
                    new ezcWebdavSourcePropertyLink(),
                    new ezcWebdavSourcePropertyLink(),
                ),
            ),
        );
        $this->failingValues = array(
            'links' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                new stdClass(),
            ),
        );
    }
}

?>

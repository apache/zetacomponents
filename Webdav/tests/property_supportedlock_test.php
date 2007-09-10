<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavSupportedLockPropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavSupportedLockProperty';
        $this->defaultValues = array(
            'lockEntry' => null,
        );
        $this->workingValues = array(
            'lockEntry' => array(
                null,
                array(
                    new ezcWebdavSupportedLockPropertyLockentry(),
                    new ezcWebdavSupportedLockPropertyLockentry(),
                ),
            ),
        );
        $this->failingValues = array(
            'lockEntry' => array(
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

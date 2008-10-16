<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavLockDiscoveryPropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavLockDiscoveryProperty';
        $this->propertyName = 'lockdiscovery';
        $this->defaultValues = array(
            'activeLock' => new ArrayObject(),
        );
        $this->workingValues = array(
            'activeLock' => array(
                new ArrayObject(),
                new ArrayObject(
                    array(
                        new ezcWebdavLockDiscoveryPropertyActiveLock(),
                        new ezcWebdavLockDiscoveryPropertyActiveLock(),
                    )
                ),
            ),
        );
        $this->failingValues = array(
            'activeLock' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                new stdClass(),
                array(),
            ),
        );
    }
}

?>

<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavSupportedLockPropertyLockentryTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavSupportedLockPropertyLockentry';
        $this->defaultValues = array(
            'lockType'  => ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_READ,
            'lockScope' => ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_SHARED,
        );
        $this->workingValues = array(
            'lockType' => array(
                ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_READ,
                ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_WRITE,
            ),
            'lockScope' => array(
                ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_SHARED,
                ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_EXCLUSIVE,
            ),
        );
        $this->failingValues = array(
            'lockType' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                new stdClass(),
                array(),
            ),
            'lockScope' => array(
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

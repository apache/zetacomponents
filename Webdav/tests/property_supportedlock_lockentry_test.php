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
            'locktype'  => ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_READ,
            'lockscope' => ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_SHARED,
        );
        $this->workingValues = array(
            'locktype' => array(
                ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_READ,
                ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_WRITE,
            ),
            'lockscope' => array(
                ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_SHARED,
                ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_EXCLUSIVE,
            ),
        );
        $this->failingValues = array(
            'locktype' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                new stdClass(),
                array(),
            ),
            'lockscope' => array(
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

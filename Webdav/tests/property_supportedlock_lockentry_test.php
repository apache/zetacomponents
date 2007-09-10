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
            'locktype'  => ezcWebdavLockDiscoveryPropertyActivelock::TYPE_READ,
            'lockscope' => ezcWebdavLockDiscoveryPropertyActivelock::SCOPE_SHARED,
        );
        $this->workingValues = array(
            'locktype' => array(
                ezcWebdavLockDiscoveryPropertyActivelock::TYPE_READ,
                ezcWebdavLockDiscoveryPropertyActivelock::TYPE_WRITE,
            ),
            'lockscope' => array(
                ezcWebdavLockDiscoveryPropertyActivelock::SCOPE_SHARED,
                ezcWebdavLockDiscoveryPropertyActivelock::SCOPE_EXCLUSIVE,
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

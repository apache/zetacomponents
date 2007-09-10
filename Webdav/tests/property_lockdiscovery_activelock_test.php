<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavLockDiscoveryPropertyActiveLockTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavLockDiscoveryPropertyActiveLock';
        $this->defaultValues = array(
            'locktype'  => ezcWebdavLockDiscoveryPropertyActiveLock::TYPE_READ,
            'lockscope' => ezcWebdavLockDiscoveryPropertyActiveLock::SCOPE_SHARED,
            'depth'     => ezcWebdavLockDiscoveryPropertyActiveLock::DEPTH_INFINITY,
            'owner'     => null,
            'timeout'   => null,
            'tokens'    => array(),
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
            'depth' => array(
                ezcWebdavLockDiscoveryPropertyActiveLock::DEPTH_ZERO,
                ezcWebdavLockDiscoveryPropertyActiveLock::DEPTH_ONE,
                ezcWebdavLockDiscoveryPropertyActiveLock::DEPTH_INFINITY,
            ),
            'owner' => array(
                null,
                '',
                'Foo Bar',
            ),
            'timeout' => array(
                null,
                new DateTime( '+3 hours' ),
            ),
            'tokens' => array(
                array(),
                array( 'foo', 'bar' ),
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
            'depth' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                new stdClass(),
                array(),
            ),
            'owner' => array(
                23,
                23.34,
                true,
                false,
                new stdClass(),
                array(),
            ),
            'timeout' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                new stdClass(),
                array(),
            ),
            'tokens' => array(
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

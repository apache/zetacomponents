<?php

require_once dirname( __FILE__ ) . '/property_test.php';

class ezcWebdavCreationlocktypePropertyTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavLockDiscoveryPropertyActivelock';
        $this->defaultValues = array(
            'locktype'  => ezcWebdavLockDiscoveryPropertyActivelock::TYPE_READ,
            'lockscope' => ezcWebdavLockDiscoveryPropertyActivelock::SCOPE_SHARED,
            'depth'     => ezcWebdavLockDiscoveryPropertyActivelock::DEPTH_INFINITY,
            'owner'     => null,
            'timeout'   => null,
            'tokens'    => array(),
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
            'depth' => array(
                ezcWebdavLockDiscoveryPropertyActivelock::DEPTH_ZERO,
                ezcWebdavLockDiscoveryPropertyActivelock::DEPTH_ONE,
                ezcWebdavLockDiscoveryPropertyActivelock::DEPTH_INFINITY,
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

<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavLockDiscoveryPropertyActiveLockTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavLockDiscoveryPropertyActiveLock';
        $this->propertyName = 'activelock';
        $this->defaultValues = array(
            'lockType'  => ezcWebdavLockRequest::TYPE_READ,
            'lockScope' => ezcWebdavLockRequest::SCOPE_SHARED,
            'depth'     => ezcWebdavRequest::DEPTH_INFINITY,
            'owner'     => new ezcWebdavPotentialUriContent(),
            'timeout'   => null,
            'tokens'    => new ArrayObject(),
        );
        $this->workingValues = array(
            'lockType' => array(
                ezcWebdavLockRequest::TYPE_READ,
                ezcWebdavLockRequest::TYPE_WRITE,
            ),
            'lockScope' => array(
                ezcWebdavLockRequest::SCOPE_SHARED,
                ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
            ),
            'depth' => array(
                ezcWebdavRequest::DEPTH_ZERO,
                ezcWebdavRequest::DEPTH_ONE,
                ezcWebdavRequest::DEPTH_INFINITY,
            ),
            'owner' => array(
                new ezcWebdavPotentialUriContent( '' ),
                new ezcWebdavPotentialUriContent( 'Foo Bar' ),
                new ezcWebdavPotentialUriContent( 'http://example.com', true ),
            ),
            'timeout' => array(
                null,
                1,
                23,
            ),
            'tokens' => array(
                new ArrayObject(),
                new ArrayObject( array( 'foo', 'bar' ) ),
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
                -23,
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
                array(),
                new stdClass(),
            ),
        );
        $this->alwaysHasContent = true;
    }
}

?>

<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavSupportedLockPropertyLockentryTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavSupportedLockPropertyLockentry';
        $this->propertyName = 'lockentry';
        $this->defaultValues = array(
            'lockType'  => ezcWebdavLockRequest::TYPE_READ,
            'lockScope' => ezcWebdavLockRequest::SCOPE_SHARED,
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
        $this->alwaysHasContent = true;
    }
}

?>

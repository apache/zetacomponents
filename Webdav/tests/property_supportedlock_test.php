<?php

require_once dirname( __FILE__ ) . '/webdav_property_test.php';

class ezcWebdavSupportedLockPropertyTest extends ezcWebdavWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavSupportedLockProperty';
        $this->propertyName = 'supportedlock';
        $this->defaultValues = array(
            'lockEntries' => new ArrayObject(),
        );
        $this->workingValues = array(
            'lockEntries' => array(
                new ArrayObject(),
                new ArrayObject(
                    array(
                        new ezcWebdavSupportedLockPropertyLockentry(),
                        new ezcWebdavSupportedLockPropertyLockentry(),
                    )
                ),
            ),
        );
        $this->failingValues = array(
            'lockEntries' => array(
                23,
                23.34,
                'foobar',
                true,
                false,
                array(),
                new stdClass(),
            ),
        );
    }
}

?>

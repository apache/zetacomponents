<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */

require_once dirname( __FILE__ ) . '/property_test.php';

/**
 * Test case for the ezcWebdavFileBackendOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavFileBackendOptionsTestCase extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavFileBackendOptions';
        $this->defaultValues = array(
            'noLock'                => false,
            'waitForLock'           => 200000,
            'lockFileName'          => '.ezc_lock',
            'propertyStoragePath'   => '.ezc',
            'directoryMode'         => 0755,
            'fileMode'              => 0644,
            'useMimeExts'           => true,
            'hideDotFiles'          => true,
        );
        $this->workingValues = array(
            'noLock'                => array(
                true,
                false
            ),
            'waitForLock'           => array(
                0,
                100000
            ),
            'lockFileName'          => array(
                '.foo',
                'bar'
            ),
            'propertyStoragePath'   => array(
                '.foo',
                'bar'
            ),
            'directoryMode'         => array(
                0,
                100
            ),
            'fileMode'              => array(
                0,
                100
            ),
            'useMimeExts'           => array(
                true,
                false
            ),
            'hideDotFiles'          => array(
                true,
                false
            ),
        );
        $this->failingValues = array(
            'noLock'                => array(
                23,
                23.34,
                'foo',
                array(),
                new stdClass(),
            ),
            'waitForLock'           => array(
                23.34,
                'foo',
                array(),
                false,
                new stdClass(),
            ),
            'lockFileName'          => array(
                23,
                23.34,
                array(),
                false,
                new stdClass(),
            ),
            'propertyStoragePath'   => array(
                23,
                23.34,
                array(),
                false,
                new stdClass(),
            ),
            'directoryMode'         => array(
                23.34,
                'foo',
                array(),
                false,
                new stdClass(),
            ),
            'fileMode'              => array(
                23.34,
                'foo',
                array(),
                false,
                new stdClass(),
            ),
            'useMimeExts'           => array(
                23,
                23.34,
                'foo',
                array(),
                new stdClass(),
            ),
            'hideDotFiles'          => array(
                23,
                23.34,
                'foo',
                array(),
                new stdClass(),
            ),
        );
    }

    public function testCtorSuccess()
    {
        $class = new ReflectionClass( $this->className );
        $object = $class->newInstance();

        $this->assertPropertyValues( $object, $this->defaultValues );
    }
}

?>

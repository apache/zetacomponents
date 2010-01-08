<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcWebdavServerOptionsTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavServerOptions';
        $this->defaultValues = array(
            'realm' => 'eZ Components WebDAV',
        );
        $this->workingValues = array(
            'realm' => array(
                'Some nice realm.',
                '    ',
                '23',
                ''
            ),
        );
        $this->failingValues = array(
            'realm' => array(
                null,
                true,
                false,
                23,
                -42.23,
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

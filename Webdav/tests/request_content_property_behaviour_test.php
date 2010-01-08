<?php
/**
 * File containing the ezcWebdavRequestPropertyBehaviourContentTest class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */

require_once dirname( __FILE__ ) . '/property_test.php';

/**
 * Test case for the ezcWebdavRequestPropertyBehaviourContent class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavRequestPropertyBehaviourContentTest extends ezcWebdavPropertyTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavRequestPropertyBehaviourContent';
        $this->defaultValues = array(
            'keepAlive' => null,
            'omit'      => false,
        );
        $this->workingValues = array(
            'keepAlive' => array(
                array( 'http://example.com', 'http://example.com/test' ),
                ezcWebdavRequestPropertyBehaviourContent::ALL,
                null,
            ),
            'omit' => array(
                true,
                false,
            ),
        );
        $this->failingValues = array(
            'keepAlive' => array(
                23,
                23.34,
                'foo',
                true,
                false,
                new stdClass(),
            ),
            'omit' => array(
                23,
                23.34,
                'foo',
                new stdClass(),
                array( 23, 42 ),
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

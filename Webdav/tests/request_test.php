<?php
/**
 * Basic test cases for the path factory class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'property_test.php';

/**
 * Tests for ezcWebdavPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
abstract class ezcWebdavRequestTestCase extends ezcWebdavPropertyTestCase
{
    /**
     * Array with constructor arguments.
     * 
     * @var array(mixed)
     */
    protected $constructorArguments = array();

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavRequestTestCase' );
	}

    /**
     * Get object of $className for testing.
     * 
     * @return stdClass
     */
    protected function getObject()
    {
        $class = new ReflectionClass( $this->className );
        return $class->newInstanceArgs( $this->constructorArguments );
    }

    /**
     * Do not run this test here.
     */
    public function testCtorSuccess()
    {
        return true;
    }
}
?>

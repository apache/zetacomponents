<?php
/**
 * Class containing the ezcWebdavRequestTestCase class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'property_test.php';

/**
 * Base test case class for request class testing.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
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

    public function testPathsToAuthorize()
    {
        $req = $this->getObject();

        if ( !( $req instanceof ezcWebdavRequest ) )
        {
            $this->markTestSkipped( 'Not a request object.' );
        }

        $paths = $req->getPathsToAuthorize();

        $this->assertType(
            'array',
            $paths
        );

        $this->assertEquals(
            1,
            count( $paths )
        );

        $this->assertEquals(
            ezcWebdavAuth::ACCESS_READ,
            $paths[$req->requestUri]
        );
    }
}
?>

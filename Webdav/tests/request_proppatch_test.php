<?php
/**
 * File containing the ezcWebdavPropPatchRequestTest class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright PropPatchright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'request_test.php';

/**
 * Test case for the ezcWebdavPropPatchRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright PropPatchright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavPropPatchRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavPropPatchRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
            'set'    => new ezcWebdavPropertyStorage(),
            'remove' => new ezcWebdavPropertyStorage(),
        );
        $this->workingValues = array(
            'set' => array(
                new ezcWebdavPropertyStorage(),
            ),
            'remove' => array(
                new ezcWebdavPropertyStorage(),
            ),
        );
        $this->failingValues = array(
            'set' => array(
                23,
                23.34,
                'foo bar',
                array( 23, 42 ),
                new stdClass(),
            ),
            'remove' => array(
                23,
                23.34,
                'foo bar',
                array( 23, 42 ),
                new stdClass(),
            ),
        );
    }
}

?>

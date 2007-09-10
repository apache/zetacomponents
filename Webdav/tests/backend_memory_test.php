<?php
/**
 * Basic test cases for the memory backend.
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
require_once 'test_case.php';

/**
 * Tests for ezcWebdavMemoryBackend class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavMemoryBackendTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavMemoryBackendTest' );
	}

    public function testEmptyMemoryServerCreation()
    {
        $backend = new ezcWebdavMemoryBackend( array() );

        $content = $this->readAttribute( $backend, 'content' );
        $this->assertEquals(
            $content,
            array(),
            'Expected empty content array.'
        );

        $props = $this->readAttribute( $backend, 'props' );
        $this->assertEquals(
            $props,
            array(),
            'Expected empty property array.'
        );
    }
}
?>

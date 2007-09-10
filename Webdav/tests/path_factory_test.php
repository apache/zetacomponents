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
require_once 'test_case.php';

/**
 * Tests for ezcWebdavPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavPathFactoryTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavPathFactoryTest' );
	}
}
?>

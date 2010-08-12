<?php
/**
 * Class containing the ezcWebdavRequestTestCase class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
}
?>

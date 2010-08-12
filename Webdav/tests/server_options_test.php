<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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

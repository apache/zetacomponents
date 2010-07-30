<?php
/**
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionFunctionExternalTest extends ezcReflectionFunctionTest
{
    public function setUp() {
        $this->php_fctM1 = new ReflectionFunction( 'm1' );
        $this->php_fctM2 = new ReflectionFunction( 'm2' );
        $this->php_fctM3 = new ReflectionFunction( 'm3' );
        $this->php_fct_method_exists = new ReflectionFunction( 'method_exists' );
        $this->fctM1 = new ezcReflectionFunction( new MyReflectionFunction( 'm1' ) );
        $this->fctM2 = new ezcReflectionFunction( new MyReflectionFunction( 'm2' ) );
        $this->fctM3 = new ezcReflectionFunction( new MyReflectionFunction( 'm3' ) );
        $this->fct_method_exists = new ezcReflectionFunction( new MyReflectionFunction( 'method_exists' ) );
    }

	public function testCall() {
		self::assertTrue($this->fctM1->doSomeMetaProgramming());
		self::assertTrue($this->fctM2->doSomeMetaProgramming());
		self::assertTrue($this->fctM3->doSomeMetaProgramming());
		self::assertTrue($this->fct_method_exists->doSomeMetaProgramming());
	}
    
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionFunctionExternalTest" );
    }
}
?>

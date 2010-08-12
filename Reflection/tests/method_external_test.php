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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionMethodExternalTest extends ezcReflectionMethodTest
{
    
    protected function setUpFixtures() {
        $this->fctM1 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm1' ) );
        $this->fctM2 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm2' ) );
        $this->fctM3 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm3' ) );
        $this->fctM4 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm4' ) );
        $this->fct_method_exists = new ezcReflectionMethod( 'ReflectionClass', new MyReflectionMethod( 'ReflectionClass', 'hasMethod' ) );
        $this->ezc_TestMethods2_m1 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm1' ) );
        $this->ezc_TestMethods2_m2 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm2' ) );
        $this->ezc_TestMethods2_m3 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm3' ) );
        $this->ezc_TestMethods2_m4 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm4' ) );
        $this->ezc_TestMethods2_newMethod = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'newMethod' ) );
        $this->ezc_ReflectionMethod_isInternal = new ezcReflectionMethod( 'ReflectionMethod', new MyReflectionMethod( 'ReflectionMethod', 'isInternal' ) );
        $this->ezc_ezcReflectionMethod_isInternal = new ezcReflectionMethod( 'ezcReflectionMethod', new MyReflectionMethod( 'ezcReflectionMethod', 'isInternal' ) );
        $this->ezc_ezcReflectionMethod_isInherited = new ezcReflectionMethod( 'ezcReflectionMethod', new MyReflectionMethod( 'ezcReflectionMethod', 'isInherited' ) );
        $this->ezc_ezcReflectionMethod_getAnnotations = new ezcReflectionMethod( 'ezcReflectionMethod', new MyReflectionMethod( 'ezcReflectionMethod', 'getAnnotations' ) );
    }
    
	public function testCall() {
		self::assertTrue($this->fctM1->doSomeMetaProgramming());
		self::assertTrue($this->fctM2->doSomeMetaProgramming());
		self::assertTrue($this->fctM3->doSomeMetaProgramming());
		self::assertTrue($this->fct_method_exists->doSomeMetaProgramming());
	}
    
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionMethodExternalTest" );
    }
}
?>

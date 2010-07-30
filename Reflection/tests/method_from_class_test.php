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

class ezcReflectionMethodFromClassTest extends ezcReflectionMethodTest
{
    protected function setUpFixtures() {
        // ezcReflectionMethods obtained from ezcReflectionClass
        $classTestMethods = new ezcReflectionClass( 'TestMethods' );
        $this->fctM1 = $classTestMethods->getMethod( 'm1' );
        $this->fctM2 = $classTestMethods->getMethod( 'm2' );
        $this->fctM3 = $classTestMethods->getMethod( 'm3' );
        $this->fctM4 = $classTestMethods->getMethod( 'm4' );
        $classTestMethods2 = new ezcReflectionClass( 'TestMethods2' );
        $this->ezc_TestMethods2_m1 = $classTestMethods2->getMethod( 'm1' );
        $this->ezc_TestMethods2_m2 = $classTestMethods2->getMethod( 'm2' );
        $this->ezc_TestMethods2_m3 = $classTestMethods2->getMethod( 'm3' );
        $this->ezc_TestMethods2_m4 = $classTestMethods2->getMethod( 'm4' );
        $this->ezc_TestMethods2_newMethod = $classTestMethods2->getMethod( 'newMethod' );
        $classReflectionClass = new ezcReflectionClass( 'ReflectionClass' );
        $this->fct_method_exists = $classReflectionClass->getMethod( 'hasMethod' );
        $classReflectionMethod = new ezcReflectionClass( 'ReflectionMethod' );
        $this->ezc_ReflectionMethod_isInternal = $classReflectionMethod->getMethod( 'isInternal' );
        $classEzcReflectionMethod = new ezcReflectionClass( 'ezcReflectionMethod' );
        $this->ezc_ezcReflectionMethod_isInternal = $classEzcReflectionMethod->getMethod( 'isInternal' );
        $this->ezc_ezcReflectionMethod_isInherited = $classEzcReflectionMethod->getMethod( 'isInherited' );
        $this->ezc_ezcReflectionMethod_getAnnotations = $classEzcReflectionMethod->getMethod( 'getAnnotations' );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionMethodFromClassTest" );
    }
}
?>

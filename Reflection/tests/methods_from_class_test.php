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

class ezcReflectionMethodsFromClassTest extends ezcReflectionMethodTest
{
    protected function setUpFixtures() {
        // ezcReflectionMethods obtained from ezcReflectionClass
        $classTestMethods = new ezcReflectionClass( 'TestMethods' );
        foreach ( $classTestMethods->getMethods() as $method ) {
            if ( $method->getName() == 'm1' ) $this->fctM1 = $method;
            if ( $method->getName() == 'm2' ) $this->fctM2 = $method;
            if ( $method->getName() == 'm3' ) $this->fctM3 = $method;
            if ( $method->getName() == 'm4' ) $this->fctM4 = $method;
        }
        $classTestMethods2 = new ezcReflectionClass( 'TestMethods2' );
        foreach ( $classTestMethods2->getMethods() as $method ) {
            if ( $method->getName() == 'm1' ) $this->ezc_TestMethods2_m1 = $method;
            if ( $method->getName() == 'm2' ) $this->ezc_TestMethods2_m2 = $method;
            if ( $method->getName() == 'm3' ) $this->ezc_TestMethods2_m3 = $method;
            if ( $method->getName() == 'm4' ) $this->ezc_TestMethods2_m4 = $method;
            if ( $method->getName() == 'newMethod' ) $this->ezc_TestMethods2_newMethod = $method;
        }
        $classReflectionClass = new ezcReflectionClass( 'ReflectionClass' );
        foreach ( $classReflectionClass->getMethods() as $method ) {
            if ( $method->getName() == 'hasMethod' ) {
                $this->fct_method_exists = $method;
                break;
            }
        }
        $classReflectionMethod = new ezcReflectionClass( 'ReflectionMethod' );
        foreach ( $classReflectionMethod->getMethods() as $method ) {
            if ( $method->getName() == 'isInternal' ) {
                $this->ezc_ReflectionMethod_isInternal = $method;
                break;
            }
        }
        $classEzcReflectionMethod = new ezcReflectionClass( 'ezcReflectionMethod' );
        foreach ( $classEzcReflectionMethod->getMethods() as $method ) {
            if ( $method->getName() == 'isInternal' ) {
                $this->ezc_ezcReflectionMethod_isInternal = $method;
            }
            if ( $method->getName() == 'isInherited' ) {
                $this->ezc_ezcReflectionMethod_isInherited = $method;
            }
            if ( $method->getName() == 'getAnnotations' ) {
                $this->ezc_ezcReflectionMethod_getAnnotations = $method;
            }
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionMethodsFromClassTest" );
    }
}
?>

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

class ezcReflectionParameterExternalTest extends ezcReflectionParameterTest
{
    public function setUpFixtures() {
        // function with undocumented parameter $t that has default value 'foo'
        $function = new ReflectionFunction( 'mmm' );
//        $this->expected['mmm'] = $function->getParameters();
        foreach ( $this->expected['mmm'] as $key => $param ) {
            $this->actual['mmm'][$key] = new ezcReflectionParameter( null, $param );
        }

        // function with three parameters that have type annotations but no type hints
//        $this->expectedFunctionM1 = new ReflectionFunction( 'm1' );
//        $this->expected['m1'] = $this->expectedFunctionM1->getParameters();
        $paramTypes = array( 'string', 'ezcReflection', 'ReflectionClass' );
        foreach ( $this->expected['m1'] as $key => $param ) {
            $this->actualParamsOfM1[] =
                new ezcReflectionParameter( null, $param, $paramTypes[$key] );
        }

        // method with one undocumented parameter
//        $this->expectedMethod_TestMethods_m3 = new ReflectionMethod( 'TestMethods', 'm3' );
//        $this->expected['TestMethods::m3'] = $this->expectedMethod_TestMethods_m3->getParameters();
        foreach ( $this->expected['TestMethods::m3'] as $param ) {
            $this->actualParamsOf_TestMethods_m3[] = new ezcReflectionParameter( null, $param );
        }

        // method with parameter that has type hint
//        $this->expectedMethod_ezcReflection_setReflectionTypeFactory
//            = new ReflectionMethod( 'ezcReflection', 'setReflectionTypeFactory' );
//        $this->expected['ezcReflection::setReflectionTypeFactory']
//            = $this->expectedMethod_ezcReflection_setReflectionTypeFactory->getParameters();
        foreach ( $this->expected['ezcReflection::setReflectionTypeFactory'] as $param ) {
            $this->actualParamsOf_ezcReflection_setReflectionTypeFactory[] = new ezcReflectionParameter( null, $param, 'ezcReflectionTypeFactory' );
        }

        // function with parameter that has type hint only
//        $this->expectedFunction_functionWithTypeHint = new ReflectionFunction( 'functionWithTypeHint' );
//        $this->expected['functionWithTypeHint'] = $this->expectedFunction_functionWithTypeHint->getParameters();
        $this->actualParamsOf_functionWithTypeHint[] = new ezcReflectionParameter( 'ReflectionClass', $this->expected['functionWithTypeHint'][0] );

//        unset(
//            $this->expectedFunctionM1,
//            $this->expectedMethod_TestMethods_m3,
//            $this->expectedMethod_ezcReflection_setReflectionTypeFactory,
//            $this->expectedFunction_functionWithTypeHint
//        );
    }

    public function testExport( $functionName = null, $paramKey = null ) {
        // no need to test this again
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionParameterExternalTest" );
    }

}

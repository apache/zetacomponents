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

class ezcReflectionParametersFromFunctionTest extends ezcReflectionParameterTest
{
    public function setUpFixtures() {
        // function with undocumented parameter $t that has default value 'foo'
        $function = new ezcReflectionFunction( 'mmm' );
        $this->actual['mmm'] = $function->getParameters();

        // function with three parameters that have type annotations but no type hints
//        $this->expectedFunctionM1 = new ReflectionFunction( 'm1' );
//        $this->expected['m1'] = $this->expectedFunctionM1->getParameters();
        $this->actualFunctionM1   = new ezcReflectionFunction( 'm1' );
        $this->actualParamsOfM1   = $this->actualFunctionM1->getParameters();

        // method with one undocumented parameter
//        $this->expectedMethod_TestMethods_m3
//            = new ReflectionMethod( 'TestMethods', 'm3' );
//        $this->expected['TestMethods::m3']
//            = $this->expectedMethod_TestMethods_m3->getParameters();
        $this->actualMethod_TestMethods_m3
            = new ezcReflectionMethod( 'TestMethods', 'm3' );
        $this->actualParamsOf_TestMethods_m3
            = $this->actualMethod_TestMethods_m3->getParameters();

        // method with parameter that has type hint
//        $expMethod
//            = new ReflectionMethod( 'ezcReflection', 'setReflectionTypeFactory' );
//        $this->expected['ezcReflection::setReflectionTypeFactory']
//            = $expMethod->getParameters();
        $this->actualMethod_ezcReflection_setReflectionTypeFactory
            = new ezcReflectionMethod( 'ezcReflection', 'setReflectionTypeFactory' );
        $this->actualParamsOf_ezcReflection_setReflectionTypeFactory
            = $this->actualMethod_ezcReflection_setReflectionTypeFactory->getParameters();

        // function with parameter that has type hint only
//        $expFunction = new ReflectionFunction( 'functionWithTypeHint' );
//        $this->expected['functionWithTypeHint'] = $expFunction->getParameters();
        $this->actualFunction_functionWithTypeHint
            = new ezcReflectionFunction( 'functionWithTypeHint' );
        $this->actualParamsOf_functionWithTypeHint
            = $this->actualFunction_functionWithTypeHint->getParameters();

        unset(
            $this->expectedFunctionM1,
            $this->expectedMethod_TestMethods_m3,
            $this->expectedMethod_ezcReflection_setReflectionTypeFactory,
            $this->expectedFunction_functionWithTypeHint,
            $this->actualFunctionM1,
            $this->actualMethod_TestMethods_m3,
            $this->actualMethod_ezcReflection_setReflectionTypeFactory,
            $this->actualFunction_functionWithTypeHint
        );
    }

    public function testExport( $functionName = null, $paramKey = null ) {
        // no need to test this again
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionParametersFromFunctionTest" );
    }
}
?>

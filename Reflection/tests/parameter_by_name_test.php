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

class ezcReflectionParameterByNameTest extends ezcReflectionParameterTest
{

    public function setUpFixtures() {
        // function with undocumented parameter $t that has default value 'foo'
//        $this->expected['mmm'][0] = new ReflectionParameter( 'mmm', 't' );
        $this->actual['mmm'][0] = new ezcReflectionParameter( 'mmm', 't' );

        // function with three parameters that have type annotations but no type hints
        $paramNames = array( 'test', 'test2', 'test3' );
        $paramTypes = array( 'string', 'ezcReflection', 'ReflectionClass' );
        for ( $i = 0; $i <= 2; ++$i ) {
//            $this->expected['m1'][$i]
//                = new ReflectionParameter( 'm1', $paramNames[$i] );
            $this->actualParamsOfM1[$i]
                = new ezcReflectionParameter( 'm1', $paramNames[$i], $paramTypes[$i] );
        }

        // method with one undocumented parameter
//        $this->expected['TestMethods::m3'][]
//            = new ReflectionParameter( array( 'TestMethods', 'm3' ), 'undocumented' );
        $this->actualParamsOf_TestMethods_m3[]
            = new ezcReflectionParameter( array( 'TestMethods', 'm3' ), 'undocumented' );

        // method with parameter that has type hint
//        $this->expected['ezcReflection::setReflectionTypeFactory'][]
//            = new ReflectionParameter( array( 'ezcReflection', 'setReflectionTypeFactory' ), 'factory' );
        $this->actualParamsOf_ezcReflection_setReflectionTypeFactory[]
            = new ezcReflectionParameter( array( 'ezcReflection', 'setReflectionTypeFactory' ), 'factory', 'ezcReflectionTypeFactory' );

        // function with parameter that has type hint only
//        $this->expected['functionWithTypeHint'][]
//            = new ReflectionParameter( 'functionWithTypeHint', 'paramWithTypeHintOnly' );
        $this->actualParamsOf_functionWithTypeHint[]
            = new ezcReflectionParameter( 'functionWithTypeHint', 'paramWithTypeHintOnly', 'ReflectionClass' );
    }

    public function getFunctionNamesAndParamKeys() {
        $result = array();
        foreach ( $this->getExpectedFixtures() as $functionName => $expParams ) {
            foreach ( $expParams as $paramKey => $expParam ) {
                $result[]
                    = array( $functionName, $expParam->getName() );
            }
        }
        return $result;
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionParameterByNameTest" );
    }
}
?>

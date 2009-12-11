<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
        $paramTypes = array( 'string', 'ezcReflectionApi', 'ReflectionClass' );
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
//        $this->expectedMethod_ezcReflectionApi_setReflectionTypeFactory
//            = new ReflectionMethod( 'ezcReflectionApi', 'setReflectionTypeFactory' );
//        $this->expected['ezcReflectionApi::setReflectionTypeFactory']
//            = $this->expectedMethod_ezcReflectionApi_setReflectionTypeFactory->getParameters();
        foreach ( $this->expected['ezcReflectionApi::setReflectionTypeFactory'] as $param ) {
            $this->actualParamsOf_ezcReflectionApi_setReflectionTypeFactory[] = new ezcReflectionParameter( null, $param, 'ezcReflectionTypeFactory' );
        }

        // function with parameter that has type hint only
//        $this->expectedFunction_functionWithTypeHint = new ReflectionFunction( 'functionWithTypeHint' );
//        $this->expected['functionWithTypeHint'] = $this->expectedFunction_functionWithTypeHint->getParameters();
        $this->actualParamsOf_functionWithTypeHint[] = new ezcReflectionParameter( 'ReflectionClass', $this->expected['functionWithTypeHint'][0] );

//        unset(
//            $this->expectedFunctionM1,
//            $this->expectedMethod_TestMethods_m3,
//            $this->expectedMethod_ezcReflectionApi_setReflectionTypeFactory,
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

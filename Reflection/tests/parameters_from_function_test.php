<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
//            = new ReflectionMethod( 'ezcReflectionApi', 'setReflectionTypeFactory' );
//        $this->expected['ezcReflectionApi::setReflectionTypeFactory']
//            = $expMethod->getParameters();
        $this->actualMethod_ezcReflectionApi_setReflectionTypeFactory
            = new ezcReflectionMethod( 'ezcReflectionApi', 'setReflectionTypeFactory' );
        $this->actualParamsOf_ezcReflectionApi_setReflectionTypeFactory
            = $this->actualMethod_ezcReflectionApi_setReflectionTypeFactory->getParameters();

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
            $this->expectedMethod_ezcReflectionApi_setReflectionTypeFactory,
            $this->expectedFunction_functionWithTypeHint,
            $this->actualFunctionM1,
            $this->actualMethod_TestMethods_m3,
            $this->actualMethod_ezcReflectionApi_setReflectionTypeFactory,
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

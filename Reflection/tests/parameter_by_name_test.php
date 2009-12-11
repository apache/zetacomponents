<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
        $paramTypes = array( 'string', 'ezcReflectionApi', 'ReflectionClass' );
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
//        $this->expected['ezcReflectionApi::setReflectionTypeFactory'][]
//            = new ReflectionParameter( array( 'ezcReflectionApi', 'setReflectionTypeFactory' ), 'factory' );
        $this->actualParamsOf_ezcReflectionApi_setReflectionTypeFactory[]
            = new ezcReflectionParameter( array( 'ezcReflectionApi', 'setReflectionTypeFactory' ), 'factory', 'ezcReflectionTypeFactory' );

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

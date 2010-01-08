<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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

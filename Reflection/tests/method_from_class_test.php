<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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

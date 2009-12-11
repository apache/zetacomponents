<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionMethodExternalTest extends ezcReflectionMethodTest
{
    
    protected function setUpFixtures() {
        $this->fctM1 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm1' ) );
        $this->fctM2 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm2' ) );
        $this->fctM3 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm3' ) );
        $this->fctM4 = new ezcReflectionMethod( 'TestMethods', new MyReflectionMethod( 'TestMethods', 'm4' ) );
        $this->fct_method_exists = new ezcReflectionMethod( 'ReflectionClass', new MyReflectionMethod( 'ReflectionClass', 'hasMethod' ) );
        $this->ezc_TestMethods2_m1 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm1' ) );
        $this->ezc_TestMethods2_m2 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm2' ) );
        $this->ezc_TestMethods2_m3 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm3' ) );
        $this->ezc_TestMethods2_m4 = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'm4' ) );
        $this->ezc_TestMethods2_newMethod = new ezcReflectionMethod( 'TestMethods2', new MyReflectionMethod( 'TestMethods2', 'newMethod' ) );
        $this->ezc_ReflectionMethod_isInternal = new ezcReflectionMethod( 'ReflectionMethod', new MyReflectionMethod( 'ReflectionMethod', 'isInternal' ) );
        $this->ezc_ezcReflectionMethod_isInternal = new ezcReflectionMethod( 'ezcReflectionMethod', new MyReflectionMethod( 'ezcReflectionMethod', 'isInternal' ) );
        $this->ezc_ezcReflectionMethod_isInherited = new ezcReflectionMethod( 'ezcReflectionMethod', new MyReflectionMethod( 'ezcReflectionMethod', 'isInherited' ) );
        $this->ezc_ezcReflectionMethod_getAnnotations = new ezcReflectionMethod( 'ezcReflectionMethod', new MyReflectionMethod( 'ezcReflectionMethod', 'getAnnotations' ) );
    }
    
	public function testCall() {
		self::assertTrue($this->fctM1->doSomeMetaProgramming());
		self::assertTrue($this->fctM2->doSomeMetaProgramming());
		self::assertTrue($this->fctM3->doSomeMetaProgramming());
		self::assertTrue($this->fct_method_exists->doSomeMetaProgramming());
	}
    
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionMethodExternalTest" );
    }
}
?>

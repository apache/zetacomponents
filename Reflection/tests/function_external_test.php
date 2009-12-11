<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionFunctionExternalTest extends ezcReflectionFunctionTest
{
    public function setUp() {
        $this->php_fctM1 = new ReflectionFunction( 'm1' );
        $this->php_fctM2 = new ReflectionFunction( 'm2' );
        $this->php_fctM3 = new ReflectionFunction( 'm3' );
        $this->php_fct_method_exists = new ReflectionFunction( 'method_exists' );
        $this->fctM1 = new ezcReflectionFunction( new MyReflectionFunction( 'm1' ) );
        $this->fctM2 = new ezcReflectionFunction( new MyReflectionFunction( 'm2' ) );
        $this->fctM3 = new ezcReflectionFunction( new MyReflectionFunction( 'm3' ) );
        $this->fct_method_exists = new ezcReflectionFunction( new MyReflectionFunction( 'method_exists' ) );
    }

	public function testCall() {
		self::assertTrue($this->fctM1->doSomeMetaProgramming());
		self::assertTrue($this->fctM2->doSomeMetaProgramming());
		self::assertTrue($this->fctM3->doSomeMetaProgramming());
		self::assertTrue($this->fct_method_exists->doSomeMetaProgramming());
	}
    
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionFunctionExternalTest" );
    }
}
?>

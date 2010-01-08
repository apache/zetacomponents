<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 * @author Falko Menge <mail@falko-menge.de>
 */

class ezcReflectionClassInstanceTest extends ezcReflectionClassTest
{
    public function setUpFixtures()
    {
        $this->class                   = new ezcReflectionClass( new SomeClass() );
        $this->classTestWebservice     = new ezcReflectionClass( new TestWebservice() );
        $this->classReflectionFunction = new ezcReflectionClass( new ReflectionFunction( 'var_export' ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

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

class ezcReflectionObjectTest extends ezcReflectionClassTest
{
    public function setUpFixtures()
    {
        $this->expected = array(
            'SomeClass'
                => new ReflectionObject( new SomeClass() ),
            'TestWebservice'
                => new ReflectionObject( new TestWebservice() ),
            'ReflectionFunction'
                => new ReflectionObject( new ReflectionFunction( 'var_export' ) ),
        );
        $this->class
            = new ezcReflectionObject( new SomeClass() );
        $this->classTestWebservice
            = new ezcReflectionObject( new TestWebservice() );
        $this->classReflectionFunction
            = new ezcReflectionObject( new ReflectionFunction( 'var_export' ) );
    }

    public function testExport() {
        $object = new TestWebservice();
        self::assertEquals( ReflectionObject::export( $object , true ), ezcReflectionObject::export( $object, true ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

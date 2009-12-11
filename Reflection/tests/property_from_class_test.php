<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionPropertyFromClassTest extends ezcReflectionPropertyTest
{

    public function setUpFixtures()
    {
        $class = new ezcReflectionClass( 'SomeClass' );
		$this->refProp = $class->getProperty( $this->refPropName );
        $this->publicProperty = $class->getProperty( $this->publicPropertyName );
        $this->actual['SomeClass']['undocumentedProperty'] = $class->getProperty( $this->undocumentedPropertyName );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionPropertyFromClassTest" );
    }
}

<?php
/**
 * Basic test cases for the path factory class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'property_test.php';

/**
 * Tests for ezcWebdavPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
abstract class ezcWebdavWebdavPropertyTestCase extends ezcWebdavPropertyTestCase
{
    /**
     * Name of property.
     * 
     * @var string
     */
    protected $propertyName;

    public function testCtorSuccess()
    {
        $class = new ReflectionClass( $this->className );
        
        // Without params
        $object = $class->newInstance();
        $this->assertPropertyValues( $object, $this->defaultValues );

        
        $params = array();
        foreach ( $this->workingValues as $propName => $values )
        {
            foreach ( $values as $value )
            {
                $params[$propName] = $value;
                $object = $class->newInstanceArgs( $params );
                $this->assertPropertyValues( $object, $params );
            }
        }
    }

    public function testPropertyNamespace()
    {
        $object = $this->getObject();

        $this->assertEquals(
            $object->namespace,
            'DAV:',
            'Property is in wrong namespace.'
        );
    }

    public function testPropertyName()
    {
        $object = $this->getObject();

        $this->assertEquals(
            $object->name,
            $this->propertyName,
            'Property has wrong name assigned.'
        );
    }
}
?>

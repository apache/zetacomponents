<?php
/**
 * Basic test cases for the path factory class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Reqiuire base test
 */

/**
 * Tests for ezcWebdavBasicPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
abstract class ezcWebdavPropertyTestCase extends ezcTestCase
{
    /**
     * Array with default values.
     * <code>
     * array( 
     *     '<name>' => <defaultValue>,
     *     // ...
     * )
     * </code>
     * 
     * @var array(string=>mixed)
     */
    protected $defaultValues = array();

    /**
     * Array with working values.
     * <code>
     * array( 
     *     '<name>' => array(
     *         <workingValue1>,
     *         <workingValue2>,
     *         <workingValue3>,
     *     ),
     *     // ...
     * )
     * </code>
     * 
     * @var array(string=>array(int=>mixed))
     */
    protected $workingValues = array();

    /**
     * Array with failing values.
     * <code>
     * array( 
     *     '<name>' => array(
     *         <failingValue1>,
     *         <failingValue2>,
     *         <failingValue3>,
     *     ),
     *     // ...
     * )
     * </code>
     * 
     * @var array(string=>array(int=>mixed))
     */
    protected $failingValues = array();

    /**
     * Class name of the property class to test. 
     * 
     * @var string
     */
    protected $className;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavPropertyTestCase' );
	}

    /**
     * Get object of $className for testing.
     * 
     * @return stdClass
     */
    protected function getObject()
    {
        return new $this->className();
    }

    // protected abstract function setup();

    /*
     * Does not work with type hints, currently.
     *
    public function testCtorFailure()
    {
        $class = new ReflectionClass( $this->className );
        
        foreach ( $this->failingValues as $propName => $values )
        {
            $params = array();
            foreach ( $values as $value )
            {
                $params[$propName] = $value;
                try
                {
                    $object = $class->newInstanceArgs( $params );
                    $this->fail(
                        'Exception not thrown on invalid value ' . var_export( $value ) . ' for property "' . $propName . '".'
                    );
                }
                catch ( ezcBaseValueException $e ) {}
            }
        }
    }
    */

    public function testGetAccessSuccess()
    {
        $object = $this->getObject();
        $this->assertPropertyValues( $object, $this->defaultValues );
    }

    public function testGetAccessFailure()
    {
        $object = $this->getObject();
        try
        {
            echo $object->fooBarBaz;
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testSetAccessSuccess()
    {
        $object = $this->getObject();
        foreach ( $this->workingValues as $propName => $values )
        {
            foreach( $values as $value )
            {
                $object->$propName = $value;
                $this->assertEquals( $value, $object->$propName );
            }
        }
    }

    public function testSetAccessFailure()
    {
        $object = $this->getObject();
        foreach ( $this->failingValues as $propName => $values )
        {
            foreach( $values as $value )
            {
                try
                {
                    $object->$propName = $value;
                    $this->fail( 'Expected ezcBaseValueException.' );
                }
                catch ( ezcBaseValueException $e ) {}

                $this->assertEquals( $this->defaultValues[$propName], $object->$propName );
            }
        }
    }

    public function testIssetAccessSuccess()
    {
        $object = $this->getObject();
        foreach ( $this->workingValues as $propName => $values )
        {
            $this->assertTrue( isset( $object->$propName ) );
        }
    }

    public function testIssetAccessFailure()
    {
        $object = $this->getObject();

        $this->assertFalse( isset( $object->fooBarBaz ) );
        $this->assertFalse( isset( $object->properties ) );
    }

    protected function assertPropertyValues( $object, array $values )
    {
        foreach ( $values as $propName => $value )
        {
            $this->assertEquals( $value, $object->$propName, "Property '$propName' does not have correct value." );
        }
    }
}
?>

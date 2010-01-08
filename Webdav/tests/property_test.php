<?php
/**
 * Basic test cases for the path factory class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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

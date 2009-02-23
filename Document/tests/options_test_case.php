<?php
/**
 * ezcDocTestConvertXhtmlDocbook
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
abstract class ezcDocumentOptionsTestCase extends ezcTestCase
{
    /**
     * Return class name of options class to test
     * 
     * @return string
     */
    abstract protected function getOptionsClassName();

    /**
     * Return default values for the options
     *
     * Returned array should be in the format:
     *
     * <code>
     *  array(
     *      array(
     *          'optionname',
     *          $value,
     *      ),
     *      ...
     *  )
     * </code>
     * 
     * @return array
     */
    public static function provideDefaultValues()
    {
        return array();
    }

    /**
     * Return valid data for options to test
     *
     * Returned array should be in the format:
     *
     * <code>
     *  array(
     *      array(
     *          'optionname',
     *          array(
     *              'value 1', 'value 2', ...
     *          ),
     *      ),
     *      ...
     *  )
     * </code>
     * 
     * @return array
     */
    public static function provideValidData()
    {
        return array();
    }

    /**
     * Return invalid data for options to test
     *
     * Returned array should be in the format:
     *
     * <code>
     *  array(
     *      array(
     *          'optionname',
     *          array(
     *              'value 1', 'value 2', ...
     *          ),
     *      ),
     *      ...
     *  )
     * </code>
     * 
     * @return array
     */
    public static function provideInvalidData()
    {
        return array();
    }

    /**
     * Test all options provided by the data provider
     * 
     * @dataProvider provideDefaultValues
     */
    public function testOptionsDefaultValues( $property, $value )
    {
        $class = $this->getOptionsClassName();
        $option = new $class();

        $this->assertSame(
            $value,
            $option->$property,
            "Default value in option class '$class' of property '$property' is not '$value'."
        );
    }

    /**
     * Test all options provided by the data provider
     * 
     * @dataProvider provideValidData
     */
    public function testOptionsValidValues( $property, $values )
    {
        $class = $this->getOptionsClassName();
        $option = new $class();

        $this->assertSetProperty(
            $option,
            $property,
            $values
        );
    }

    /**
     * Test all options provided by the data provider
     * 
     * @dataProvider provideInvalidData
     */
    public function testOptionsInvalidValues( $property, $values )
    {
        $class = $this->getOptionsClassName();
        $option = new $class();

        $this->assertSetPropertyFails(
            $option,
            $property,
            $values
        );
    }

    public function testUnknownValue()
    {
        $class = $this->getOptionsClassName();
        $option = new $class();

        try
        {
            $option->get_an_not_existing_property;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        { /* Expected */ }

        try
        {
            $option->get_an_not_existing_property = true;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        { /* Expected */ }
    }
}

?>

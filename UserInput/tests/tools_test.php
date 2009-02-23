<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package UserInput
 * @subpackage Tests
 */

class ezcInputFilterDefinitionTest extends ezcTestCase
{
    /**
     * setUp 
     * 
     * @access public
     */
    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'filter', "0.9.5-dev" ) )
        {
            $this->markTestSkipped( 'ext/filter >= 0.9.5-dev is required to run this test.' );
        }
    }

    public function testValidateDefinitionArray()
    {
        // The definition parameter should be an array
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        $def = 42;
        self::assertEquals( array( ezcInputForm::DEF_NO_ARRAY, "The definition array is not an array" ), ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionOneElement()
    {
        // There should be atleast one element
        $def = array();
        self::assertEquals( array( ezcInputForm::DEF_EMPTY, "The definition array is empty" ), ezcInputForm::validateDefinition( $def ) );
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionElementClass()
    {
        // Each element should be an array
        $def = array( 'test' => new ezcInputFormDefinitionElement() );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'float' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        $def = array( 'test' => 42 );
        self::assertEquals( array( ezcInputForm::DEF_ELEMENT_NO_DEFINITION_ELEMENT, "The definition for element 'test' is not an ezcInputFormDefinitionElement" ), ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionRequiredOrOptional()
    {
        // The first value in an element should be REQUIRED or OPTIONAL
        $def = array( 'test' => new ezcInputFormDefinitionElement( -1, 'number_int' ) );
        self::assertEquals( array( ezcInputForm::DEF_NOT_REQUIRED_OR_OPTIONAL, "The first element definition for element 'test' is not ezcInputFormDefinitionElement::OPTIONAL or ezcInputFormDefinitionElement::REQUIRED" ), ezcInputForm::validateDefinition( $def ) );
        $def = array( 'test' => new ezcInputFormDefinitionElement( 2, 'number_int' ) );
        self::assertEquals( array( ezcInputForm::DEF_NOT_REQUIRED_OR_OPTIONAL, "The first element definition for element 'test' is not ezcInputFormDefinitionElement::OPTIONAL or ezcInputFormDefinitionElement::REQUIRED" ), ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionOptionsType()
    {
        // The type for the 3rd value should either be an array, a string or a long (integer)
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'string', FILTER_FLAG_STRIP_LOW ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int', array( 'min_range' => 42 ) ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'boolean', false ) );
        self::assertEquals( array( ezcInputForm::DEF_WRONG_FLAGS_TYPE, "The options to the definition for element 'test' is not of type integer, string or array" ), ezcInputForm::validateDefinition( $def ) );

        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'callback', 'astring' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionFlagsType()
    {
        // The type for the 4th value should be an integer
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'string', null, FILTER_REQUIRE_ARRAY ) );
        $val = ezcInputForm::validateDefinition( $def );
        self::assertEquals( true, $val );

        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'boolean', null, false ) );
        $val = ezcInputForm::validateDefinition( $def );
        self::assertEquals( array( ezcInputForm::DEF_WRONG_FLAGS_TYPE, "The flags to the definition for element 'test' is not of type integer, string or array" ), $val );
    }

    public function testValidateDefinitionCallback()
    {
        // A callback filter should have the form "string" or "array(string, string)"
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'callback', 'filterFunction' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'callback', 42 ) );
        self::assertEquals( array( ezcInputForm::DEF_WRONG_FLAGS_TYPE, "The callback filter for element 'test' should not be an integer" ), ezcInputForm::validateDefinition( $def ) );
        
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'callback', array( 'filterclass', 'filterFunction' ) ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'callback', array( 42, 'filterFunction' ) ) );
        self::assertEquals( array( ezcInputForm::DEF_WRONG_FLAGS_TYPE, "The array elements for the callback filter for element 'test' should both be a string" ), ezcInputForm::validateDefinition( $def ) );
                
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'callback', array( 'filterclass', 42 ) ) );
        self::assertEquals( array( ezcInputForm::DEF_WRONG_FLAGS_TYPE, "The array elements for the callback filter for element 'test' should both be a string" ), ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionValidFilter()
    {
        // The filter should be an existing filter
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'foobar' ) );
        self::assertEquals( array( ezcInputForm::DEF_UNSUPPORTED_FILTER, "The filter 'foobar' for element 'test' does not exist. Pick one of: int, boolean, float, validate_regexp, validate_url, validate_email, validate_ip, string, stripped, encoded, special_chars, unsafe_raw, email, url, number_int, number_float, magic_quotes, callback" ), ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateDefinitionFieldName()
    {
        // The input field name should have a sane format
        $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
        
        $def = array( '' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        self::assertEquals( array( ezcInputForm::DEF_FIELD_NAME_BROKEN, "The element name '' has an unsupported format. It should start with an a-z and followed by a-z0-9_" ), ezcInputForm::validateDefinition( $def ) );
        
        $def = array( '^*(68769' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        self::assertEquals( array( ezcInputForm::DEF_FIELD_NAME_BROKEN, "The element name '^*(68769' has an unsupported format. It should start with an a-z and followed by a-z0-9_" ), ezcInputForm::validateDefinition( $def ) );
        
        $def = array( 'foobar_42' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        self::assertEquals( true, ezcInputForm::validateDefinition( $def ) );
    }

    public function testValidateThroughConstructor1()
    {
        $def = array( '^*(68769' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ) );
        try
        {
            $obj = new ezcInputForm( INPUT_GET, $def );
            self::fail( "No exception, where we should have had one" );
        }
        catch ( ezcInputFormInvalidDefinitionException $e )
        {
            self::assertEquals( "Invalid definition array: The element name '^*(68769' has an unsupported format. It should start with an a-z and followed by a-z0-9_.", $e->getMessage() );
        }
    }

    public function testValidateThroughConstructor2()
    {
        $def = array( 'dummy' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ) );
        $obj = new ezcInputForm( INPUT_GET, $def );
        try
        {
            $obj->dummy = 'should not work';
            self::fail( "No exception, where we should have had one" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertEquals( "The property 'dummy' is read-only.", $e->getMessage() );
        }
    }

    public function testRequiredAvailability()
    {
        $def = array(
            'test1' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ),
            'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test4' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'int' ),
        );
        try
        {
            $obj = new ezcInputForm( INPUT_GET, $def );
            self::fail( "No exception, where we should have had one" );
        }
        catch ( ezcInputFormVariableMissingException $e )
        {
            self::assertEquals( "Required input field 'test1' missing.", $e->getMessage() );
        }
    }

    public function testOptionalProperties()
    {
        $def = array(
            'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
        );
        $obj = new ezcInputForm( INPUT_GET, $def );
        $expectedArray = array( 'test2', 'test3' );
        self::assertEquals( $expectedArray, $obj->getOptionalProperties() );
        self::assertEquals( array(), $obj->getRequiredProperties() );
    }

    public function testInvalidOptionalProperties()
    {
        $def = array(
            'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
        );
        $obj = new ezcInputForm( INPUT_GET, $def );
        $expectedArray = array( 'test2', 'test3' );
        self::assertEquals( $expectedArray, $obj->getInvalidProperties() );
        self::assertEquals( array(), $obj->getValidProperties() );
    }

    public function testIsValid()
    {
        $def = array(
            'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
        );
        $obj = new ezcInputForm( INPUT_GET, $def );
        $expectedArray = array( 'test2', 'test3' );
        self::assertEquals( false, $obj->isValid() );
    }

    public function testGetUnsafeRawDataUnknownField()
    {
        $def = array(
            'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
        );
        try
        {
            $obj = new ezcInputForm( INPUT_GET, $def );
            $obj->getUnsafeRawData( 'test1' );
        }
        catch ( ezcInputFormUnknownFieldException $e )
        {
            self::assertEquals( "The field 'test1' is not defined.", $e->getMessage() );
        }
    }

    public function testGetUnsafeRawDataNoDataField()
    {
        $def = array(
            'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
            'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int' ),
        );
        try
        {
            $obj = new ezcInputForm( INPUT_GET, $def );
            $obj->getUnsafeRawData( 'test2' );
            self::fail( "No exception, where we should have had one" );
        }
        catch ( ezcInputFormFieldNotFoundException $e )
        {
            self::assertEquals( "The field 'test2' could not be found in the input source.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcInputFilterDefinitionTest" );
    }
}

?>

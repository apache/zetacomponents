<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Configuration
 * @subpackage Tests
 */

/**
 * @package Configuration
 * @subpackage Tests
 */
class ezcConfigurationIniReaderTest extends ezcTestCase
{
    public function testConfigSettingUseComments()
    {
        $backend = new ezcConfigurationIniReader();
        $backend->setOptions( array ( 'useComments' => true ) );
        $backend->setOptions( array ( 'useComments' => false ) );
    }

    public function testConfigSettingUseCommentsWrongType()
    {
        $backend = new ezcConfigurationIniReader();
        try
        {
            $backend->setOptions( array ( 'useComments' => 'tests/translations' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingValueException $e )
        {
            self::assertEquals( "The value 'tests/translations' that you were trying to assign to setting 'useComments' is invalid. Allowed values are: bool", $e->getMessage() );
        }
    }

    public function testGetOptions()
    {
        $backend = new ezcConfigurationIniReader();
        $backend->setOptions( array ( 'useComments' => true ) );
        $this->assertEquals( array ( 'useComments' => true ), $backend->getOptions() );
    }

    public function testConfigSettingBroken()
    {
        $backend = new ezcConfigurationIniReader();
        try
        {
            $backend->setOptions( array ( 'lOcAtIOn' => 'tests/translations' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingNotFoundException $e )
        {
            self::assertEquals( "The setting 'lOcAtIOn' is not a valid configuration setting.", $e->getMessage() );
        }
    }

    public function testInitCtor1()
    {
        $backend = new ezcConfigurationIniReader( 'files/basic.ini' );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'basic', $backend->getName() );
    }

    public function testInitCtor2()
    {
        $backend = new ezcConfigurationIniReader( 'files.foo/basic.ini' );
        $this->assertEquals( 'files.foo', $backend->getLocation() );
        $this->assertEquals( 'basic', $backend->getName() );
    }

    public function testInitCtor3()
    {
        try
        {
            $backend = new ezcConfigurationIniReader( 'files.foo/basic.f' );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcConfigurationInvalidSuffixException $e )
        {
            $this->assertEquals( "The path 'files.foo/basic.f' has an invalid suffix (should be '.ini').", $e->getMessage() );
        }
    }

    public function testInitCtor4()
    {
        $backend = new ezcConfigurationIniReader( 'files' . DIRECTORY_SEPARATOR . 'basic.ini' );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'basic', $backend->getName() );
    }

    public function testInitCtor5()
    {
        $backend = new ezcConfigurationIniReader( 'initctor5.ini' );
        $this->assertEquals( '.', $backend->getLocation() );
        $this->assertEquals( 'initctor5', $backend->getName() );
    }

    public function testInitMethod1()
    {
        $backend = new ezcConfigurationIniReader();
        $backend->init( 'files', 'basic' );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'basic', $backend->getName() );
    }

    public function testConfigExistsCtor()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/basic.ini' );
        $this->assertEquals( true, $backend->configExists() );
    }

    public function testConfigExistsInitMethod()
    {
        $backend = new ezcConfigurationIniReader();
        $backend->init( 'Configuration/tests/files', 'basic' );
        $this->assertEquals( true, $backend->configExists() );
    }

    public function testConfigNotExistsCtor()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/non-existent.ini' );
        $this->assertEquals( false, $backend->configExists() );
    }

    public function testConfigNotExistsInitMethod()
    {
        $backend = new ezcConfigurationIniReader();
        $backend->init( 'Configuration/tests/files', 'non-existent' );
        $this->assertEquals( false, $backend->configExists() );
    }

    public function testUnexistingFile()
    {
        try
        {
            $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/non-existent.ini' );
            $backend->load();
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file 'Configuration/tests/files/non-existent.ini' could not be found.", $e->getMessage() );
        }
    }

    public function testEmptyFile()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/empty.ini' );
        $return = $backend->load();
        $this->assertEquals( new ezcConfiguration(), $return );
    }

    public function testOneGroup()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/one-group.ini' );
        $return = $backend->load();

        $settings = array(
            'TheOnlyGroup' => array(
                'Setting1' => true,
                'SettingNoComment' => 42,
                'MultiRow' => false,
            )
        );
        $comments = array(
            'TheOnlyGroup' => array(
                '#' => "Just one group",
                'Setting1' => " This setting sucks",
                'MultiRow' => " Multi\n row\n comment",
            )
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function testOneGroupWithGetConfig()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/one-group.ini' );
        $backend->load();
        $return = $backend->getConfig();

        $settings = array(
            'TheOnlyGroup' => array(
                'Setting1' => true,
                'SettingNoComment' => 42,
                'MultiRow' => false,
            )
        );
        $comments = array(
            'TheOnlyGroup' => array(
                '#' => "Just one group",
                'Setting1' => " This setting sucks",
                'MultiRow' => " Multi\n row\n comment",
            )
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function testTwoGroups()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/two-groups.ini' );
        $return = $backend->load();

        $settings = array(
            'NotTheOnlyGroup' => array(
                'Setting1' => true,
            ),
            'TheSecond' => array(
                'Setting1' => false,
            ),
        );
        $comments = array(
            'NotTheOnlyGroup' => array(
                '#' => " Not just one group",
            ),
            'TheSecond' => array(
                '#' => " The second group",
            ),
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function testKake()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/kake.ini' );
        $return = $backend->load();

        $settings = array(
            'SettingsBlock' => array(
                'Kake' => array(
                    'mann' => array( 'sjokolade', 'blåbær' ),
                    'fyll' => array( 'pære', 'øl' ),
                ),
            ),
        );
        $comments = array(
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function testFormats()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/formats.ini' );
        $return = $backend->load();

        $settings = array(
            'FormatTest' => array(
				'Decimal1' => 42,
				'Decimal2' => 0,
				'MaxSize' => 400,
				'MinSize' => 0,
				'Hex1' => 11189196,
				'Hex2' => 11189196,
				'Hex3' => 11189196,
				'Hex4' => 11189196,
				'TextColor' => 66302,
				'Octal1' => 1,
				'Octal2' => 458,
				'Permission' => 438,
				'Float1' => 0.2,
				'Float2' => .8123,
				'Float3' => 42.,
				'Float4' => 314e-2,
				'Float5' => 3.141592654e1,
				'Price' => 10.4,
				'Seed' => 10e5,
                'String1' => 'Blah blah blah',
                'String2' => 'Derick "Tiger" Rethans',
                'String3' => 'Foo \\ Bar',
                'String4' => 'Foo \\',
            )
        );
        $comments = array(
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function test2D()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/multi-dim.ini' );
        $return = $backend->load();

        $settings = array(
            '2D-numbered' => array(
                'Decimal' => array( 42, 0 ),
                'Mixed' => array( 42, 0.812, false, "Derick \"Tiger\" Rethans" ),
            ),
            '2D-associative' => array(
                'Decimal' => array( 'a' => 42, 'b' => 0 ),
                'Mixed' => array( 'a' => 42, 1 => 0.812, 'b' => false, 2 => "Derick \"Tiger\" Rethans" ),
            ),
        );
        $comments = array(
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function test3D()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/multi-dim2.ini' );
        $return = $backend->load();

        $settings = array(
            '3D' => array(
                'Decimal' => array( 42, 0 ),
                'Array' =>  array(
                    'Decimal' => array( 'a' => 42, 'b' => 0 ),
                    'Mixed' => array( 'b' => false, 2 => "Derick \"Tiger\" Rethans" ),
                ),
                'Quote' => array( "quo\nted" => 'string' ),
            ),
        );
        $comments = array(
            '3D' => array(
                'Decimal' => array( " One with a comment", " Second one with a comment" ),
                'Array' => array(
                    'Mixed' => array( 2 => " One with a comment" ),
                ),
                'Quote' => array( "quo\nted" => ' One with a quoted hash key' ),
            ),
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function test3DSemiColonComment()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/multi-dim3.ini' );
        $return = $backend->load();

        $settings = array(
            '3D' => array(
                'Decimal' => array( 42, 0 ),
                'Array' =>  array(
                    'Decimal' => array( 'a' => 42, 'b' => 0 ),
                    'Mixed' => array( 'b' => false, 2 => "Derick \"Tiger\" Rethans" ),
                ),
                'Quote' => array( "quo\nted" => 'string' ),
            ),
        );
        $comments = array(
            '3D' => array(
                'Decimal' => array( " One with a comment", " Second one with a comment" ),
                'Array' => array(
                    'Mixed' => array( 2 => " One with a comment\n multiple lines" ),
                ),
                'Quote' => array( "quo\nted" => ' One with a quoted hash key' ),
            ),
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    public function testIntegerRanges32Bit()
    {
        if ( PHP_INT_SIZE !== 4 )
        {
            $this->markTestSkipped( "Only for 32 bit machines" );
        }
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/int-range.ini' );
        $return = $backend->load();

        $settings = array(
            'int32' => array(
                'InRange1' => -51,
                'InRange2' => 59,
                'InRangeJust1' => (int) '-2147483648',
                'InRangeJust2' => 2147483647,
                'OutRangeJust1' => '-2147483649',
                'OutRangeJust2' => '2147483648',
                'OutRange1' => '-21474836480',
                'OutRange2' => '21474836480',
            ),
            'int64' => array(
                'InRange1' => -51,
                'InRange2' => 59,
                'InRangeJust0' => '-9223372036854775807',
                'InRangeJust1' => '-9223372036854775808',
                'InRangeJust2' => '9223372036854775807',
                'OutRangeJust1' => '-9223372036854775809',
                'OutRangeJust2' => '9223372036854775808',
                'OutRange1' => '-92233720368547758080',
                'OutRange2' => '92233720368547758080',
            ),
        );
        $comments = array(
        );
        $expected = new ezcConfiguration( $settings, $comments );

        $this->assertSame( $expected->getAllSettings(), $return->getAllSettings() );
        $this->assertSame( -2147483648, $expected->getSetting( 'int32', 'InRangeJust0' ) );
        $this->assertSame( '-2147483649', $expected->getStringSetting( 'int32', 'OutRangeJust1' ) );
        try
        {
            $this->assertSame( '-2147483649', $expected->getNumberSetting( 'int32', 'OutRangeJust1' ) );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            self::assertSame( "The expected type for the setting 'int32', 'OutRangeJust1' is 'double or integer'. The setting was of type 'string'.", $e->getMessage() );
        }
    }

    public function testIntegerRanges64Bit()
    {
        if ( PHP_INT_SIZE !== 8 )
        {
            $this->markTestSkipped( "Only for 64 bit machines" );
        }
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/int-range.ini' );
        $return = $backend->load();

        $settings = array(
            'int32' => array(
                'InRange1' => -51,
                'InRange2' => 59,
                'InRangeJust1' => -2147483648,
                'InRangeJust2' => 2147483647,
                'OutRangeJust1' => -2147483649,
                'OutRangeJust2' => 2147483648,
                'OutRange1' => -21474836480,
                'OutRange2' => 21474836480,
            ),
            'int64' => array(
                'InRange1' => -51,
                'InRange2' => 59,
                'InRangeJust0' => -9223372036854775807,
                'InRangeJust1' => (int) '-9223372036854775808', // yes, this is really necessary
                'InRangeJust2' => 9223372036854775807,
                'OutRangeJust1' => '-9223372036854775809',
                'OutRangeJust2' => '9223372036854775808',
                'OutRange1' => '-92233720368547758080',
                'OutRange2' => '92233720368547758080',
            ),
        );
        $comments = array(
        );
        $expected = new ezcConfiguration( $settings, $comments );

        $this->assertSame( $expected->getAllSettings(), $return->getAllSettings() );
        $this->assertSame( -9223372036854775807, $expected->getSetting( 'int64', 'InRangeJust0' ) );
        $this->assertSame( '-9223372036854775809', $expected->getStringSetting( 'int64', 'OutRangeJust1' ) );
        try
        {
            $this->assertSame( '-9223372036854775809', $expected->getNumberSetting( 'int64', 'OutRangeJust1' ) );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            self::assertSame( "The expected type for the setting 'int64', 'OutRangeJust1' is 'double or integer'. The setting was of type 'string'.", $e->getMessage() );
        }
    }

    public function testTimestamp()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/empty.ini' );
        @touch( 'Configuration/tests/files/empty.ini', 1130859680 );
        $ts = $backend->getTimestamp();
        $this->assertEquals( 1130859680, $ts );
    }

    public function testTimestampNonExistingFile()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/non-existent.ini' );
        $ts = $backend->getTimestamp();
        $this->assertEquals( false, $ts );
    }

    public function testSimpleErrors()
    {
        $backend = new ezcConfigurationIniReader( 'Configuration/tests/files/simple-errors.ini' );
        try
        {
            $return = $backend->load();
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationParseErrorException $e )
        {
            $this->assertEquals( "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$' in 'Configuration/tests/files/simple-errors.ini', line '8'.", $e->getMessage() );
        }
    }

    public function testBug7855()
    {
        $path = 'Configuration/tests/files/bug7855.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->load();

        $settings = array(
            'TestSettings' => array(
                'SettingA' => 1,
                'SettingB' => 2,
            ),
        );
        $comments = array(
            'TestSettings' => array(
                'SettingB' => " This setting has no new line behind it - make sure it stays like this in this\n test file"
            ),
        );
        $expected = new ezcConfiguration( $settings, $comments );
        $this->assertEquals( $expected, $return );
    }

    /* Validation with a non-strict validator */
    public function testValidationNonStrict()
    {
        $path = 'Configuration/tests/files/simple-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( false );

        $expected = new ezcConfigurationValidationResult( $backend->getLocation(), $backend->getName(), $path );
        $expected->isValid = false;
        $item = new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 8, false, "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'", "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'" );
        $expected->appendItem( $item );

        $this->assertEquals( $expected, $return );
    }

    public function testValidationNonStrictGetResultList()
    {
        $path = 'Configuration/tests/files/simple-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( false );
        $resultList = $return->getResultList();

        $expected = array( new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 8, false, "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'", "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'" ) );
        $this->assertEquals( $expected, $resultList );
    }

    public function testValidationNonStrictGetResultList2()
    {
        $path = 'Configuration/tests/files/more-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( false );
        $resultList = $return->getResultList();

        $expected = array(
            new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 2, false, "Group ID 'Error Chars' has invalid characters", "Group ID 'Error Chars' has invalid characters" ),
            new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 3, false, "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'", "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'" ),
        );
        $this->assertEquals( $expected, $resultList );
    }

    public function testValidationNonStrictWarningErrorCount1()
    {
        $path = 'Configuration/tests/files/simple-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( false );
        $this->assertEquals( 1, $return->getErrorCount() );
        $this->assertEquals( 0, $return->getWarningCount() );
    }

    public function testValidationNonStrictWarningErrorCount2()
    {
        $path = 'Configuration/tests/files/more-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( false );
        $this->assertEquals( 2, $return->getErrorCount() );
        $this->assertEquals( 0, $return->getWarningCount() );
    }

    /* Validation with a strict validator */
    public function testValidationStrict()
    {
        $path = 'Configuration/tests/files/simple-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( true );

        $expected = new ezcConfigurationValidationResult( $backend->getLocation(), $backend->getName(), $path );
        $expected->isValid = false;
        $item = new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 8, false, "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'", "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'" );
        $expected->appendItem( $item );

        $this->assertEquals( $expected, $return );
    }

    public function testValidationStrictGetResultList()
    {
        $path = 'Configuration/tests/files/simple-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( true );
        $resultList = $return->getResultList();

        $expected = array( new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 8, false, "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'", "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'" ) );
        $this->assertEquals( $expected, $resultList );
    }

    public function testValidationStrictGetResultList2()
    {
        $path = 'Configuration/tests/files/more-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( true );
        $resultList = $return->getResultList();

        $expected = array(
            new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 2, false, "Group ID 'Error Chars' has invalid characters", "Group ID 'Error Chars' has invalid characters" ),
            new ezcConfigurationValidationItem( ezcConfigurationValidationItem::ERROR, $path, 3, false, "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'", "Invalid data: 'c8756*&%&^%&%$&C%$%C*@%C*$'" ),
        );
        $this->assertEquals( $expected, $resultList );
    }

    public function testValidationStrictWarningErrorCount1()
    {
        $path = 'Configuration/tests/files/simple-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( true );
        $this->assertEquals( 1, $return->getErrorCount() );
        $this->assertEquals( 0, $return->getWarningCount() );
    }

    public function testValidationStrictWarningErrorCount2()
    {
        $path = 'Configuration/tests/files/more-errors.ini';
        $backend = new ezcConfigurationIniReader( $path );
        $return = $backend->validate( true );
        $this->assertEquals( 2, $return->getErrorCount() );
        $this->assertEquals( 0, $return->getWarningCount() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcConfigurationIniReaderTest' );
    }

}

?>

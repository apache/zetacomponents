<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcConfigurationIniWriterTest extends ezcTestCase
{
    private $tempDir;

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'posix' ) )
        {
            $this->markTestSkipped( 'ext/posix is required for this test.' );
        }
        $this->tempDir = $this->createTempDir( 'ezcConfigurationIniWriterTest' );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testConfigSettingUseComments()
    {
        $backend = new ezcConfigurationIniWriter();
        $backend->setOptions( array ( 'useComments' => true ) );
        $backend->setOptions( array ( 'useComments' => false ) );
    }

    public function testConfigSettingUseCommentsWrongType()
    {
        $backend = new ezcConfigurationIniWriter();
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

    public function testConfigSettingPermissions()
    {
        $backend = new ezcConfigurationIniWriter();
        $backend->setOptions( array ( 'permissions' => 0660 ) );
    }

    public function testConfigSettingPermissionsWrongType()
    {
        $backend = new ezcConfigurationIniWriter();
        try
        {
            $backend->setOptions( array ( 'permissions' => 'tests/translations' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingValueException $e )
        {
            self::assertEquals( "The value 'tests/translations' that you were trying to assign to setting 'permissions' is invalid. Allowed values are: int, 0 - 0777", $e->getMessage() );
        }
    }

    public function testConfigSettingPermissionsOutOfRange1()
    {
        $backend = new ezcConfigurationIniWriter();
        try
        {
            $backend->setOptions( array ( 'permissions' => -1 ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingValueException $e )
        {
            self::assertEquals( "The value '-1' that you were trying to assign to setting 'permissions' is invalid. Allowed values are: int, 0 - 0777", $e->getMessage() );
        }
    }

    public function testConfigSettingPermissionsOutOfRange2()
    {
        $backend = new ezcConfigurationIniWriter();
        try
        {
            $backend->setOptions( array ( 'permissions' => 01000 ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingValueException $e )
        {
            self::assertEquals( "The value '512' that you were trying to assign to setting 'permissions' is invalid. Allowed values are: int, 0 - 0777", $e->getMessage() );
        }
    }

    public function testGetOptions()
    {
        $backend = new ezcConfigurationIniWriter();
        $backend->setOptions( array ( 'useComments' => true, 'permissions' => 0600 ) );
        $this->assertEquals( array ( 'useComments' => true, 'permissions' => 0600 ), $backend->getOptions() );
    }

    public function testConfigSettingBroken()
    {
        $backend = new ezcConfigurationIniWriter();
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
        $backend = new ezcConfigurationIniWriter( 'files/write_basic.ini', new ezcConfiguration() );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'write_basic', $backend->getName() );
        $this->assertSame( 0666, $this->readAttribute( $backend, 'permissions' ) );
    }

    public function testInitCtor2()
    {
        $backend = new ezcConfigurationIniWriter( 'files.foo/write_basic.ini', new ezcConfiguration(), 0660 );
        $this->assertEquals( 'files.foo', $backend->getLocation() );
        $this->assertEquals( 'write_basic', $backend->getName() );
        $this->assertSame( 0660, $this->readAttribute( $backend, 'permissions' ) );
    }

    public function testInitCtor3()
    {
        try
        {
            $backend = new ezcConfigurationIniWriter( 'files.foo/basic.f', new ezcConfiguration() );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcConfigurationInvalidSuffixException $e )
        {
            $this->assertEquals( "The path 'files.foo/basic.f' has an invalid suffix (should be '.ini').", $e->getMessage() );
        }
    }

    public function testInitMethod1()
    {
        $backend = new ezcConfigurationIniWriter();
        $backend->init( 'files', 'write_basic', new ezcConfiguration() );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'write_basic', $backend->getName() );
    }

    public function testNoConfigObjectToSafe()
    {
        try
        {
            $backend = new ezcConfigurationIniWriter();
            $backend->save();
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcConfigurationNoConfigObjectException $e )
        {
            $this->assertEquals( 'There is no config object to save.', $e->getMessage() );
        }
    }

    public function testEmptyFile()
    {
        $test = new ezcConfiguration();

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/empty.ini', $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/empty.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function testBrokenLocation()
    {
        $test = new ezcConfiguration();

        $backend = new ezcConfigurationIniWriter( 'does-definitely-not-exist/empty.ini', $test );
        try
        {
            @$backend->save();
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcConfigurationWriteFailedException $e )
        {
            $this->assertEquals( "The file could not be stored in 'does-definitely-not-exist/empty.ini'.", $e->getMessage() );
        }
    }

    public function testOneGroup()
    {
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
        $test = new ezcConfiguration( $settings, $comments );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/one-group.ini', $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/one-group.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function testOneGroupWithSetConfig()
    {
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
        $test = new ezcConfiguration( $settings, $comments );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/one-group.ini', new ezcConfiguration() );
        $backend->setConfig( $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/one-group.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function testOneGroupNoComments()
    {
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
        $test = new ezcConfiguration( $settings, $comments );
        $expected = new ezcConfiguration( $settings, array() );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/one-group-no-comments.ini', $test );
        $backend->setOptions( array ( 'useComments' => false ) );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/one-group-no-comments.ini' );
        $return = $backend->load();
        $this->assertEquals( $expected, $return );
    }

    public function testTwoGroups()
    {
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
        $test = new ezcConfiguration( $settings, $comments );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/two-groups.ini', $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/two-groups.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function testFormats()
    {
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
        $test = new ezcConfiguration( $settings, $comments );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/formats.ini', $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/formats.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function test2D()
    {
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
        $test = new ezcConfiguration( $settings, $comments );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/multi-dim.ini', $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/multi-dim.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function test3D()
    {
        $settings = array(
            '3D' => array(
                'Decimal' => array( 42, 0 ),
                'Array' =>  array(
                    'Decimal' => array( 'a' => 42, 'b' => 0 ),
                    'Mixed' => array( 'b' => false, 2 => "Derick \"Tiger\" Rethans" ),
                ),
            ),
        );
        $comments = array(
            '3D' => array(
                'Decimal' => array( " One with a comment", " Second one with a comment" ),
                'Array' => array(
                    'Mixed' => array( 2 => " One with a comment" ),
                ),
            ),
        );
        $test = new ezcConfiguration( $settings, $comments );

        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/multi-dim2.ini', $test );
        $backend->save();

        $backend = new ezcConfigurationIniReader( $this->tempDir . '/multi-dim2.ini' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function testFilePermissionsDefault()
    {
        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/empty.ini', new ezcConfiguration() );
        $oldUmask = umask( 0 );
        $backend->save();
        umask( $oldUmask );
        $stat = stat( $this->tempDir . '/empty.ini' );
        $this->assertEquals( POSIX_S_IFREG | 0666, $stat['mode'] );
    }

    public function testFilePermissions1()
    {
        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/empty.ini', new ezcConfiguration() );
        $oldUmask = umask( 0 );
        $backend->setOptions( array ( 'permissions' => 0660 ) );
        $backend->save();
        umask( $oldUmask );
        $stat = stat( $this->tempDir . '/empty.ini' );
        $this->assertEquals( POSIX_S_IFREG | 0660, $stat['mode'] );
    }

    public function testFilePermissions2()
    {
        $backend = new ezcConfigurationIniWriter( $this->tempDir . '/empty.ini', new ezcConfiguration() );
        $oldUmask = umask( 0 );
        $backend->setOptions( array ( 'permissions' => 0640 ) );
        $backend->save();
        umask( $oldUmask );
        $stat = stat( $this->tempDir . '/empty.ini' );
        $this->assertEquals( POSIX_S_IFREG | 0640, $stat['mode'] );
    }

/*
    public function testWriteFailure()
    {
    }
*/

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcConfigurationIniWriterTest' );
    }

}

?>

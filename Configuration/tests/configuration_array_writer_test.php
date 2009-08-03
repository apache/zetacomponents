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
class ezcConfigurationArrayWriterTest extends ezcTestCase
{
    private $tempDir;

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'posix' ) )
        {
            $this->markTestSkipped( 'ext/posix is required for this test.' );
        }
        $this->tempDir = $this->createTempDir( 'ezcConfigurationArrayWriterTest' );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testConfigSettingUseComments()
    {
        $backend = new ezcConfigurationArrayWriter();
        $backend->setOptions( array ( 'useComments' => true ) );
        $backend->setOptions( array ( 'useComments' => false ) );
    }

    public function testConfigSettingUseCommentsWrongType()
    {
        $backend = new ezcConfigurationArrayWriter();
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
        $backend = new ezcConfigurationArrayWriter();
        $backend->setOptions( array ( 'permissions' => 0660 ) );
    }

    public function testConfigSettingPermissionsWrongType()
    {
        $backend = new ezcConfigurationArrayWriter();
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
        $backend = new ezcConfigurationArrayWriter();
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
        $backend = new ezcConfigurationArrayWriter();
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
        $backend = new ezcConfigurationArrayWriter();
        $backend->setOptions( array ( 'useComments' => true, 'permissions' => 0600 ) );
        $this->assertEquals( array ( 'useComments' => true, 'permissions' => 0600 ), $backend->getOptions() );
    }

    public function testConfigSettingBroken()
    {
        $backend = new ezcConfigurationArrayWriter();
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
        $backend = new ezcConfigurationArrayWriter( 'files/write_basic.php', new ezcConfiguration() );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'write_basic', $backend->getName() );
        $this->assertSame( 0666, $this->readAttribute( $backend, 'permissions' ) );
    }

    public function testInitCtor2()
    {
        $backend = new ezcConfigurationArrayWriter( 'files.foo/write_basic.php', new ezcConfiguration(), 0660 );
        $this->assertEquals( 'files.foo', $backend->getLocation() );
        $this->assertEquals( 'write_basic', $backend->getName() );
        $this->assertSame( 0660, $this->readAttribute( $backend, 'permissions' ) );
    }

    public function testInitCtor3()
    {
        try
        {
            $backend = new ezcConfigurationArrayWriter( 'files.foo/basic.f', new ezcConfiguration() );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcConfigurationInvalidSuffixException $e )
        {
            $this->assertEquals( "The path 'files.foo/basic.f' has an invalid suffix (should be '.php').", $e->getMessage() );
        }
    }

    public function testInitMethod1()
    {
        $backend = new ezcConfigurationArrayWriter();
        $backend->init( 'files', 'write_basic', new ezcConfiguration() );
        $this->assertEquals( 'files', $backend->getLocation() );
        $this->assertEquals( 'write_basic', $backend->getName() );
    }

    public function testNoConfigObjectToSafe()
    {
        try
        {
            $backend = new ezcConfigurationArrayWriter();
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/empty.php', $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/empty.php' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/one-group.php', $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/one-group.php' );
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/one-group.php', new ezcConfiguration() );
        $backend->setConfig( $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/one-group.php' );
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/one-group-no-comments.php', $test );
        $backend->setOptions( array ( 'useComments' => false ) );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/one-group-no-comments.php' );
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/two-groups.php', $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/two-groups.php' );
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
                'Float3' => 314e-2,
                'Float4' => 3.141592654e1,
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/formats.php', $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/formats.php' );
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/multi-dim.php', $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/multi-dim.php' );
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

        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/multi-dim2.php', $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $this->tempDir . '/multi-dim2.php' );
        $return = $backend->load();
        $this->assertEquals( $test, $return );
    }

    public function testFilePermissionsDefault()
    {
        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/empty.php', new ezcConfiguration() );
        $oldUmask = umask( 0 );
        $backend->save();
        umask( $oldUmask );
        $stat = stat( $this->tempDir . '/empty.php' );
        $this->assertEquals( POSIX_S_IFREG | 0666, $stat['mode'] );
    }

    public function testFilePermissions1()
    {
        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/empty.php', new ezcConfiguration() );
        $oldUmask = umask( 0 );
        $backend->setOptions( array ( 'permissions' => 0660 ) );
        $backend->save();
        umask( $oldUmask );
        $stat = stat( $this->tempDir . '/empty.php' );
        $this->assertEquals( POSIX_S_IFREG | 0660, $stat['mode'] );
    }

    public function testFilePermissions2()
    {
        $backend = new ezcConfigurationArrayWriter( $this->tempDir . '/empty.php', new ezcConfiguration() );
        $oldUmask = umask( 0 );
        $backend->setOptions( array ( 'permissions' => 0640 ) );
        $backend->save();
        umask( $oldUmask );
        $stat = stat( $this->tempDir . '/empty.php' );
        $this->assertEquals( POSIX_S_IFREG | 0640, $stat['mode'] );
    }

    public function testValidationNonStrict()
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

        $path = $this->tempDir . '/multi-dim2.php';
        $backend = new ezcConfigurationArrayWriter( $path, $test );
        $backend->save();

        $backend = new ezcConfigurationArrayReader( $path );
        $return = $backend->validate( false );

        $expected = new ezcConfigurationValidationResult( $backend->getLocation(), $backend->getName(), $path );
        $expected->isValid = true;

        $this->assertEquals( $expected, $return );
    }

/*
    public function testWriteFailure()
    {
    }
*/

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcConfigurationArrayWriterTest' );
    }

}

?>

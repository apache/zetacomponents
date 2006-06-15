<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
class ezcConfigurationManagerTest extends ezcTestCase
{
    // This test needs to be at the start, as the other tests already init the
    // configuration manager 
    public function testForgottenInit()
    {
        $config = ezcConfigurationManager::getInstance();

        try
        {
            $setting = $config->getSetting( 'types', 'Types', 'Bool' );
            $this->fail( "Expected exception not thrown" );
        }
        catch ( ezcConfigurationManagerNotInitializedException $e )
        {
            $this->assertEquals( "The manager has not been initialized.", $e->getMessage() );
        }
    }

    public function testInit()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'files', array() );

        $this->assertSame( 'ezcConfigurationIniReader', $this->getNonPublicProperty( $config, 'readerClass' ) );
        $this->assertSame( 'files', $this->getNonPublicProperty( $config, 'location' ) );
        $this->assertSame( array(), $this->getNonPublicProperty( $config, 'options' ) );
    }

    public function testInitClassWrongInterface()
    {
        $config = ezcConfigurationManager::getInstance();
        try
        {
            $config->init( 'stdClass', 'files', array() );
            $this->fail( "Expected exception not thrown" );
        }
        catch ( ezcConfigurationInvalidReaderClassException $e )
        {
            $this->assertEquals( "Class <stdClass> does not exist, or does not implement the <ezcConfigurationReader> interface.", $e->getMessage() );
        }
    }

    public function testInitNonExistingClass()
    {
        $config = ezcConfigurationManager::getInstance();
        try
        {
            @$config->init( 'DoesNotExist', 'files', array() );
            $this->fail( "Expected exception not thrown" );
        }
        catch ( ezcConfigurationInvalidReaderClassException $e )
        {
            $this->assertEquals( "Class <DoesNotExist> does not exist, or does not implement the <ezcConfigurationReader> interface.", $e->getMessage() );
        }
    }

    public function testHasSetting()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        $setting = $config->hasSetting( 'one-group', 'TheOnlyGroup', 'Setting1' );
        $this->assertEquals( true, $setting );

        $setting = $config->hasSetting( 'one-group', 'TheOnlyGroup', 'NotThere' );
        $this->assertEquals( false, $setting );
    }

    public function testExists()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        $setting = $config->exists( 'one-group' );
        $this->assertEquals( true, $setting );

        $setting = $config->exists( 'not-there' );
        $this->assertEquals( false, $setting );
    }

    public function testHasSettingNotExists()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        try
        {
            $setting = $config->hasSetting( 'not-there', 'TheOnlyGroup', 'NotThere' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationUnknownConfigException $e )
        {
            $this->assertEquals( "The configuration <not-there> does not exist.", $e->getMessage() );
        }
    }

    public function testSetting1()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );
        $hasSetting = $config->hasSetting( 'one-group', 'TheOnlyGroup', 'Setting1' );
        $setting = $config->getSetting( 'one-group', 'TheOnlyGroup', 'Setting1' );
        $this->assertEquals( true, $setting );
    }

    public function testSetting2()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        $setting = $config->getSetting( 'types', 'Types', 'Bool' );
        $this->assertEquals( true, $setting );

        $setting = $config->getSetting( 'types', 'Types', 'Float' );
        $this->assertEquals( 3.14, $setting );

        $setting = $config->getSetting( 'types', 'Types', 'Int' );
        $this->assertEquals( 42, $setting );

        $setting = $config->getSetting( 'types', 'Types', 'String' );
        $this->assertEquals( 'Components', $setting );

        $setting = $config->getSetting( 'types', 'Types', 'Array' );
        $this->assertEquals( array( 1 => 'Een', 2 => 'Twee'), $setting );
    }

    public function testSetting3()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        $setting = $config->getBoolSetting( 'types', 'Types', 'Bool' );
        $this->assertEquals( true, $setting );

        $setting = $config->getNumberSetting( 'types', 'Types', 'Float' );
        $this->assertEquals( 3.14, $setting );

        $setting = $config->getNumberSetting( 'types', 'Types', 'Int' );
        $this->assertEquals( 42, $setting );

        $setting = $config->getStringSetting( 'types', 'Types', 'String' );
        $this->assertEquals( 'Components', $setting );

        $setting = $config->getArraySetting( 'types', 'Types', 'Array' );
        $this->assertEquals( array( 1 => 'Een', 2 => 'Twee' ), $setting );
    }

    public function testSettingWrongType()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        try
        {
            $config->getNumberSetting( 'types', 'Types', 'Bool' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            $this->assertEquals( "The expected type for the setting <Types>, <Bool> is <double or integer>. The setting was of type <boolean>.", $e->getMessage() );
        }

        try
        {
            $setting = $config->getBoolSetting( 'types', 'Types', 'Float' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            $this->assertEquals( "The expected type for the setting <Types>, <Float> is <boolean>. The setting was of type <double>.", $e->getMessage() );
        }

        try
        {
            $setting = $config->getStringSetting( 'types', 'Types', 'Int' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            $this->assertEquals( "The expected type for the setting <Types>, <Int> is <string>. The setting was of type <integer>.", $e->getMessage() );
        }

        try
        {
            $setting = $config->getArraySetting( 'types', 'Types', 'String' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            $this->assertEquals( "The expected type for the setting <Types>, <String> is <array>. The setting was of type <string>.", $e->getMessage() );
        }

        try
        {
            $setting = $config->getNumberSetting( 'types', 'Types', 'Array' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationSettingWrongTypeException $e )
        {
            $this->assertEquals( "The expected type for the setting <Types>, <Array> is <double or integer>. The setting was of type <array>.", $e->getMessage() );
        }
    }

    public function testSettingWrongGroup()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        try
        {
            $config->getNumberSetting( 'types', 'NonExistingGroup', 'Bool' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcConfigurationUnknownGroupException $e )
        {
            $this->assertEquals( "The settings group <NonExistingGroup> does not exist.", $e->getMessage() );
        }
    }

    public function testSettings()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        $settings = $config->getSettings( 'types', 'Types', array( 'Bool', 'Float', 'Int', 'String', 'Array' ) );
        $expected = array( 'Bool' => true, 'Float' => 3.14, 'Int' => 42, 'String' => 'Components', 'Array' => array( 1 => 'Een', 2 => 'Twee' ) );
        $this->assertEquals( $expected, $settings );
    }

    public function testSettingsAsList()
    {
        $config = ezcConfigurationManager::getInstance();
        $config->init( 'ezcConfigurationIniReader', 'Configuration/tests/files', array() );

        $settings = $config->getSettingsAsList( 'types', 'Types', array( 'Bool', 'Float', 'Int', 'String', 'Array' ) );
        $expected = array( true, 3.14, 42, 'Components', array( 1 => 'Een', 2 => 'Twee' ) );
        $this->assertEquals( $expected, $settings );
    }

    public static function suite()
    {
         return new ezcTestSuite( 'ezcConfigurationManagerTest' );
    }
}

?>

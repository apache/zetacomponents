<?php
/**
 * Basic test cases for the memory backend.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Custom classes to test inheritence. 
 */
require_once 'classes/foo_custom_classes.php';

/**
 * Tests for ezcWebdavServerConfigurationManager class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavServerConfigurationManagerTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtor()
    {
        $dp = new ezcWebdavServerConfigurationManager();

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
    }
    
    public function testInsertBeforeSuccess()
    {
        $dp = new ezcWebdavServerConfigurationManager();

        $firstCfg = new ezcWebdavServerConfiguration();
        $secondCfg = new ezcWebdavServerConfiguration(
            '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
            'ezcWebdavMicrosoftCompatibleTransport'
        );
        $thirdCfg = new ezcWebdavServerConfiguration(
            '(Konqueror)i',
            'ezcWebdavKonquerorCompatibleTransport'
        );
        $fourthCfg = new ezcWebdavServerConfiguration(
            '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
            'ezcWebdavTransport',
            'ezcWebdavXmlTool',
            'ezcWebdavNautilusPropertyHandler'
        );

        $this->assertAttributeEquals(
            array(
                0 => $secondCfg,
                1 => $fourthCfg,
                2 => $thirdCfg,
                3 => $firstCfg,
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
        
        $fifthCfg = new ezcWebdavServerConfiguration(
            'fooregex'
        );

        $dp->insertBefore( $fifthCfg );

        $this->assertAttributeEquals(
            array(
                0 => $fifthCfg,
                1 => $secondCfg,
                2 => $fourthCfg,
                3 => $thirdCfg,
                4 => $firstCfg,
            ),
            'configurations',
            $dp,
            'Third transport not added correctly.'
        );

        $sixthCfg = new ezcWebdavServerConfiguration(
            'barregex'
        );

        $dp->insertBefore( $sixthCfg, 1 );

        $this->assertAttributeEquals(
            array(
                0 => $fifthCfg,
                1 => $sixthCfg,
                2 => $secondCfg,
                3 => $fourthCfg,
                4 => $thirdCfg,
                5 => $firstCfg,
            ),
            'configurations',
            $dp,
            'Fourth transport not added correctly.'
        );

        $dp->insertBefore( $thirdCfg );

        $this->assertAttributeEquals(
            array(
                0 => $thirdCfg,
                1 => $fifthCfg,
                2 => $sixthCfg,
                3 => $secondCfg,
                4 => $fourthCfg,
                5 => $thirdCfg,
                6 => $firstCfg,
            ),
            'configurations',
            $dp,
            'Third transport not added correctly, again.'
        );
    }
    
    public function testInsertBeforeFailure()
    {
        $dp = new ezcWebdavServerConfigurationManager();

        $firstCfg = new ezcWebdavServerConfiguration();

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
        
        $secondCfg = new ezcWebdavServerConfiguration(
            'fooregex'
        );

        try
        {
            $dp->insertBefore( $secondCfg, 'foo' );
            $this->fail( 'ezcBaseValueException not thrown on string $offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        try
        {
            $dp->insertBefore( $secondCfg, -23 );
            $this->fail( 'ezcBaseValueException not thrown on negative int $offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        try
        {
            $dp->insertBefore( $secondCfg, 42 );
            $this->fail( 'ezcBaseValueException not thrown on wide to large int $offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        try
        {
            $dp->insertBefore( $secondCfg, 4 );
            $this->fail( 'ezcBaseValueException not thrown on to large int $offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
    }

    public function testCreateTransportDefaultCtorSuccess()
    {
        $dp = new ezcWebdavServerConfigurationManager();

        $dp->configure( ezcWebdavServer::getInstance(), '' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport
        );

        $dp->configure( ezcWebdavServer::getInstance(), 'Foo' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport
        );

        $dp->configure( ezcWebdavServer::getInstance(), 'Nautilus' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport
        );
    }

    public function testCreateTransportMultipleConfigsSuccess()
    {
        $dp = new ezcWebdavServerConfigurationManager();

        $ms = new ezcWebdavServerConfiguration( '(^.*micro\\$oft.*$)i' );
        $gn = new ezcWebdavServerConfiguration( '(^.*nautilus.*$)i', 'fooCustomTransport' );
        $kd = new ezcWebdavServerConfiguration( '(^.*konqueror.*$)i' );
        $ca = new ezcWebdavServerConfiguration( '(^.*cadaver.*$)i' );
        
        $dp->insertBefore( $ms, 0 );
        $dp->insertBefore( $gn, 0 );
        $dp->insertBefore( $kd, 0 );
        $dp->insertBefore( $ca, 0 );

        $dp->configure( ezcWebdavServer::getInstance(), '' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport,
            'Default transport not created on none-matching User-Agent.'
        );

        $dp->configure( ezcWebdavServer::getInstance(), 'Mirco$soft Internet Explorer 66.6beta1' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport,
            'Transport not correctly selected, $ms'
        );

        $dp->configure( ezcWebdavServer::getInstance(), 'Gentoo-2.6.22-r8, Gnome 2.18.2-rc2, Nautilus' );
        $this->assertEquals(
            new fooCustomTransport(),
            ezcWebdavServer::getInstance()->transport,
            'Transport not correctly selected, $gn'
        );

        $dp->configure( ezcWebdavServer::getInstance(), 'Gentoo-2.6.22-r8, KDE Foo Bar, Konqueror-X.Y.Z, libneon-a.b.c-alpha23' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport,
            'Transport not correctly selected, $kd'
        );
    }

    public function testCreateTransportFailure()
    {
        $dp = new ezcWebdavServerConfigurationManager();
        unset( $dp[0] );
        unset( $dp[0] );
        unset( $dp[0] );
        unset( $dp[0] );

        try
        {
            $dp->configure( ezcWebdavServer::getInstance(), 'Fooo Bar' );
            $this->fail( 'Creating transport does not fail without any configs.' );
        }
        catch ( ezcWebdavMissingTransportConfigurationException $e ) {}

        $unmatching = new ezcWebdavServerConfiguration( '(^.*micro\$oft.*)i' );

        $dp[] = $unmatching;

        try
        {
            $dp->configure( ezcWebdavServer::getInstance(), 'Fooo Bar' );
            $this->fail( 'Creating transport does not fail without any configs.' );
        }
        catch ( ezcWebdavMissingTransportConfigurationException $e ) {}

        $dp->configure( ezcWebdavServer::getInstance(), 'some MiCrO$OfT client' );
        $this->assertEquals(
            new ezcWebdavTransport(),
            ezcWebdavServer::getInstance()->transport,
            'Transport not created correctly with match.'
        );
    }

    public function testOffsetSetSuccess()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new ezcWebdavServerConfiguration( '(b)' );

        $dp      = new ezcWebdavServerConfigurationManager();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
                4 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $dp[0]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => $second,
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
                4 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetSetFailure()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavServerConfigurationManager();

        try
        {
            $dp[5]   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with too large offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configuration not added incorrectly through offsetSet().'
        );

        try
        {
            $dp[-2]   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with too small offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations added in-correctly through offsetSet().'
        );

        try
        {
            $dp['foo']   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations added in-correctly through offsetSet().'
        );
        
        try
        {
            $dp[]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and null offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations added in-correctly through offsetSet().'
        );
        
        try
        {
            $dp[]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and null offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations added in-correctly through offsetSet().'
        );
        
        try
        {
            $dp[0]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and 0 offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations added in-correctly through offsetSet().'
        );
        
        try
        {
            $dp[1]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and 1 offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetGetSuccess()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new ezcWebdavServerConfiguration( '(b)' );

        $dp      = new ezcWebdavServerConfigurationManager();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
                4 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $this->assertEquals(
            new ezcWebdavServerConfiguration(
                '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                'ezcWebdavMicrosoftCompatibleTransport'
            ),
            $dp[0],
            'Index 0 not got correctly.'
        );

        $this->assertSame(
            $first,
            $dp[1],
            'Index 1 not got correctly.'
        );

        $this->assertEquals(
            new ezcWebdavServerConfiguration(
                '(Konqueror)i',
                'ezcWebdavKonquerorCompatibleTransport'
            ),
            $dp[2],
            'Index 2 not got correctly.'
        );

        $this->assertEquals(
            new ezcWebdavServerConfiguration(),
            $dp[3],
            'Index 2 not got correctly.'
        );

        $this->assertSame(
            $second,
            $dp[4],
            'Index 3 not got correctly.'
        );
    }

    public function testOffsetGetFailure()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavServerConfigurationManager();

        $this->assertNull(
            $dp[4],
            'Offset 4 not null.'
        );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configuration changed on too large offset.'
        );

        try
        {
            echo $dp[-2];
            $this->fail( 'ezcBaseValueException not thrown on get access with too small offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configuration changed on negative offset.'
        );

        try
        {
            echo $dp['foo'];
            $this->fail( 'ezcBaseValueException not thrown on get access with invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configuration changed on string offset.'
        );
    }

    public function testOffsetUnsetSuccess()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new ezcWebdavServerConfiguration( '(b)' );

        $dp      = new ezcWebdavServerConfigurationManager();
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations not created correctly in ctor.'
        );

        $dp[1]   = $first;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet(1).'
        );
        
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
                4 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet(null).'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                2 => new ezcWebdavServerConfiguration(),
                3 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(),
                2 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
            ),
            'configurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[0] );
        
        $this->assertAttributeEquals(
            array(
            ),
            'configurations',
            $dp,
            'Configurations not removed from offset 0 correctly through offsetUnset().'
        );
    }

    public function testOffsetUnsetFailure()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavServerConfigurationManager();

        unset( $dp[3] );
        $this->assertNull(
            $dp[3],
            'Offset 3 not null.'
        );
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        try
        {
            unset( $dp[-2] );
            $this->fail( 'ezcBaseValueException not thrown on unset access with too small offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        try
        {
            unset( $dp['foo'] );
            $this->fail( 'ezcBaseValueException not thrown on unset access with invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetExistsSuccess()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new ezcWebdavServerConfiguration( '(b)' );

        $dp      = new ezcWebdavServerConfigurationManager();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
                4 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $this->assertTrue(
            isset( $dp[0] ),
            'Offset 0 does not seem to be set.'
        );
        $this->assertTrue(
            isset( $dp[1] ),
            'Offset 1 does not seem to be set.'
        );
        $this->assertTrue(
            isset( $dp[2] ),
            'Offset 2 does not seem to be set.'
        );
        $this->assertTrue(
            isset( $dp[3] ),
            'Offset 3 does not seem to be set.'
        );
        $this->assertTrue(
            isset( $dp[4] ),
            'Offset 4 does not seem to be set.'
        );
    }

    public function testOffsetExistsFailure()
    {
        $first   = new ezcWebdavServerConfiguration( '(a)' );
        $second  = new ezcWebdavServerConfiguration( '(b)' );

        $dp      = new ezcWebdavServerConfigurationManager();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
                4 => $second,
            ),
            'configurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $this->assertFalse(
            isset( $dp[-1] ),
            'Offset -1 does seem to be set.'
        );
        $this->assertFalse(
            isset( $dp[5] ),
            'Offset 3 does seem to be set.'
        );
        $this->assertFalse(
            isset( $dp['foo'] ),
            'Offset "foo" does seem to be set.'
        );
    }

    public function testIteratorDefaultCtor()
    {
        $dp = new ezcWebdavServerConfigurationManager();

        $fake = array(
                0 => new ezcWebdavServerConfiguration(
                    '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavServerConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavServerConfiguration(
                    '(Konqueror)i',
                    'ezcWebdavKonquerorCompatibleTransport'
                ),
                3 => new ezcWebdavServerConfiguration(),
        );
        
        $i = 0;
        foreach( $dp as $key => $val )
        {
            $this->assertEquals(
                $i,
                $key,
                "ID missmatch during iteration"
            );
            $this->assertTrue(
                isset( $fake[$key] ),
                "Fake key '$key' not set"
            );
            $this->assertEquals(
                $fake[$key],
                $val,
                'Value missmatch'
            );
            ++$i;
        }

        // Try if rewind works
        $i = 0;
        foreach( $dp as $key => $val )
        {
            $this->assertEquals(
                $i,
                $key,
                "ID missmatch during iteration"
            );
            $this->assertTrue(
                isset( $fake[$key] ),
                "Fake key '$key' not set"
            );
            $this->assertEquals(
                $fake[$key],
                $val,
                'Value missmatch'
            );
            ++$i;
        }
    }

    public function testIteratorMultipleElements()
    {
        $dp   = new ezcWebdavServerConfigurationManager();
        $dp[] = new ezcWebdavServerConfiguration( '(.*nautilus.*)i' );
        $dp[] = new ezcWebdavServerConfiguration( '(.*konqueror.*)i' );

        $fake = array(
            0 => new ezcWebdavServerConfiguration(
                '(Microsoft\s+Data\s+Access|MSIE|MiniRedir)i',
                'ezcWebdavMicrosoftCompatibleTransport'
            ),
            1 => new ezcWebdavServerConfiguration(
                '(gnome-vfs/[0-9.]+ neon/[0-9.]*|gvfs/[0-9.]+)i',
                'ezcWebdavTransport',
                'ezcWebdavXmlTool',
                'ezcWebdavNautilusPropertyHandler'
            ),
            2 => new ezcWebdavServerConfiguration(
                '(Konqueror)i',
                'ezcWebdavKonquerorCompatibleTransport'
            ),
            3 => new ezcWebdavServerConfiguration(),
            4 => new ezcWebdavServerConfiguration( '(.*nautilus.*)i' ),
            5 => new ezcWebdavServerConfiguration( '(.*konqueror.*)i' ),
        );
        
        $i = 0;
        foreach( $dp as $key => $val )
        {
            $this->assertEquals(
                $i,
                $key,
                "ID missmatch during iteration"
            );
            $this->assertTrue(
                isset( $fake[$key] ),
                "Fake key '$key' not set"
            );
            $this->assertEquals(
                $fake[$key],
                $val,
                'Value missmatch'
            );
            ++$i;
        }

        // Try if rewind works
        $i = 0;
        foreach( $dp as $key => $val )
        {
            $this->assertEquals(
                $i,
                $key,
                "ID missmatch during iteration"
            );
            $this->assertTrue(
                isset( $fake[$key] ),
                "Fake key '$key' not set"
            );
            $this->assertEquals(
                $fake[$key],
                $val,
                'Value missmatch'
            );
            ++$i;
        }
    }

    public function testIteratorEmpty()
    {
        $dp   = new ezcWebdavServerConfigurationManager();
        unset( $dp[0] );
        unset( $dp[0] );
        unset( $dp[0] );
        unset( $dp[0] );

        $fake = array();
        
        $i = 0;
        foreach( $dp as $key => $val )
        {
            $this->assertEquals(
                $i,
                $key,
                "ID missmatch during iteration"
            );
            $this->assertTrue(
                isset( $fake[$key] ),
                "Fake key '$key' not set"
            );
            $this->assertEquals(
                $fake[$key],
                $val,
                'Value missmatch'
            );
            ++$i;
        }

        // Try if rewind works
        $i = 0;
        foreach( $dp as $key => $val )
        {
            $this->assertEquals(
                $i,
                $key,
                "ID missmatch during iteration"
            );
            $this->assertTrue(
                isset( $fake[$key] ),
                "Fake key '$key' not set"
            );
            $this->assertEquals(
                $fake[$key],
                $val,
                'Value missmatch'
            );
            ++$i;
        }
    }
}

?>

<?php
/**
 * Basic test cases for the memory backend.
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
require_once 'test_case.php';

/**
 * Custom classes to test inheritence. 
 */
require_once 'classes/foo_custom_classes.php';

/**
 * Tests for ezcWebdavTransportDispatcher class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavTransportDispatcherTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtor()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
    }
    
    public function testInsertBeforeSuccess()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $firstCfg = new ezcWebdavTransportConfiguration();
        $secondCfg = new ezcWebdavTransportConfiguration(
            '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
            'ezcWebdavMicrosoftCompatibleTransport'
        );
        $thirdCfg = new ezcWebdavTransportConfiguration(
            '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
            'ezcWebdavTransport',
            'ezcWebdavXmlTool',
            'ezcWebdavNautilusPropertyHandler'
        );

        $this->assertAttributeEquals(
            array(
                0 => $secondCfg,
                1 => $thirdCfg,
                2 => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
        
        $fourthCfg = new ezcWebdavTransportConfiguration(
            'fooregex'
        );

        $dp->insertBefore( $fourthCfg );

        $this->assertAttributeEquals(
            array(
                0 => $fourthCfg,
                1 => $secondCfg,
                2 => $thirdCfg,
                3 => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Third transport not added correctly.'
        );

        $fifthCfg = new ezcWebdavTransportConfiguration(
            'barregex'
        );

        $dp->insertBefore( $fifthCfg, 1 );

        $this->assertAttributeEquals(
            array(
                0 => $fourthCfg,
                1 => $fifthCfg,
                2 => $secondCfg,
                3 => $thirdCfg,
                4 => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Fourth transport not added correctly.'
        );

        $dp->insertBefore( $thirdCfg );

        $this->assertAttributeEquals(
            array(
                0 => $thirdCfg,
                1 => $fourthCfg,
                2 => $fifthCfg,
                3 => $secondCfg,
                4 => $thirdCfg,
                5 => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Third transport not added correctly, again.'
        );
    }
    
    public function testInsertBeforeFailure()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $firstCfg = new ezcWebdavTransportConfiguration();

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
        
        $secondCfg = new ezcWebdavTransportConfiguration(
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        try
        {
            $dp->insertBefore( $secondCfg, 3 );
            $this->fail( 'ezcBaseValueException not thrown on to large int $offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
    }

    public function testCreateTransportDefaultCtorSuccess()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( '' )
        );

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( 'Foo' )
        );

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( 'Nautilus' )
        );
    }

    public function testCreateTransportMultipleConfigsSuccess()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $ms = new ezcWebdavTransportConfiguration( '(^.*micro\\$oft.*$)i' );
        $gn = new ezcWebdavTransportConfiguration( '(^.*nautilus.*$)i', 'fooCustomTransport' );
        $kd = new ezcWebdavTransportConfiguration( '(^.*konqueror.*$)i' );
        $ca = new ezcWebdavTransportConfiguration( '(^.*cadaver.*$)i' );
        
        $dp->insertBefore( $ms, 0 );
        $dp->insertBefore( $gn, 0 );
        $dp->insertBefore( $kd, 0 );
        $dp->insertBefore( $ca, 0 );

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( '' ),
            'Default transport not created on none-matching User-Agent.'
        );

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( 'Mirco$soft Internet Explorer 66.6beta1' ),
            'Transport not correctly selected, $ms'
        );

        $this->assertEquals(
            new fooCustomTransport(),
            $dp->createTransport( 'Gentoo-2.6.22-r8, Gnome 2.18.2-rc2, Nautilus' ),
            'Transport not correctly selected, $gn'
        );

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( 'Gentoo-2.6.22-r8, KDE Foo Bar, Konqueror-X.Y.Z, libneon-a.b.c-alpha23' ),
            'Transport not correctly selected, $kd'
        );
    }

    public function testCreateTransportFailure()
    {
        $dp = new ezcWebdavTransportDispatcher();
        unset( $dp[0] );
        unset( $dp[0] );
        unset( $dp[0] );

        try
        {
            $dp->createTransport( 'Fooo Bar' );
            $this->fail( 'Creating transport does not fail without any configs.' );
        }
        catch ( ezcWebdavMissingTransportConfigurationException $e ) {}

        $unmatching = new ezcWebdavTransportConfiguration( '(^.*micro\$oft.*)i' );

        $dp[] = $unmatching;

        try
        {
            $dp->createTransport( 'Fooo Bar' );
            $this->fail( 'Creating transport does not fail without any configs.' );
        }
        catch ( ezcWebdavMissingTransportConfigurationException $e ) {}

        $this->assertEquals(
            new ezcWebdavTransport(),
            $dp->createTransport( 'some MiCrO$OfT client' ),
            'Transport not created correctly with match.'
        );
    }

    public function testOffsetSetSuccess()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new ezcWebdavTransportConfiguration( '(b)' );

        $dp      = new ezcWebdavTransportDispatcher();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
                3 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $dp[0]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0 => $second,
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
                3 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetSetFailure()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavTransportDispatcher();

        try
        {
            $dp[4]   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with too large offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetGetSuccess()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new ezcWebdavTransportConfiguration( '(b)' );

        $dp      = new ezcWebdavTransportDispatcher();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
                3 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $this->assertEquals(
            new ezcWebdavTransportConfiguration(
                '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
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
            new ezcWebdavTransportConfiguration(),
            $dp[2],
            'Index 2 not got correctly.'
        );

        $this->assertSame(
            $second,
            $dp[3],
            'Index 3 not got correctly.'
        );
    }

    public function testOffsetGetFailure()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavTransportDispatcher();

        $this->assertNull(
            $dp[3],
            'Offset 3 not null.'
        );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configuration changed on string offset.'
        );
    }

    public function testOffsetUnsetSuccess()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new ezcWebdavTransportConfiguration( '(b)' );

        $dp      = new ezcWebdavTransportDispatcher();
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not created correctly in ctor.'
        );

        $dp[1]   = $first;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet(1).'
        );
        
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
                3 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet(null).'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(),
                2 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0  => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not removed from offset 1 correctly through offsetUnset().'
        );

        unset( $dp[0] );
        
        $this->assertAttributeEquals(
            array(
            ),
            'transportConfigurations',
            $dp,
            'Configurations not removed from offset 0 correctly through offsetUnset().'
        );
    }

    public function testOffsetUnsetFailure()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavTransportDispatcher();

        unset( $dp[3] );
        $this->assertNull(
            $dp[3],
            'Offset 3 not null.'
        );
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0 => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
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
                0 => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetExistsSuccess()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new ezcWebdavTransportConfiguration( '(b)' );

        $dp      = new ezcWebdavTransportDispatcher();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
                3 => $second,
            ),
            'transportConfigurations',
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
    }

    public function testOffsetExistsFailure()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new ezcWebdavTransportConfiguration( '(b)' );

        $dp      = new ezcWebdavTransportDispatcher();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => $first,
                2 => new ezcWebdavTransportConfiguration(),
                3 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $this->assertFalse(
            isset( $dp[-1] ),
            'Offset -1 does seem to be set.'
        );
        $this->assertFalse(
            isset( $dp[4] ),
            'Offset 3 does seem to be set.'
        );
        $this->assertFalse(
            isset( $dp['foo'] ),
            'Offset "foo" does seem to be set.'
        );
    }

    public function testIteratorDefaultCtor()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $fake = array(
                0 => new ezcWebdavTransportConfiguration(
                    '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                    'ezcWebdavMicrosoftCompatibleTransport'
                ),
                1 => new ezcWebdavTransportConfiguration(
                    '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                    'ezcWebdavTransport',
                    'ezcWebdavXmlTool',
                    'ezcWebdavNautilusPropertyHandler'
                ),
                2 => new ezcWebdavTransportConfiguration(),
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
        $dp   = new ezcWebdavTransportDispatcher();
        $dp[] = new ezcWebdavTransportConfiguration( '(.*nautilus.*)i' );
        $dp[] = new ezcWebdavTransportConfiguration( '(.*konqueror.*)i' );

        $fake = array(
            0 => new ezcWebdavTransportConfiguration(
                '(Microsoft\s+Data\s+Access\s+Internet|Mozilla/4.0\s+\(compatible;\s+MSIE\s+6.0;\s+Windows\s+NT\s+5.1\)|Microsoft-WebDAV-MiniRedir)i',
                'ezcWebdavMicrosoftCompatibleTransport'
            ),
            1 => new ezcWebdavTransportConfiguration(
                '(gnome-vfs/[0-9.]+ neon/[0-9.]*)i',
                'ezcWebdavTransport',
                'ezcWebdavXmlTool',
                'ezcWebdavNautilusPropertyHandler'
            ),
            2 => new ezcWebdavTransportConfiguration(),
            3 => new ezcWebdavTransportConfiguration( '(.*nautilus.*)i' ),
            4 => new ezcWebdavTransportConfiguration( '(.*konqueror.*)i' ),
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
        $dp   = new ezcWebdavTransportDispatcher();
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

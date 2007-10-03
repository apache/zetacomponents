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
                0  => new ezcWebdavTransportConfiguration(),
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

        $this->assertAttributeEquals(
            array(
                0  => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
        
        $secondCfg = new ezcWebdavTransportConfiguration(
            'fooregex'
        );

        $dp->insertBefore( $secondCfg );

        $this->assertAttributeEquals(
            array(
                0  => $secondCfg,
                1  => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        $thirdCfg = new ezcWebdavTransportConfiguration(
            'barregex'
        );

        $dp->insertBefore( $thirdCfg, 1 );

        $this->assertAttributeEquals(
            array(
                0  => $secondCfg,
                1  => $thirdCfg,
                2  => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        $dp->insertBefore( $thirdCfg );

        $this->assertAttributeEquals(
            array(
                0  => $thirdCfg,
                1  => $secondCfg,
                2  => $thirdCfg,
                3  => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );
    }
    
    public function testInsertBeforeFailure()
    {
        $dp = new ezcWebdavTransportDispatcher();

        $firstCfg = new ezcWebdavTransportConfiguration();

        $this->assertAttributeEquals(
            array(
                0  => $firstCfg,
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
                0  => $firstCfg,
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
                0  => $firstCfg,
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
                0  => $firstCfg,
            ),
            'transportConfigurations',
            $dp,
            'Default properties not created correctly on empty ctor.'
        );

        try
        {
            $dp->insertBefore( $secondCfg, 1 );
            $this->fail( 'ezcBaseValueException not thrown on to large int $offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(
                0  => $firstCfg,
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
                0 => new ezcWebdavTransportConfiguration(),
                1 => $first,
                2 => $second,
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
                2 => $second,
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
            $dp[2]   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with too large offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        try
        {
            $dp[-2]   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with too small offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        try
        {
            $dp['foo']   = $first;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
        
        try
        {
            $dp[]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and null offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
        
        try
        {
            $dp[]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and null offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
        
        try
        {
            $dp[0]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and 0 offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
        
        try
        {
            $dp[1]    = $second;
            $this->fail( 'ezcBaseValueException not thrown on set access with invalid value and 1 offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
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
                0 => new ezcWebdavTransportConfiguration(),
                1 => $first,
                2 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        $this->assertEquals(
            new ezcWebdavTransportConfiguration(),
            $dp[0],
            'Index 2 not got correctly.'
        );

        $this->assertSame(
            $first,
            $dp[1],
            'Index 2 not got correctly.'
        );

        $this->assertSame(
            $second,
            $dp[2],
            'Index 2 not got correctly.'
        );
    }

    public function testOffsetGetFailure()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavTransportDispatcher();

        try
        {
            echo $dp[2];
            $this->fail( 'ezcBaseValueException not thrown on get access with too large offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        try
        {
            echo $dp[-2];
            $this->fail( 'ezcBaseValueException not thrown on get access with too small offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        try
        {
            echo $dp['foo'];
            $this->fail( 'ezcBaseValueException not thrown on get access with invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetUnsetSuccess()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new ezcWebdavTransportConfiguration( '(b)' );

        $dp      = new ezcWebdavTransportDispatcher();
        $dp[1]   = $first;
        $dp[]    = $second;
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
                1 => $first,
                2 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
                1 => $second,
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        unset( $dp[1] );
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );

        unset( $dp[0] );
        
        $this->assertAttributeEquals(
            array(
            ),
            'transportConfigurations',
            $dp,
            'Configurations not added correctly through offsetSet().'
        );
    }

    public function testOffsetUnsetFailure()
    {
        $first   = new ezcWebdavTransportConfiguration( '(a)' );
        $second  = new stdClass();

        $dp      = new ezcWebdavTransportDispatcher();

        try
        {
            unset( $dp[2] );
            $this->fail( 'ezcBaseValueException not thrown on unset access with too large offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
        
        $this->assertAttributeEquals(
            array(
                0 => new ezcWebdavTransportConfiguration(),
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
                0 => new ezcWebdavTransportConfiguration(),
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
                0 => new ezcWebdavTransportConfiguration(),
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
                0 => new ezcWebdavTransportConfiguration(),
                1 => $first,
                2 => $second,
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
                0 => new ezcWebdavTransportConfiguration(),
                1 => $first,
                2 => $second,
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
            isset( $dp[3] ),
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
            0 => new ezcWebdavTransportConfiguration(),
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
            0 => new ezcWebdavTransportConfiguration(),
            1 => new ezcWebdavTransportConfiguration( '(.*nautilus.*)i' ),
            2 => new ezcWebdavTransportConfiguration( '(.*konqueror.*)i' ),
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

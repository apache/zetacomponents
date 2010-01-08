<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

include_once( 'Authentication/tests/test.php' );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationBignumTest extends ezcAuthenticationTest
{
    public static $tables = array( 'add', 'sub', 'mul', 'div', 'pow', 'mod', 'invert' );

    public static $add = array(
                                array( 0, 0, 0 ),
                                array( 0, 1, 1 ),
                                array( 1, 0, 1 ),
                                array( 1, 1, 2 ),
                                array( -1, 0, -1 ),
                                array( -1, -1, -2 ),
                                array( -1, 1, 0 ),
                                array( -1, 2, 1 ),
                            );

    public static $sub = array(
                                array( 0, 0, 0 ),
                                array( 0, 1, -1 ),
                                array( 1, 0, 1 ),
                                array( 1, 1, 0 ),
                                array( -1, 0, -1 ),
                                array( -1, -1, 0 ),
                                array( -1, 1, -2 ),
                                array( -1, 2, -3 ),
                            );

    public static $mul = array(
                                array( 0, 0, 0 ),
                                array( 0, 1, 0 ),
                                array( 1, 0, 0 ),
                                array( 1, 1, 1 ),
                                array( 2, 3, 6 ),
                                array( -1, 0, 0 ),
                                array( -1, 1, -1 ),
                                array( -1, 2, -2 ),
                                array( -1, -1, 1 ),
                            );

    public static $div = array(
                                array( 0, 1, 0 ),
                                array( 1, 1, 1 ),
                                array( 2, 2, 1 ),
                                array( 6, 3, 2 ),
                                array( 2, 3, 0 ),
                                array( -1, 1, -1 ),
                                array( -2, 1, -2 ),
                                array( -1, -1, 1 ),
                            );

    public static $pow = array(
                                array( 0, 0, 1 ),
                                array( 0, 1, 0 ),
                                array( 1, 0, 1 ),
                                array( 1, 1, 1 ),
                                array( 2, 2, 4 ),
                                array( 2, 3, 8 ),
                                array( -2, 1, -2 ),
                                array( -2, 2, 4 ),
                                array( -2, 3, -8 ),
                            );

    public static $mod = array(
                                array( 0, 1, 0 ),
                                array( 1, 1, 0 ),
                                array( 2, 1, 0 ),
                                array( 2, 2, 0 ),
                                array( 3, 1, 0 ),
                                array( 3, 2, 1 ),
                                array( 3, 3, 0 ),
                                array( 3, 4, 3 ),
                            );

    public static $invert = array(
                                array( 0, 1, 0 ),
                                array( 1, 1, 0 ),
                                array( 2, 1, 0 ),
                                array( 2, 2, 0 ),
                                array( 3, 1, 0 ),
                                array( 3, 2, 1 ),
                                array( 3, 3, 0 ),
                                array( 3, 4, 3 ),
                                array( 3, 5, 2 ),
                                array( 3, 6, 0 ),
                                array( 3, 7, 5 ),
                                array( 1, 7, 1 ),
                                array( 2, 2, 0 ),
                                array( -2, 5, 2 ),
                            );

    public static $powmod = array(
                                array( 0, 0, 5, 1 ),
                                array( 0, 1, 5, 0 ),
                                array( 1, 0, 5, 1 ),
                                array( 1, 1, 5, 1 ),
                                array( 2, 2, 5, 4 ),
                                array( 2, 3, 5, 3 ),
                                array( 2, 1, 5, 2 ),
                                array( 2, 2, 5, 4 ),
                                array( 2, 3, 5, 3 ),
                            );

    public static $gcd = array(
                                array( 3, 2, array( 1, -1, 1 ) ),
                                array( 6, 3, array( 0, 1, 3 ) ),
                                array( 437, 123, array( 38, -135, 1 ) ),
                            );

    public static $p = '155172898181473697471232257763715539915724801966915404479707795314057629378541917580651227423698188993727816152646631438561595825688188889951272158842675419950341258706556549803580104870537681476726513255747040765857479291291572334510643245094715007229621094194349783925984760375594985848253359305585439638443';

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcAuthenticationBignumTest" );
    }

    public function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) &&
             !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath or --with-gmp.' );
        }
    }

    public function tearDown()
    {

    }

    public function testCreateLibraryWrongValue()
    {
        try
        {
            $lib = ezcAuthenticationMath::createBignumLibrary( 'wrong value' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'wrong value' that you were trying to assign to setting 'library' is invalid. Allowed values are: \"gmp\" || \"bcmath\" || null.", $e->getMessage() );
        }
    }

    public function testApr1()
    {
        $val = 'asdfgh';
        $salt = md5( $val );
        $result = ezcAuthenticationMath::apr1( $val, $salt );
        $hashFromHtpasswd = '$apr1$a152e841$qDLZqN37bdBiQGa7SnsIM1';
        $this->assertEquals( $result, $hashFromHtpasswd );
        $this->assertEquals( true, ezcAuthenticationMath::apr1( $val, $hashFromHtpasswd ) === $hashFromHtpasswd );
    }

    public function testGmpTables()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        foreach ( self::$tables as $table )
        {
            foreach ( self::$$table as $i => $line )
            {
                $result = $lib->toString( $lib->$table( $lib->init( $line[0] ), ( $table === 'pow' ) ? $line[1] : $lib->init( $line[1] ) ) );
                $expected = $lib->toString( $lib->init( $line[2] ) );
                $message = get_class( $lib ) . ": {$table}( {$line[0]}, {$line[1]} ) produced {$result}, expected {$expected}.";
                $this->assertEquals( $expected, $result, $message );
            }
        }
    }

    public function testGmpPowmod()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        foreach ( self::$powmod as $i => $line )
        {
            $result = $lib->toString( $lib->powmod( $lib->init( $line[0] ), $lib->init( $line[1] ), $lib->init( $line[2] ) ) );
            $expected = $lib->toString( $lib->init( $line[3] ) );
            $message = get_class( $lib ) . ": powmod( {$line[0]}, {$line[1]}, {$line[2]} ) produced {$result}, expected {$expected}.";
            $this->assertEquals( $expected, $result, $message );
        }
    }

    public function testGmpGcd()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        foreach ( self::$gcd as $i => $line )
        {
            $result = $lib->gcd( $lib->init( $line[0] ), $lib->init( $line[1] ) );
            $result = array( $lib->toString( $result[0] ), $lib->toString( $result[1] ), $lib->toString( $result[2] ) );
            $expected = $line[2];
            $message = get_class( $lib ) . ": gcd( {$line[0]}, {$line[1]} ) produced (" . implode( ',', $result ) . "), expected (" . implode( ',', $expected ) . ").";
            $this->assertEquals( $expected, $result, $message );
        }
    }

    public function testGmpBtwoc()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        $n = $lib->binToDec( $lib->btwoc( self::$p ) );
        $this->assertEquals( self::$p, $n );
    }

    public function testGmpBtwocNegative()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        $n = $lib->btwoc( -1 );
        $this->assertEquals( null, $n );
    }

    public function testGmpBtwocZero()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'gmp' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-gmp.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'gmp' );

        $n = $lib->btwoc( 0 );
        $this->assertEquals( "\x00", $n );
    }

    public function testBcmathTables()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        foreach ( self::$tables as $table )
        {
            foreach ( self::$$table as $i => $line )
            {
                $result = $lib->toString( $lib->$table( $lib->init( $line[0] ), $lib->init( $line[1] ) ) );
                $expected = $lib->toString( $lib->init( $line[2] ) );
                $message = get_class( $lib ) . ": {$table}( {$line[0]}, {$line[1]} ) produced {$result}, expected {$expected}.";
                $this->assertEquals( $expected, $result, $message );
            }
        }
    }

    public function testBcmathPowmod()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        foreach ( self::$powmod as $i => $line )
        {
            $result = $lib->toString( $lib->powmod( $lib->init( $line[0] ), $lib->init( $line[1] ), $lib->init( $line[2] ) ) );
            $expected = $lib->toString( $lib->init( $line[3] ) );
            $message = get_class( $lib ) . ": powmod( {$line[0]}, {$line[1]}, {$line[2]} ) produced {$result}, expected {$expected}.";
            $this->assertEquals( $expected, $result, $message );
        }
    }

    public function testBcmathGcd()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        foreach ( self::$gcd as $i => $line )
        {
            $result = $lib->gcd( $lib->init( $line[0] ), $lib->init( $line[1] ) );
            $result = array( $lib->toString( $result[0] ), $lib->toString( $result[1] ), $lib->toString( $result[2] ) );
            $expected = $line[2];
            $message = get_class( $lib ) . ": gcd( {$line[0]}, {$line[1]} ) produced (" . implode( ',', $result ) . "), expected (" . implode( ',', $expected ) . ").";
            $this->assertEquals( $expected, $result, $message );
        }
    }

    public function testBcmathBtwoc()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        $n = $lib->binToDec( $lib->btwoc( self::$p ) );
        $this->assertEquals( self::$p, $n );
    }

    public function testBcmathBtwocNegative()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        $n = $lib->btwoc( -1 );
        $this->assertEquals( null, $n );
    }

    public function testBcmathBtwocZero()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'bcmath' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --enable-bcmath.' );
        }

        $lib = ezcAuthenticationMath::createBignumLibrary( 'bcmath' );

        $n = $lib->btwoc( 0 );
        $this->assertEquals( "\x00", $n );
    }
}
?>

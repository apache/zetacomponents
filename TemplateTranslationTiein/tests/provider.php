<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */

/**
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */
class ezcTemplateTranslationProviderTest extends ezcTestCase
{
    public function setUp()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = null;
    }

    public function testTranslateManagerNotConfigured()
    {
        try
        {
            ezcTemplateTranslationProvider::translate( "Test", "test", array() );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcTemplateTranslationManagerNotConfiguredException $e )
        {
            self::assertEquals( "The manager property of the ezcTemplateTranslationConfiguration has not been configured.", $e->getMessage() );
        }
    }

    public function testTranslate()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( 'Test Eén', ezcTemplateTranslationProvider::translate( "Test 1", "test", array() ) );
    }

    public function testTranslateWithNumericParams()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( 'Test Eén (a, c, b)', ezcTemplateTranslationProvider::translate( "Test 1 %1 %2 %3", "test", array( 1 => 'a', 'b', 'c' ) ) );
    }

    public function testTranslateWithNumericParamsWithMissingParam()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::translate( "Test 1 %1 %2 %3", "test", array( 1 => 'a', 'b' ) );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%3' does not exist.", $e->getMessage() );
        }
    }

    public function testTranslateWithNamedParams()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( 'Test Eén (a, c, b)', ezcTemplateTranslationProvider::translate( "Test 1 %un %deux %trois", "test", array( 'un' => 'a', 'deux' => 'b', 'trois' => 'c', 'quatre' => 'd' ) ) );
    }

    public function testTranslateWithNamedParamsWithMissingParam()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::translate( "Test 1 %un %deux %trois", "test", array( 'un' => 'a', 'trois' => 'b' ) );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%deux' does not exist.", $e->getMessage() );
        }
    }

    public function testTranslateWithWrongKey()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::translate( "Test 2", "test", array() );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationKeyNotAvailableException $e )
        {
            self::assertEquals( "The key 'Test 2' does not exist in the translation map.", $e->getMessage() );
        }
    }

    public function testTranslateWithWrongContext()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::translate( "Test 3", "test2", array() );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationContextNotAvailableException $e )
        {
            self::assertEquals( "The context 'test2' does not exist.", $e->getMessage() );
        }
    }

    public function testCompile()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( "'Test Eén'", ezcTemplateTranslationProvider::compile( "Test 1", "test", array() ) );
    }

    public function testCompileWithNumericParams()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( "'Test Eén (' . a . ', ' . c . ', ' . b . ')'", ezcTemplateTranslationProvider::compile( "Test 1 %1 %2 %3", "test", array( 1 => 'a', 'b', 'c' ) ) );
    }

    public function testCompileWithNumericParamsWithMissingParam()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::compile( "Test 1 %1 %2 %3", "test", array( 1 => 'a', 'b' ) );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%3' does not exist.", $e->getMessage() );
        }
    }

    public function testCompileWithQuote()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( "'He that loves to be flattered is worthy o\'' .  the flatterer . '.'", ezcTemplateTranslationProvider::compile( "Test with quotes in result", "test", array( 'hvem' => ' the flatterer' ) ) );
    }

    public function testCompileWithNamedParams()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        self::assertEquals( "'Test Eén (' . a . ', ' . c . ', ' . b . ')'", ezcTemplateTranslationProvider::compile( "Test 1 %un %deux %trois", "test", array( 'un' => 'a', 'deux' => 'b', 'trois' => 'c', 'quatre' => 'd' ) ) );
    }

    public function testCompileWithNamedParamsWithMissingParam()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::compile( "Test 1 %un %deux %trois", "test", array( 'un' => 'a', 'trois' => 'b' ) );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%deux' does not exist.", $e->getMessage() );
        }
    }

    public function testCompileWithWrongKey()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::compile( "Test 2", "test", array() );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationKeyNotAvailableException $e )
        {
            self::assertEquals( "The key 'Test 2' does not exist in the translation map.", $e->getMessage() );
        }
    }

    public function testCompileWithWrongContext()
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ttc->manager = new ezcTranslationManager( new ezcTranslationTsBackend( dirname( __FILE__ ) . '/translations' ) );

        try
        {
            ezcTemplateTranslationProvider::compile( "Test 3", "test2", array() );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationContextNotAvailableException $e )
        {
            self::assertEquals( "The context 'test2' does not exist.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcTemplateTranslationProviderTest' );
    }
}

?>

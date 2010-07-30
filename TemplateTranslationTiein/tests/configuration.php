<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */

/**
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */
class ezcTemplateTranslationConfigurationTest extends ezcTestCase
{
    public function testGetInstance()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        $t->locale = "test";
        $t2 = ezcTemplateTranslationConfiguration::getInstance();

        self::assertEquals( "test", $t2->locale );
        self::assertSame( $t, $t2 );
    }

    public function testWrongLocale()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        try
        {
            $t->locale = 42;
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '42' that you were trying to assign to setting 'locale' is invalid. Allowed values are: string.", $e->getMessage() );
        }
    }

    public function testWrongManager()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        $t->manager = null;
        try
        {
            $t->manager = 42;
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '42' that you were trying to assign to setting 'manager' is invalid. Allowed values are: instance of ezcTranslationManager or null.", $e->getMessage() );
        }
    }

    public function testSetUnknownProperty()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        try
        {
            $t->notHere = 42;
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertEquals( "No such property name 'notHere'.", $e->getMessage() );
        }
    }

    public function testGetUnknownProperty()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        try
        {
            $foo = $t->notHere;
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertEquals( "No such property name 'notHere'.", $e->getMessage() );
        }
    }

    public function testSetManager()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        $t->manager = null;
        $t->manager = new ezcTranslationManager( new ezcTranslationTsBackend( '.' ) );
        self::assertType( 'ezcTranslationManager', $t->manager );
    }

    public function testGetManagerException()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        $t->manager = null;
        try
        {
            $manager = $t->manager;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcTemplateTranslationManagerNotConfiguredException $e )
        {
            self::assertEquals( "The manager property of the ezcTemplateTranslationConfiguration has not been configured.", $e->getMessage() );
        }
    }

    public function testIsset()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        $t->manager = null;

        self::assertEquals( false, isset( $t->manager ) );
        self::assertEquals( true, isset( $t->locale ) );

        $t->manager = new ezcTranslationManager( new ezcTranslationTsBackend( '.' ) );
        self::assertType( 'ezcTranslationManager', $t->manager );
        self::assertEquals( true, isset( $t->manager ) );
    }

    public function testIssetUnknownProperty()
    {
        $t = ezcTemplateTranslationConfiguration::getInstance();
        self::assertEquals( false, isset( $t->notHere ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcTemplateTranslationConfigurationTest' );
    }
}
?>

<?php
/**
 * ezcTreeVisitorYUIOptionsTest
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
 * @package Tree
 * @version //autogentag//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Tests for ezcTreeVisitorOptions class.
 * 
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeVisitorYUIOptionsTest extends ezcTestCase
{
    public function testDefaultSettings()
    {
        $options = new ezcTreeVisitorYUIOptions;

        self::assertSame( '', $options->basePath );
        self::assertSame( false, $options->displayRootNode );
        self::assertSame( array(), $options->highlightNodeIds );
        self::assertSame( false, $options->selectedNodeLink );
    }

    public function testGetUnknownProperty()
    {
        $options = new ezcTreeVisitorYUIOptions;
        try
        {
            $dummy = $options->unknown;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testSetValidOptionValues1()
    {
        $options = new ezcTreeVisitorYUIOptions;

        $options->basePath = '/view';
        $options->displayRootNode = true;
        $options->highlightNodeIds = array( 'root' );
        $options->selectedNodeLink = true;

        self::assertSame( '/view', $options->basePath );
        self::assertSame( true, $options->displayRootNode );
        self::assertSame( array( 'root' ), $options->highlightNodeIds );
        self::assertSame( true, $options->selectedNodeLink );
    }

    public function testSetValidOptionValues2()
    {
        $optionsArray = array();
        $optionsArray['basePath'] = '/view';
        $optionsArray['displayRootNode'] = true;
        $optionsArray['highlightNodeIds'] = array( 'root' );
        $optionsArray['selectedNodeLink'] = true;

        $options = new ezcTreeVisitorYUIOptions( $optionsArray );

        self::assertSame( '/view', $options->basePath );
        self::assertSame( true, $options->displayRootNode );
        self::assertSame( array( 'root' ), $options->highlightNodeIds );
        self::assertSame( true, $options->selectedNodeLink );
    }

    public function testSetInvalidBasePath()
    {
        $options = new ezcTreeVisitorYUIOptions;
        try
        {
            $options->basePath = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'basePath' is invalid. Allowed values are: string.", $e->getMessage() );
        }
    }

    public function testSetInvalidDisplayRootNode()
    {
        $options = new ezcTreeVisitorYUIOptions;
        try
        {
            $options->displayRootNode = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'displayRootNode' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testSetInvalidSelectedNodeLink()
    {
        $options = new ezcTreeVisitorYUIOptions;
        try
        {
            $options->selectedNodeLink = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'selectedNodeLink' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testSetInvalidHighlightNodes()
    {
        $options = new ezcTreeVisitorYUIOptions;
        try
        {
            $options->highlightNodeIds = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'highlightNodeIds' is invalid. Allowed values are: array(string).", $e->getMessage() );
        }
    }

    public function testSetUnknownProperty()
    {
        $options = new ezcTreeVisitorYUIOptions;
        try
        {
            $options->unknown = 42;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcTreeVisitorYUIOptionsTest" );
    }
}
?>

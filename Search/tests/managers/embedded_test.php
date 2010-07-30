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
 * @package Search
 * @subpackage Tests
 */

require_once 'Search/tests/testfiles/test-classes.php';

/**
 * Test the XML definition reader.
 *
 * @package Search
 * @subpackage Tests
 */
class ezcSearchEmbeddedDefinitionManager extends ezcTestCase
{
    public function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
    }

    public function testMissingIdProperty()
    {
        $m = new ezcSearchEmbeddedManager();
        try
        {
            $d = $m->fetchDefinition( 'MissingID' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDefinitionInvalidException $e )
        {
            self::assertEquals( "The embedded definition file for 'MissingID' is invalid (Missing ID property).", $e->getMessage() );
        }
    }

    public function testDefinitionProviderNotImplemented()
    {
        $m = new ezcSearchEmbeddedManager();
        try
        {
            $d = $m->fetchDefinition( 'UnknownType' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcSearchDoesNotProvideDefinitionException $e )
        {
            self::assertEquals( "The class 'UnknownType' does not implement the ezcSearchDefinitionProvider interface.", $e->getMessage() );
        }
    }

    public function testReadDefinition()
    {
        $m = new ezcSearchEmbeddedManager();
        $d = $m->fetchDefinition( 'EmbeddedArticle' );

        self::assertEquals( 'id', $d->idProperty );
        self::assertEquals( array( 'id', 'title', 'summary', 'body', 'published' ), $d->getFieldNames() );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['id']->type );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['title']->type );
        self::assertEquals( ezcSearchDocumentDefinition::TEXT, $d->fields['summary']->type );
        self::assertEquals( ezcSearchDocumentDefinition::HTML, $d->fields['body']->type );
        self::assertEquals( ezcSearchDocumentDefinition::DATE, $d->fields['published']->type );
        self::assertEquals( 2, $d->fields['title']->boost );

        self::assertEquals( false, $d->fields['body']->inResult );
        self::assertEquals( true, $d->fields['summary']->inResult );
        self::assertEquals( true, $d->fields['title']->inResult );
    }

    public function testReadDefinitionFromCache()
    {
        $m = new ezcSearchEmbeddedManager();
        $e = $m->fetchDefinition( 'EmbeddedArticle' );
        $d = $m->fetchDefinition( 'EmbeddedArticle' );

        self::assertEquals( 'id', $d->idProperty );
        self::assertEquals( array( 'id', 'title', 'summary', 'body', 'published' ), $d->getFieldNames() );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['id']->type );
        self::assertEquals( ezcSearchDocumentDefinition::STRING, $d->fields['title']->type );
        self::assertEquals( ezcSearchDocumentDefinition::TEXT, $d->fields['summary']->type );
        self::assertEquals( ezcSearchDocumentDefinition::HTML, $d->fields['body']->type );
        self::assertEquals( ezcSearchDocumentDefinition::DATE, $d->fields['published']->type );
        self::assertEquals( 2, $d->fields['title']->boost );

        self::assertEquals( false, $d->fields['body']->inResult );
        self::assertEquals( true, $d->fields['summary']->inResult );
        self::assertEquals( true, $d->fields['title']->inResult );

        self::assertSame( $e, $d );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSearchEmbeddedDefinitionManager" );
    }
}
?>

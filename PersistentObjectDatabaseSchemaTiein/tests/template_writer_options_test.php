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
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */

/**
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */
class ezcPersistentObjectTemplateSchemaWriterOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(__CLASS__ );
    }

    public function testDefaultCtor()
    {
        $opts = new ezcPersistentObjectTemplateSchemaWriterOptions();
        
        $this->assertEquals(
            realpath( dirname( __FILE__ ) . '/../src/template_writer/templates' ),
            realpath( $opts->templatePath )
        );

        $this->assertEquals(
            '.',
            $opts->templateCompilePath
        );

        $this->assertFalse(
            $opts->overwrite
        );

        $this->assertEquals(
            '',
            $opts->classPrefix
        );
    }

    public function testNonDefaultCtor()
    {
        $opts = new ezcPersistentObjectTemplateSchemaWriterOptions(
            array(
                'templatePath'        => dirname( __FILE__ ),
                'templateCompilePath' => dirname( __FILE__ ),
                'overwrite'           => true,
                'classPrefix'         => 'foo'
            )
        );
        
        $this->assertEquals(
            dirname( __FILE__ ),
            $opts->templatePath
        );

        $this->assertEquals(
            dirname( __FILE__ ),
            $opts->templateCompilePath
        );

        $this->assertTrue(
            $opts->overwrite
        );

        $this->assertEquals(
            'foo',
            $opts->classPrefix
        );
    }

    public function testSetSuccess()
    {
        $opts = new ezcPersistentObjectTemplateSchemaWriterOptions();

        $this->assertSetProperty(
            $opts,
            'templatePath',
            array(
                dirname( __FILE__ ),
                '.'
            )
        );
        $this->assertSetProperty(
            $opts,
            'templateCompilePath',
            array(
                dirname( __FILE__ ),
                '.'
            )
        );
        $this->assertSetProperty(
            $opts,
            'overwrite',
            array(
                true,
                false
            )
        );
        $this->assertSetProperty(
            $opts,
            'classPrefix',
            array(
                'foo',
                ''
            )
        );
    }

    public function testSetFailure()
    {
        $opts = new ezcPersistentObjectTemplateSchemaWriterOptions();

        $this->assertSetPropertyFails(
            $opts,
            'templatePath',
            array(
                '/some/weird/path/that/does/not/exist',
                __FILE__,
                true,
                23,
                42.23,
                array(),
                new stdClass()
            )
        );
        $this->assertSetPropertyFails(
            $opts,
            'templateCompilePath',
            array(
                '/some/weird/path/that/does/not/exist',
                __FILE__,
                true,
                23,
                42.23,
                array(),
                new stdClass()
            )
        );
        $this->assertSetPropertyFails(
            $opts,
            'overwrite',
            array(
                'foo',
                23,
                42.23,
                array(),
                new stdClass()
            )
        );
        $this->assertSetPropertyFails(
            $opts,
            'classPrefix',
            array(
                true,
                false,
                23,
                42.23,
                array(),
                new stdClass()
            )
        );

        try
        {
            $opts->fooBar = true;
            $this->fail( 'Exception not thrown on set access to non existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testGetPropertyFails()
    {
        $opts = new ezcPersistentObjectTemplateSchemaWriterOptions();

        try
        {
            echo $opts->fooBar;
            $this->fail( 'Exception not thrown on get access to non existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIsset()
    {
        $opts = new ezcPersistentObjectTemplateSchemaWriterOptions();

        $this->assertTrue(
            isset( $opts->templatePath )
        );
        $this->assertTrue(
            isset( $opts->templateCompilePath )
        );
        $this->assertTrue(
            isset( $opts->overwrite )
        );
        $this->assertTrue(
            isset( $opts->classPrefix )
        );
        $this->assertFalse(
            isset( $opts->fooBar )
        );
    }
}
?>

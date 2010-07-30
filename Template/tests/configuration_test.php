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
 * @package Template
 * @subpackage Tests
 */

require_once 'test_classes.php';

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateConfigurationTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateConfigurationTest" );
    }

    protected function setUp()
    {
        $this->basePath = realpath( dirname( __FILE__ ) ) . '/';
        $this->templatePath = $this->basePath . 'templates/';
        $this->templateStorePath = $this->basePath . 'stored_templates/';
    }

// Doesn't work if other tests are run as well.
//    public function testDelayedInit()
//    {
//        ezcBaseInit::setCallback( 'ezcInitTemplateConfiguration', 'testDelayedInitTemplateConfiguration' );
//        $config = ezcTemplateConfiguration::getInstance();
//        $this->assertEquals( new ezcTemplateNoContext, $config->context );
//    }

    public function testDefault()
    {
        $conf = new ezcTemplateConfiguration();

        $this->assertSame( '.', $conf->templatePath );
        $this->assertSame( './compiled_templates', $conf->compilePath . DIRECTORY_SEPARATOR . $conf->compiledTemplatesPath);
    }

    public function testInit()
    {
        $conf = new ezcTemplateConfiguration( 'templates', 'compiled' );

        $this->assertSame( 'templates', $conf->templatePath );
        $this->assertSame( 'compiled/compiled_templates', $conf->compilePath . DIRECTORY_SEPARATOR . $conf->compiledTemplatesPath );
    }

    public function testInvalidProperties()
    {
        $conf = new ezcTemplateConfiguration();

        // try to access non-existing property
        try
        {
            $invalid = $conf->invalid;
            self::fail( 'Property invalid does not throw not-found exception' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
        }
    }

    public function testModifyProperties()
    {
        $conf = new ezcTemplateConfiguration();

        // try to set invalid types for autoloadDefinitions
        $this->assertSetPropertyFails( $conf, 'autoloadDefinitions',
                                       array( true, false, 2, 2.0, 'string' ) );
        // Try to set valid path entries
        $this->assertSetProperty( $conf, 'templatePath',
                                  array( 'templates', '.', '/var/templates' ) );
        $this->assertSetProperty( $conf, 'compilePath',
                                  array( 'compiled-templates', '.', '/var/cache/templates' ) );
    }

//     public function testAutoloaderRegistration()
//     {
//         throw new PHPUnit_Framework_IncompleteTestError;
//     }
}

?>

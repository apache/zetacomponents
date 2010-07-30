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
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 */
class ezcWorkflowDatabaseTieinOptionsTest extends ezcTestCase
{
    protected $options;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(
          'ezcWorkflowDatabaseTieinOptionsTest'
        );
    }

    protected function setUp()
    {
        $this->options = new ezcWorkflowDatabaseOptions;
    }

    public function testOptions()
    {
        $this->assertTrue( isset( $this->options['prefix'] ) );
        $this->assertEquals( '', $this->options['prefix'] );

        $this->options['prefix'] = 'myPrefix';
        $this->assertEquals( 'myPrefix', $this->options['prefix'] );
    }

    public function testOptions2()
    {
        try
        {
            $this->options['prefix'] = null;
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( 'The value \'\' that you were trying to assign to setting \'prefix\' is invalid. Allowed values are: string.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBaseValueException to be thrown.' );
    }

    public function testOptions3()
    {
        try
        {
            $this->options['foo'] = 'bar';
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( 'No such property name \'foo\'.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBasePropertyNotFoundException to be thrown.' );
    }
}
?>

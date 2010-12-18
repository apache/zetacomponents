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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */

require_once 'data/testclasses.php';

/**
 * @package Archive
 * @version //autogen//
 * @subpackage Tests
 */
class ezcArchiveOptionsTest extends ezcTestCase
{
    public function testReadOnly()
    {
        $options = new ezcArchiveOptions;
        $options->readOnly = true;
        self::assertTrue( $options->readOnly );
        $options->readOnly = false;
        self::assertFalse( $options->readOnly );
    }

    public function testReadOnlyWrong()
    {
        try
        {
            $options = new ezcArchiveOptions;
            $options->readOnly = null;
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '' that you were trying to assign to setting 'readOnly' is invalid. Allowed values are: bool.", $e->getMessage() );
        }
    }

    public function testCallback()
    {
        $options = new ezcArchiveOptions;
        $options->extractCallback = null;
        self::assertNull( $options->extractCallback );

        $options->extractCallback = new testExtractCallback;
        self::assertInstanceOf( 'ezcArchiveCallback', $options->extractCallback );
    }

    public function testCallbackWrong()
    {
        try
        {
            $options = new ezcArchiveOptions;
            $options->extractCallback = "foobar";
            self::fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value 'foobar' that you were trying to assign to setting 'extractCallback' is invalid. Allowed values are: instance of ezcArchiveCallback.", $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>

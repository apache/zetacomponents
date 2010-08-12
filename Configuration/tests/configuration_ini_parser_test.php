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
 * @version //autogentag//
 * @filesource
 * @package Configuration
 * @subpackage Tests
 */

/**
 * @package Configuration
 * @subpackage Tests
 */
class ezcConfigurationIniParserTest extends ezcTestCase
{
    public function testNonExistingFile()
    {
        try
        {
            $parser = new ezcConfigurationIniParser( ezcConfigurationIniParser::PARSE, 'Configuration/tests/files/not-here.ini' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals( "The file 'Configuration/tests/files/not-here.ini' could not be found.", $e->getMessage() );
        }
    }

    public function testIterator1()
    {
        $parser = new ezcConfigurationIniParser( ezcConfigurationIniParser::PARSE, 'Configuration/tests/files/one-group.ini' );
        try
        {
            foreach ( $parser as $item )
            {
            }
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( Exception $e )
        {
            $this->assertEquals( 'You can only use this implementation of the iterator with a NoRewindIterator.', $e->getMessage() );
        }
    }

    public function testIterator2()
    {
        $parser = new ezcConfigurationIniParser( ezcConfigurationIniParser::PARSE, 'Configuration/tests/files/multi-dim2.ini' );
        foreach ( new NoRewindIterator( $parser ) as $key => $item )
        {
            $this->assertSame( 0, $key );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcConfigurationIniParserTest' );
    }

}
?>

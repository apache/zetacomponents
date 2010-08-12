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
 * @package Debug
 * @subpackage Tests
 */

/**
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugMemoryWriterTest extends ezcTestCase
{
	protected function setUp()
	{        
        date_default_timezone_set("UTC");
        $this->writer = new ezcDebugMemoryWriter();
	}

    public function testSingleMessage()
    {
        $this->writer->reset();
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $data = $this->writer->getStructure();

        $this->assertEquals($data[0]->message, "msg");
        $this->assertEquals($data[0]->verbosity, 2);
        $this->assertEquals($data[0]->severity, 1);
        $this->assertEquals($data[0]->source, "src");
        $this->assertEquals($data[0]->category, "cat");
        $this->assertNotEquals($data[0]->datetime, "");
    }

    public function testTwoMessages()
    {
        $this->writer->reset();
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg2", 12, "src2", "cat2", array("verbosity" => 22) );
        $data = $this->writer->getStructure();

        $this->assertEquals($data[0]->message, "msg");
        $this->assertEquals($data[0]->verbosity, 2);
        $this->assertEquals($data[0]->severity, 1);
        $this->assertEquals($data[0]->source, "src");
        $this->assertEquals($data[0]->category, "cat");
        $this->assertNotEquals($data[0]->datetime, "");

        $this->assertEquals($data[1]->message, "msg2");
        $this->assertEquals($data[1]->verbosity, 22);
        $this->assertEquals($data[1]->severity, 12);
        $this->assertEquals($data[1]->source, "src2");
        $this->assertEquals($data[1]->category, "cat2");
        $this->assertNotEquals($data[1]->datetime, "");

        $this->assertEquals(count( $data ), 2);
    }

    public function testMultipleMessages()
    {
        $this->writer->reset();
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $data = $this->writer->getStructure();

        $this->assertEquals(count( $data ), 6);
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcDebugMemoryWriterTest" );
    }
}
?>

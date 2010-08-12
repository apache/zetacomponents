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
 * @package EventLog
 * @subpackage Tests
 */

/**
 * @package EventLog
 * @subpackage Tests
 */
class ezcLogUnixFileWriterTest extends ezcTestCase
{
    protected $writer;

    protected function setUp()
    {
        $this->createTempDir("ezcLogTest_");
        $this->writer = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testFileStructure()
    {
        $m = array("message" => "Alien alert.", "type" => 1, "source" => "UFO report", "category" => "fake warning" );
        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[UFO report\] \[fake warning\] Alien alert./";

        $this->assertRegExp($regExp, "Jan 24 09:32:26 [Debug] [UFO report] [fake warning] Alien alert.", "Testing myself");

        $this->writer->writeLogMessage( $m["message"], $m["type"], $m["source"], $m["category"] );
        $this->assertRegExp( $regExp, file_get_contents( $this->getTempDir() ."/default.log" ), 
                                "Content of default.log doesn't match with the regular expression.");
    }

    public function testExtraFields()
    {
        $m = array("message" => "Alien alert.", "type" => 1, "source" => "UFO report", "category" => "fake warning");
        $extra = array ("Line" => 42);
        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[UFO report\] \[fake warning\] Alien alert. \(Line: 42\)/";

        $this->writer->writeLogMessage( $m["message"], $m["type"], $m["source"], $m["category"], $extra );
        $this->assertRegExp( $regExp, file_get_contents( $this->getTempDir() ."/default.log" ), 
                                "Content of default.log doesn't match with the regular expression.");
    }

    public function testCategoryEmpty()
    {
        $m = array("message" => "Alien alert.", "type" => 1, "source" => "UFO report", "category" => false);
        $extra = array ("Line" => 42);
        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[UFO report\] Alien alert. \(Line: 42\)/";

        $this->writer->writeLogMessage( $m["message"], $m["type"], $m["source"], $m["category"], $extra );
        $this->assertRegExp( $regExp, file_get_contents( $this->getTempDir() ."/default.log" ), 
                                "Content of default.log doesn't match with the regular expression.");
    }

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite("ezcLogUnixFileWriterTest");
	}
}

?>

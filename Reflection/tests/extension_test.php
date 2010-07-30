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
 * @version //autogen//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionExtensionTest extends ezcTestCase
{
	/**
	 * @var ReflectionExtension
	 */
	protected $phpExtRef;
	protected $phpExtSpl;

	/**
	 * @var ezcReflectionExtension
	 */
	protected $extRef;
	protected $extSpl;

    public function setUp() {
        $this->phpExtRef = new ReflectionExtension('Reflection');
        $this->phpExtSpl = new ReflectionExtension('Spl');
        $this->extRef = new ezcReflectionExtension('Reflection');
        $this->extSpl = new ezcReflectionExtension('Spl');
    }

    public function tearDown() {
        unset($this->phpExtRef);
        unset($this->phpExtSpl);
        unset($this->extRef);
        unset($this->extSpl);
    }

    public function testGetFunctions() {
        $functs = $this->extRef->getFunctions();
        foreach ($functs as $func) {
            self::assertType('ezcReflectionFunction', $func);
        }
        self::assertEquals(0, count($functs));
    }

    public function testGetClasses() {
        $classes = $this->extRef->getClasses();

        foreach ($classes as $class) {
            self::assertType('ezcReflectionClass', $class);
        }
    }

    public function testToString() {
        self::assertEquals( (string) $this->phpExtRef, (string) $this->extRef);
        self::assertEquals( (string) $this->phpExtSpl, (string) $this->extSpl);
    }

    public function testGetName() {
    	self::assertEquals('SPL', $this->extSpl->getName());
    	self::assertEquals('Reflection', $this->extRef->getName());
    }

    public function testGetVersion() {
    	$version = $this->extRef->getVersion();
    	self::assertFalse(empty($version));
    }

    public function testInfo() {
    	ob_start();
    	$this->extRef->info();
    	$info = ob_get_clean();
    	self::assertFalse(empty($info));
    }

    public function testGetConstants() {
    	$constants = $this->extRef->getConstants();
    	self::assertTrue(empty($constants));
    }

    public function testGetINIEntries() {
    	$iniEntries = $this->extRef->getINIEntries();
    	self::assertTrue(empty($iniEntries));
    }

    public function testGetClassNames() {
    	$classNames = $this->extRef->getClassNames();
    	self::assertFalse(empty($classNames));
    }

    public function testGetDependencies() {
        self::assertEquals( $this->phpExtRef->getDependencies(), $this->extRef->getDependencies() );
        self::assertEquals( $this->phpExtSpl->getDependencies(), $this->extSpl->getDependencies() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionExtensionTest" );
    }
}
?>

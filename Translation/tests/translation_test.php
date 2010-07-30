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
 * @package Translation
 * @subpackage Tests
 */

/**
 * @package Translation
 * @subpackage Tests
 */
class ezcTranslationTest extends ezcTestCase
{
    private static function setUpTestArray()
    {
        $array = array();
        $array[] = new ezcTranslationData( 'This is a translatable string', 'Dit is een vertaalbare zin', '', ezcTranslationData::TRANSLATED );
        $array[] = new ezcTranslationData( '%Apples are not %pears', '%Pears zijn niet hetzelfde als %apples', '', ezcTranslationData::TRANSLATED );
        $array[] = new ezcTranslationData( 'A %1 is not a %2', 'Een %1 is geen %2', '', ezcTranslationData::TRANSLATED );
        return $array;
    }
    
    public function testGetExistingString()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        $string = $obj->getTranslation( 'This is a translatable string' );
        self::assertEquals( 'Dit is een vertaalbare zin', $string );
    }

    public function testCompileExistingString()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        $string = $obj->compileTranslation( 'This is a translatable string' );
        self::assertEquals( "'Dit is een vertaalbare zin'", $string );
    }

    public function testGetNonExistingString()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        try
        {
            $string = $obj->getTranslation( 'Unknown string' );
            self::fail( 'Expected exception "Key not available" was not thrown' );
        }
        catch ( ezcTranslationKeyNotAvailableException $e )
        {
            self::assertEquals( "The key 'Unknown string' does not exist in the translation map.", $e->getMessage() );
        }
    }

    public function testCompileNonExistingString()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        try
        {
            $string = $obj->compileTranslation( 'Unknown string' );
            self::fail( 'Expected exception "Key not available" was not thrown' );
        }
        catch ( ezcTranslationKeyNotAvailableException $e )
        {
            self::assertEquals( "The key 'Unknown string' does not exist in the translation map.", $e->getMessage() );
        }
    }

    public function testGetStringWithParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        $string = $obj->getTranslation( '%Apples are not %pears', array( 'apples' => 'appelen', 'pears' => 'peren' ) );
        self::assertEquals( 'Peren zijn niet hetzelfde als appelen', $string );
    }

    public function testCompileStringWithParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        $string = $obj->compileTranslation( '%Apples are not %pears', array( 'apples' => '$appelen', 'pears' => '$peren' ) );
        self::assertEquals( "'' . ucfirst(\$peren) . ' zijn niet hetzelfde als ' . \$appelen . ''", $string );
    }

    public function testGetStringWithMissingParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        try
        {
            $string = $obj->getTranslation( '%Apples are not %pears', array( 'apples' => 'appelen' ) );
            self::fail( 'Expected exception "Parameter missing" was not thrown' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%Pears' does not exist.", $e->getMessage() );
        }
    }

    public function testCompileStringWithMissingParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        try
        {
            $string = $obj->compileTranslation( '%Apples are not %pears', array( 'apples' => 'appelen' ) );
            self::fail( 'Expected exception "Parameter missing" was not thrown' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%Pears' does not exist.", $e->getMessage() );
        }
    }

    public function testGetStringWithNumericalParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        $string = $obj->getTranslation( 'A %1 is not a %2', array( 1 => 'koe', 2 => 'paard' ) );
        self::assertEquals( 'Een koe is geen paard', $string );
    }

    public function testCompileStringWithNumericalParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        $string = $obj->compileTranslation( 'A %1 is not a %2', array( 1 => '$koe', 2 => '$paard' ) );
        self::assertEquals( '\'Een \' . $koe . \' is geen \' . $paard . \'\'', $string );
    }

    public function testStringWithMissingNumericalParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        try
        {
            $string = $obj->getTranslation( 'A %1 is not a %2', array( 1 => 'koe' ) );
            self::fail( 'Expected exception "Parameter missing" was not thrown' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%2' does not exist.", $e->getMessage() );
        }
    }

    public function testCompileStringWithMissingNumericalParameters()
    {
        $obj = new ezcTranslation( ezcTranslationTest::setUpTestArray() );
        try
        {
            $string = $obj->compileTranslation( 'A %1 is not a %2', array( 1 => 'koe' ) );
            self::fail( 'Expected exception "Parameter missing" was not thrown' );
        }
        catch ( ezcTranslationParameterMissingException $e )
        {
            self::assertEquals( "The parameter '%2' does not exist.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTranslationTest" );
    }
}

?>

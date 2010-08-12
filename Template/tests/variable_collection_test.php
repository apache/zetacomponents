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
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateVariableCollectionTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateVariableCollectionTest" );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $col = new ezcTemplateVariableCollection();

        $col->number = 6;
        self::assertEquals( $col->number, 6 );
    }

    public function testForeachIteration()
    {
        $send = new ezcTemplateVariableCollection();

        $send->red = "FF0000";
        $send->green = "00FF00";
        $send->blue = "0000FF";

        $a = array();

        foreach ( $send as $name => $value )
        {
            $a[$name] = $value;
        }

        self::assertEquals( "FF0000", $a["red"] );
        self::assertEquals( "00FF00", $a["green"] );
        self::assertEquals( "0000FF", $a["blue"] );
    }

}

?>

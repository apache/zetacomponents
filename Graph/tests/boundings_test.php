<?php
/**
 * ezcGraphBoundingsTest 
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
 * @package Graph
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Tests for ezcGraph class.
 * 
 * @package Graph
 * @subpackage Tests
 */
class ezcGraphBoundingsTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcGraphBoundingsTest" );
	}

    public function testCreateBoundings()
    {
        $boundings = new ezcGraphBoundings( 0, 1, 10, 11 );

        $this->assertEquals( $boundings->x0, 0 );
        $this->assertEquals( $boundings->y0, 1 );
        $this->assertEquals( $boundings->x1, 10 );
        $this->assertEquals( $boundings->y1, 11 );
    }

    public function testPseudoProperties()
    {
        $boundings = new ezcGraphBoundings( 0, 1, 10, 21 );

        $this->assertEquals( $boundings->width, 10 );
        $this->assertEquals( $boundings->height, 20 );
    }

    public function testCreateReverseBoundings()
    {
        $boundings = new ezcGraphBoundings( 10, 11, 0, 1 );

        $this->assertEquals( $boundings->x0, 0 );
        $this->assertEquals( $boundings->y0, 1 );
        $this->assertEquals( $boundings->x1, 10 );
        $this->assertEquals( $boundings->y1, 11 );
    }

    public function testUnknownBoundingsProperty()
    {
        $boundings = new ezcGraphBoundings( 10, 11, 0, 1 );

        try
        {
            $boundings->unknown;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }
}

?>
